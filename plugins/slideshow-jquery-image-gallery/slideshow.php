<?php
/*
 Plugin Name: Slideshow
 Plugin URI: http://wordpress.org/extend/plugins/slideshow-jquery-image-gallery/
 Description: This plugin offers a slideshow that is easily deployable in your website. Add any image that has already been uploaded to add to your slideshow. Options and styles are customizable for every single slideshow on your website.
 Version: 2.1.17
 Requires at least: 3.3
 Author: StefanBoonstra
 Author URI: http://stefanboonstra.com
 License: GPL
*/

/**
 * Class SlideshowPluginMain fires up the application on plugin load and provides some
 * methods for the other classes to use like the auto-includer and the
 * base path/url returning method.
 *
 * @author Stefan Boonstra
 * @version 13-10-12
 */
class SlideshowPluginMain {

	/** Variables */
	static $version = '2.1.17';

	/**
	 * Bootstraps the application by assigning the right functions to
	 * the right action hooks.
	 */
	static function bootStrap(){
		self::autoInclude();

		// Initialize localization on init
		add_action('init', array(__CLASS__, 'localize'));

		// For ajax requests
		SlideshowPluginAjax::init();

		// Deploy slideshow on do_action('slideshow_deploy'); hook.
		add_action('slideshow_deploy', array('SlideshowPlugin', 'deploy'));

		// Initialize shortcode
		SlideshowPluginShortcode::init();

		// Register widget
		add_action('widgets_init', array('SlideshowPluginWidget', 'registerWidget'));

		// Register slideshow post type
		SlideshowPluginPostType::initialize();

		// Transfers v1.x.x slides to the new slide format
		register_activation_hook(__FILE__, array(__CLASS__, 'transferV1toV2'));
	}

	/**
	 * Transfers v1.x.x slides to the new slide format
	 */
	static function transferV1toV2(){
		// Check if this has already been done
		if(get_option('slideshow-plugin-updated-from-v1-x-x-to-v2-0-1') !== false)
			return;

		// Get posts
		$posts = get_posts(array(
			'numberposts' => -1,
			'offset' => 0,
			'post_type' => SlideshowPluginPostType::$postType
		));

		// Loop through posts
		if(is_array($posts) && count($posts) > 0){
			foreach($posts as $post){

				// Stores highest slide id.
				$highestSlideId = -1;

				// Get stored slide settings and convert them to array([slide-key] => array([setting-name] => [value]));
				$slidesPreOrder = array();
				$settings = SlideshowPluginPostType::getSettings($post->ID, SlideshowPluginPostType::$prefixes['slide-list'], true);
				if(is_array($settings) && count($settings) > 0)
					foreach($settings as $key => $value){
						$key = explode('_', $key);
						if(is_numeric($key[1]))
							$slidesPreOrder[$key[1]][$key[2]] = $value;
					}

				// Save slide keys from the $slidePreOrder array in the array itself for later use
				if(count($slidesPreOrder) > 0)
					foreach($slidesPreOrder as $key => $value){
						// Save highest slide id
						if($key > $highestSlideId)
							$highestSlideId = $key;
					}

				// Get defaults
				$defaultData = SlideshowPluginPostType::getDefaultData(false);

				// Get old data
				$oldData = get_post_meta($post->ID, SlideshowPluginPostType::$settingsMetaKey, true);
				if(!is_array(($oldData)))
					$oldData = array();

				// Get attachments
				$attachments = get_posts(array(
					'numberposts' => -1,
					'offset' => 0,
					'post_type' => 'attachment',
					'post_parent' => $post->ID
				));

				// Get data from attachments
				$newData = array();
				if(is_array($attachments) && count($attachments) > 0)
					foreach($attachments as $attachment){
						$highestSlideId++;
						$newData['slide_' . $highestSlideId . '_postId'] = $attachment->ID;
						$newData['slide_' . $highestSlideId . '_type'] = 'attachment';
					}

				// Save settings
				update_post_meta(
					$post->ID,
					SlideshowPluginPostType::$settingsMetaKey,
					array_merge(
						$defaultData,
						$oldData,
						$newData
					));
			}
		}

		update_option('slideshow-plugin-updated-from-v1-x-x-to-v2-0-1', 'updated');
	}

	/**
	 * Translates the plugin
	 */
	static function localize(){
		load_plugin_textdomain(
			'slideshow-plugin',
			false,
			dirname(plugin_basename(__FILE__)) . '/languages/'
		);
	}

	/**
	 * Returns url to the base directory of this plugin.
	 *
	 * @return string pluginUrl
	 */
	static function getPluginUrl(){
		return plugins_url('', __FILE__);
	}

	/**
	 * Returns path to the base directory of this plugin
	 *
	 * @return string pluginPath
	 */
	static function getPluginPath(){
		return dirname(__FILE__);
	}

	/**
	 * This function will load classes automatically on-call.
	 */
	function autoInclude(){
		if(!function_exists('spl_autoload_register'))
			return;

		function slideshowFileAutoloader($name) {
			$name = str_replace('\\', DIRECTORY_SEPARATOR, $name);
			$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $name . '.php';

			if(is_file($file))
				require_once $file;
		}

		spl_autoload_register('slideshowFileAutoloader');
	}
}

/**
 * Activate plugin
 */
SlideShowPluginMain::bootStrap();