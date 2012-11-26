<?php
/**
 * Class SlideslowPlugin is called whenever a slideshow do_action tag is come across.
 * Responsible for outputting the slideshow's HTML, CSS and Javascript.
 *
 * TODO Create a variable in which all slideshow html can be stored <- Rethink this, slideshow containers have random ids.
 * @author: Stefan Boonstra
 * @version: 22-09-12
 */
class SlideshowPlugin {

	/**
	 * Function deploy prints out the prepared html
	 *
	 * @param int $postId
	 */
	static function deploy($postId = null){
		echo self::prepare($postId);
	}

	/**
	 * Function prepare returns the required html and enqueues
	 * the scripts and stylesheets necessary for displaying the slideshow
	 *
	 * Passing this function no parameter or passing it a negative one will
	 * result in a random pick of slideshow
	 *
	 * @param int $postId
	 * @return String $output
	 */
	static function prepare($postId = null){
		// Get post by its ID, or by its slug
		if(is_numeric($postId))
			$post = wp_get_single_post($postId);
		if(is_string($postId)){
			$query = new WP_Query(array(
				'post_type' => SlideshowPluginPostType::$postType,
				'name' => $postId,
				'orderby' => 'post_date',
				'order' => 'DESC'
			));

			if($query->have_posts())
				$post = $query->next_post();
		}

		// When no slideshow is found, get one at random
		if(empty($post)){
			$post = get_posts(array(
				'numberposts' => 1,
				'orderby' => 'rand',
				'post_type' => SlideshowPluginPostType::$postType
			));

			if(is_array($post))
				$post = $post[0];
		}

		// Exit on error
		if(empty($post)){echo 'dayum';
			return '<!-- Wordpress Slideshow - No slideshows available -->';
		}

		// Get settings
		$allSettings = SlideshowPluginPostType::getSimpleSettings($post->ID, null, false);

		// Get stored slide settings and convert them to array([slide-key] => array([setting-name] => [value]));
		$slidesPreOrder = array();
		$slideSettings = SlideshowPluginPostType::getSettings($post->ID, SlideshowPluginPostType::$prefixes['slide-list'], false);
		if(is_array($slideSettings) && count($slideSettings) > 0)
			foreach($slideSettings as $key => $value){
				$key = explode('_', $key);
				if(is_numeric($key[1]))
					$slidesPreOrder[$key[1]][$key[2]] = $value;
			}

		// Create array ordered by the 'order' key of the slides array: array([order-key] => [slide-key]);
		$slidesOrder = array();
		if(count($slidesPreOrder) > 0){
			foreach($slidesPreOrder as $key => $value)
				if(isset($value['order']) && is_numeric($value['order']) && $value['order'] > 0)
					$slidesOrder[$value['order']][] = $key;
		}
		ksort($slidesOrder);

		// Order slides by the order key.
		$slides = array();
		if(count($slidesOrder) > 0)
			foreach($slidesOrder as $value)
				if(is_array($value))
					foreach($value as $slideId){
						$slides[] = $slidesPreOrder[$slideId];
						unset($slidesPreOrder[$slideId]);
					}

		// Add remaining (unordered) slides to the end of the array.
		$slides = array_merge($slides, $slidesPreOrder);

		// Randomize if setting is true.
		if(isset($allSettings['setting_random']) && $allSettings['setting_random'] == 'true')
			shuffle($slides);

		// Enqueue functional sheet
		wp_enqueue_style(
			'slideshow_functional_style',
			SlideshowPluginMain::getPluginUrl() . '/style/' . __CLASS__ . '/functional.css'
		);

		// Create a microtime timestamp to host multiple slideshows with different styles and settings on the same page
		$randomId = rand();

		// Get stylesheet for printing
		$style = '';
		if($allSettings['style_style'] == 'custom' && isset($allSettings['style_custom']) && !empty($allSettings['style_custom'])){ // Custom style
			$style = str_replace('%plugin-url%', SlideshowPluginMain::getPluginUrl(), $allSettings['style_custom']);
		}else{ // Set style
			$filePath = SlideshowPluginMain::getPluginPath() . '/style/' . __CLASS__ . '/style-' . $allSettings['style_style'] . '.css';
			if(file_exists(SlideshowPluginMain::getPluginPath() . '/style/' . __CLASS__ . '/style-' . $allSettings['style_style'] . '.css')){
				ob_start();
				include($filePath);
				$style = str_replace('%plugin-url%', SlideshowPluginMain::getPluginUrl(), ob_get_clean());
			}
		}

		// Append the random ID to the slideshow container in the stylesheet, to identify multiple slideshows
		if(!empty($style))
			$style = str_replace('.slideshow_container', '.slideshow_container_' . $randomId, $style);

		// Filter settings to only contain settings, then remove prefix
		$settings = array();
		if(is_array($allSettings) && count($allSettings) > 0)
			foreach($allSettings as $key => $value)
				if(SlideshowPluginPostType::$prefixes['settings'] == substr($key, 0, strlen(SlideshowPluginPostType::$prefixes['settings'])))
					$settings[substr($key, strlen(SlideshowPluginPostType::$prefixes['settings']))] = $value;

		// Include output file that stores output in $output.
		$output = '';
		ob_start();
		include(SlideshowPluginMain::getPluginPath() . '/views/' . __CLASS__ . '/slideshow.php');
		$output .= ob_get_clean();

		// Enqueue flash object creation script
		wp_enqueue_script(
			'swfobject',
			SlideshowPluginMain::getPluginUrl() . '/js/' . __CLASS__ . 'swfobject.js'
		);

		// Enqueue slideshow script
		wp_enqueue_script(
			'slideshow_script',
			SlideshowPluginMain::getPluginUrl() . '/js/' . __CLASS__ . '/slideshow.js',
			array('jquery')
		);

		// Return output
		return $output;
	}
}