<?php
/**
 * SlideshowPluginPostType creates a post type specifically designed for
 * slideshows and their individual settings
 *
 * @author: Stefan Boonstra
 * @version: 13-10-12
 */
class SlideshowPluginPostType {

	/** Variables */
	static $postType = 'slideshow';
	static $settingsMetaKey = 'settings';
	static $prefixes = array(
		'slide-list' => 'slide_',
		'style' => 'style_',
		'settings' => 'setting_',
	);
	static $settings = null;
	static $inputFields = null;

	/**
	 * Initialize Slideshow post type.
	 * Called on load of plugin
	 */
	static function initialize(){
		add_action('init', array(__CLASS__, 'registerSlideshowPostType'));
		add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue'));
		add_action('save_post', array(__CLASS__, 'save'));
	}

	/**
	 * Registers new posttype slideshow
	 */
	static function registerSlideshowPostType(){
		register_post_type(
			self::$postType,
			array(
				'labels' => array(
					'name' => __('Slideshows', 'slideshow-plugin'),
					'singlular_name' => __('Slideshow', 'slideshow-plugin'),
					'add_new_item' => __('Add New Slideshow', 'slideshow-plugin'),
					'edit_item' => __('Edit slideshow', 'slideshow-plugin'),
					'new_item' => __('New slideshow', 'slideshow-plugin'),
					'view_item' => __('View slideshow', 'slideshow-plugin'),
					'search_items' => __('Search slideshows', 'slideshow-plugin'),
					'not_found' => __('No slideshows found', 'slideshow-plugin'),
					'not_found_in_trash' => __('No slideshows found', 'slideshow-plugin')
				),
				'public' => false,
				'publicly_queryable' => false,
				'show_ui' => true,
				'show_in_menu' => true,
				'query_var' => true,
				'rewrite' => true,
				'capability_type' => 'post',
				'has_archive' => true,
				'hierarchical' => false,
				'menu_position' => null,
				'menu_icon' => SlideshowPluginMain::getPluginUrl() . '/images/' . __CLASS__ . '/adminIcon.png',
				'supports' => array('title'),
				'register_meta_box_cb' => array(__CLASS__, 'registerMetaBoxes')
			)
		);
	}

	/**
	 * Enqueues scripts and stylesheets for when the admin page
	 * is a slideshow edit page.
	 */
	static function enqueue(){
		$currentScreen = get_current_screen();
		if($currentScreen->post_type != self::$postType)
			return;

		// Enqueue associating script
		wp_enqueue_script(
			'post-type-handler',
			SlideshowPluginMain::getPluginUrl() . '/js/' . __CLASS__ . '/post-type-handler.js',
			array('jquery')
		);

		// TODO: These scripts have been moved here from the footer. They need to be always printed in the header
		// TODO: a solution for this needs to be found.
		// Enqueue scripts required for sorting the slides list
		//wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-sortable');

		// Enqueue JSColor
		wp_enqueue_script('jscolor-colorpicker', SlideshowPluginMain::getPluginUrl() . '/js/SlideshowPluginPostType/jscolor/jscolor.js');

		// Enqueue slide insert script and style
		SlideshowPluginSlideInserter::enqueueFiles();
	}

	/**
	 * Adds custom meta boxes to slideshow post type.
	 */
	static function registerMetaBoxes(){
		add_meta_box(
			'information',
			__('Information', 'slideshow-plugin'),
			array(__CLASS__, 'informationMetaBox'),
			self::$postType,
			'normal',
			'high'
		);

		add_meta_box(
			'slides-list',
			__('Slides List', 'slideshow-plugin'),
			array(__CLASS__, 'slidesMetaBox'),
			self::$postType,
			'side',
			'default'
		);

		add_meta_box(
			'style',
			__('Slideshow Style', 'slideshow-plugin'),
			array(__CLASS__, 'styleMetaBox'),
			self::$postType,
			'normal',
			'low'
		);

		add_meta_box(
			'settings',
			__('Slideshow Settings', 'slideshow-plugin'),
			array(__CLASS__, 'settingsMetaBox'),
			self::$postType,
			'normal',
			'low'
		);

		// Add support plugin message on edit slideshow
		if(isset($_GET['action']) && strtolower($_GET['action']) == strtolower('edit'))
			add_action('admin_notices', array(__CLASS__,  'supportPluginMessage'));
	}

	/**
	 * Shows the support plugin message
	 */
	static function supportPluginMessage(){
		include(SlideshowPluginMain::getPluginPath() . '/views/' . __CLASS__ . '/support-plugin.php');
	}

	/**
	 * Shows some information about this slideshow
	 */
	static function informationMetaBox(){
		global $post;

		$snippet = htmlentities(sprintf('<?php do_action(\'slideshow_deploy\', \'%s\'); ?>', $post->ID));
		$shortCode = htmlentities(sprintf('[' . SlideshowPluginShortcode::$shortCode . ' id=\'%s\']', $post->ID));

		include(SlideshowPluginMain::getPluginPath() . '/views/' . __CLASS__ . '/information.php');
	}

	/**
	 * Shows slides currently in slideshow
	 */
	static function slidesMetaBox(){
		global $post;

		// Stores highest slide id.
		$highestSlideId = -1;

		// Get stored slide settings and convert them to array([slide-key] => array([setting-name] => [value]));
		$slidesPreOrder = array();
		$settings = self::getSettings($post->ID, self::$prefixes['slide-list']);
		if(is_array($settings) && count($settings) > 0)
			foreach($settings as $key => $value){
				$key = explode('_', $key);
				if(is_numeric($key[1]))
					$slidesPreOrder[$key[1]][$key[2]] = $value;
			}

		// Save slide keys from the $slidePreOrder array in the array itself for later use
		if(count($slidesPreOrder) > 0)
			foreach($slidesPreOrder as $key => $value){
				$slidesPreOrder[$key]['id'] = $key;

				// Save highest slide id
				if($key > $highestSlideId)
					$highestSlideId = $key;
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

		// Set url from which a substitute icon can be fetched
		$noPreviewIcon = SlideshowPluginMain::getPluginUrl() . '/images/' . __CLASS__ . '/no-img.png';

		// Include slides preview file
		include(SlideshowPluginMain::getPluginPath() . '/views/' . __CLASS__ . '/slides.php');
	}

	/**
	 * Shows style used for slideshow
	 */
	static function styleMetaBox(){
		global $post;

		// Get settings
		$settings = self::getSettings($post->ID, self::$prefixes['style']);

		// Fill custom style with default css if empty
		if(isset($settings['style_custom']) && empty($settings['style_custom'][1])){
			ob_start();
			include(SlideshowPluginMain::getPluginPath() . '/style/SlideshowPlugin/style-custom.css');
			$settings['style_custom'][1] = ob_get_clean();
		}

		// Build fields
		$inputFields = self::getInputFields($settings, false);

		// Include style settings file
		include(SlideshowPluginMain::getPluginPath() . '/views/' . __CLASS__ . '/style-settings.php');
	}

	/**
	 * Shows settings for particular slideshow
	 */
	static function settingsMetaBox(){
		global $post;

		// Get settings
		$settings = self::getSettings($post->ID, self::$prefixes['settings']);
		$inputFields = self::getInputFields($post->ID);

		// Include
		include(SlideshowPluginMain::getPluginPath() . '/views/' . __CLASS__ . '/settings.php');
	}

	/**
	 * Called for saving metaboxes
	 *
	 * @param int $postId
	 * @return int $postId On failure
	 */
	static function save($postId){
		// Verify nonce, check if user has sufficient rights and return on auto-save.
		if((isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], plugin_basename(__FILE__))) ||
			!current_user_can('edit_post', $postId) ||
			defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return $postId;

		// Get defaults
		$defaultData = self::getDefaultData(false);

		// Get old data
		$oldData = get_post_meta($postId, self::$settingsMetaKey, true);
		if(!is_array(($oldData)))
			$oldData = array();

		// Filter new data from $_POST
		$newData = array();
		if(is_array($_POST) && count($_POST) > 0)
			foreach($_POST as $key => $value)
				if(is_array(self::$prefixes) && count(self::$prefixes) > 0)
					foreach(self::$prefixes as $prefix)
						if($prefix == substr($key, 0, strlen($prefix)))
							$newData[$key] = htmlspecialchars($value);

		// Save settings
		update_post_meta(
			$postId,
			self::$settingsMetaKey,
			array_merge(
				$defaultData,
				$oldData,
				$newData
		));

		return $postId;
	}

	/**
	 * Restores some HTML in a string after using the htmlspecialchars() function on it.
	 * Therefore, to be able to show the allowed HTML tags in a string, use this function.
	 *
	 * @param string $string The htmlspecialchars() string
	 * @return string  $string The exceptionized string.
	 */
	static function htmlspecialchars_decodeOnlyAllowed($string){


		return $string;
	}

	/**
	 * Get simplified settings. This means there won't be an array full of
	 * field information and data. There will simply be a key => value pair
	 * with the retrieved settings or, if that value is empty, the default setting
	 *
	 * @param int $postId
	 * @param string $prefix (optional, defaults to null)
	 * @param bool $cacheEnabled (optional, defaults to true)
	 * @return mixed $simpleSettings
	 */
	static function getSimpleSettings($postId, $prefix = null, $cacheEnabled = true){
		$settings = self::getSettings($postId, $prefix, $cacheEnabled);

		$simpleSettings = array();
		if(is_array($settings) && count($settings) > 0)
			foreach($settings as $key => $value){
				if(!is_array($value))
					continue;

				if(empty($value[1]) && !is_numeric($value[1]))
					$simpleSettings[$key] = $value[2];
				else $simpleSettings[$key] = $value[1];
			}

		return $simpleSettings;
	}

	/**
	 * Gets settings for the slideshow with the parsed post id.
	 * When only the data with a particular prefix needs to be returned, pass the prefix as $prefix
	 *
	 * @param int $postId
	 * @param string $prefix (optional, defaults to null)
	 * @param bool $cacheEnabled (optional, defaults to true)
	 * @return mixed $settings
	 */
	static function getSettings($postId, $prefix = null, $cacheEnabled = true){
		if(!is_numeric($postId) || empty($postId))
			return array();

		if(!isset(self::$settings) || !$cacheEnabled){
			// Get default data
			$data = self::getDefaultData();

			// Get settings
			$currentSettings = get_post_meta(
				$postId,
				self::$settingsMetaKey,
				true
			);

			// Fill data with settings
			if(is_array($data) && count($data) > 0)
				foreach($data as $key => $value)
					if(isset($currentSettings[$key])){
						$data[$key][1] = $currentSettings[$key];
						unset($currentSettings[$key]);
					}

			// Load settings that are not there by default into data (slides in particular)
			if(is_array($currentSettings) && count($currentSettings) > 0)
				foreach($currentSettings as $key => $value)
					if(!isset($data[$key]))
						$data[$key] = $value;

			$settings = $data;
			if($cacheEnabled)
				self::$settings = $data;
		}else{
			$settings = self::$settings;
		}

		if(isset($prefix))
			if(is_array($settings) && count($settings) > 0)
				foreach($settings as $key => $value)
					if($prefix != substr($key, 0, strlen($prefix)))
						unset($settings[$key]);

		return $settings;
	}

	/**
	 * Gets defdault data. If only default data (without field information) is needed, set fullDefinition to false.
	 *
	 * @param boolean $fullDefinition (optional, defaults to true)
	 * @return mixed $defaultData
	 */
	static function getDefaultData($fullDefinition = true){
		$data = array(
			'style_style' => __('light', 'slideshow-plugin'),
			'style_custom' => '',
			'setting_animation' => __('slide', 'slideshow=plugin'),
			'setting_slideSpeed' => '1',
			'setting_descriptionSpeed' => '0.4',
			'setting_intervalSpeed' => '5',
			'setting_play' => 'true',
			'setting_loop' => 'true',
			'setting_slidesPerView' => '1',
			'setting_width' => '0',
			'setting_height' => '200',
			'setting_descriptionHeight' => '50',
			'setting_stretchImages' => 'true',
			'setting_controllable' => 'true',
			'setting_controlPanel' => 'false',
			'setting_showDescription' => 'true',
			'setting_hideDescription' => 'true',
			'setting_random' => 'false',
			//'setting_cssInHeader' => 'false',
			'setting_avoidFilter' => 'true'
		);

		if($fullDefinition){
			$yes = __('Yes', 'slideshow-plugin');
			$no = __('No', 'slideshow-plugin');
			$data = array( // $data : array([prefix_settingName] => array([inputType], [value], [default], [description], array([options]), array([dependsOn], [onValue]), 'group' => [groupName]))
				'style_style' => array('select', '', $data['style_style'], __('The style used for this slideshow', 'slideshow-plugin'), array('light' => __('Light', 'slideshow-plugin'), 'dark' => __('Dark', 'slideshow-plugin'), 'custom' => __('Custom', 'slideshow-plugin'))),
				'style_custom' => array('textarea', '', $data['style_custom'], __('Custom style editor', 'slideshow-plugin'), null, array('style_style', 'custom')),
				'setting_animation' => array('select', '', $data['setting_animation'], __('Animation used for transition between slides', 'slideshow-plugin'), array('slide' => __('Slide', 'slideshow-plugin'), 'fade' => __('Fade', 'slideshow-plugin')), 'group' => __('Animation', 'slideshow-plugin')),
				'setting_slideSpeed' => array('text', '', $data['setting_slideSpeed'], __('Number of seconds the slide takes to slide in', 'slideshow-plugin'), 'group' => __('Animation', 'slideshow-plugin')),
				'setting_descriptionSpeed' => array('text', '', $data['setting_descriptionSpeed'], __('Number of seconds the description takes to slide in', 'slideshow-plugin'), 'group' => __('Animation', 'slideshow-plugin')),
				'setting_intervalSpeed' => array('text', '', $data['setting_intervalSpeed'], __('Seconds between changing slides', 'slideshow-plugin'), 'group' => __('Animation', 'slideshow-plugin')),
				'setting_slidesPerView' => array('text', '', $data['setting_slidesPerView'], __('Number of slides to fit into one slide', 'slideshow-plugin'), 'group' => __('Display', 'slideshow-plugin')),
				'setting_width' => array('text', '', $data['setting_width'], __('Width of the slideshow, set to parent&#39;s width on 0', 'slideshow-plugin'), 'group' => __('Display', 'slideshow-plugin')),
				'setting_height' => array('text', '', $data['setting_height'], __('Height of the slideshow', 'slideshow-plugin'), 'group' => __('Display', 'slideshow-plugin')),
				'setting_descriptionHeight' => array('text', '', $data['setting_descriptionHeight'], __('Height of the description boxes', 'slideshow-plugin'), 'group' => __('Display', 'slideshow-plugin')),
				'setting_stretchImages' => array('radio', '', $data['setting_stretchImages'], __('Fit image into slide (stretching it)', 'slideshow-plugin'), array('true' => $yes, 'false' => $no), 'group' => __('Display', 'slideshow-plugin')),
				'setting_showDescription' => array('radio', '', $data['setting_showDescription'], __('Show title and description', 'slideshow-plugin'), array('true' => $yes, 'false' => $no), 'group' => __('Display', 'slideshow-plugin')),
				'setting_hideDescription' => array('radio', '', $data['setting_hideDescription'], __('Hide description box, it will pop up when a mouse hovers over the slide', 'slideshow-plugin'), array('true' => $yes, 'false' => $no), array('setting_showDescription', 'true'), 'group' => __('Display', 'slideshow-plugin')),
				'setting_play' => array('radio', '', $data['setting_play'], __('Automatically slide to the next slide', 'slideshow-plugin'), array('true' => $yes, 'false' => $no), 'group' => __('Control', 'slideshow-plugin')),
				'setting_loop' => array('radio', '', $data['setting_loop'], __('Return to the beginning of the slideshow after last slide', 'slideshow-plugin'), array('true' => $yes, 'false' => $no), 'group' => __('Control', 'slideshow-plugin')),
				'setting_controllable' => array('radio', '', $data['setting_controllable'], __('Activate buttons (so the user can scroll through the slides)', 'slideshow-plugin'), array('true' => $yes, 'false' => $no), 'group' => __('Control', 'slideshow-plugin')),
				'setting_controlPanel' => array('radio', '', $data['setting_controlPanel'], __('Show control panel (play and pause button)', 'slideshow-plugin'), array('true' => $yes, 'false' => $no), 'group' => __('Control', 'slideshow-plugin')),
				'setting_random' => array('radio', '', $data['setting_random'], __('Randomize slides', 'slideshow-plugin'), array('true' => $yes, 'false' => $no), 'group' => __('Miscellaneous', 'slideshow-plugin')),
				//'setting_cssInHeader' => array('radio', '', $data['setting_cssInHeader'], __('Load all CSS in the \'&lt;head&gt;\' area', 'slideshow-plugin'), array('true' => $yes, 'false' => $no), 'group' => __('Miscellaneous', 'slideshow-plugin')),
				'setting_avoidFilter' => array('radio', '', $data['setting_avoidFilter'], sprintf(__('Avoid content filter (disable if \'%s\' is shown)', 'slideshow-plugin'), SlideshowPluginShortcode::$bookmark), array('true' => $yes, 'false' => $no), 'group' => __('Miscellaneous', 'slideshow-plugin'))
			);
		}

		return $data;
	}

	/**
	 * Get all attachments attached to the parsed postId
	 *
	 * @param int $postId
	 * @return mixed $attachments
	 */
	static function getAttachments($postId){
		if(!is_numeric($postId))
			return array();

		return get_posts(array(
			'post_type' => 'attachment',
			'numberposts' => -1,
			'post_status' => null,
			'post_parent' => $postId
		));
	}

	/**
	 * Gets all input fields based on the list of obtained settings
	 *
	 * @param mixed|int $settings
	 * @param bool $cacheEnabled (optional, defaults to true)
	 * @return mixed $inputFields
	 */
	private static function getInputFields($settings, $cacheEnabled = true){
		if(is_numeric($settings))
			$settings = self::getSettings($settings);
		elseif(empty($settings))
			return array();

		if(!isset(self::$inputFields) || !$cacheEnabled){
			$inputFields = array();
			if(is_array($settings) && count($settings) > 0){
				foreach($settings as $key => $value){
					if(!is_array($value))
						continue;

					$inputField = '';
					$displayValue = (empty($value[1]) && !is_numeric($value[1]) ? $value[2] : $value[1]);
					$class = ((isset($value[5]))? 'depends-on-field-value ' . $value[5][0] . ' ' . $value[5][1] . ' ': '') . $key;
					switch($value[0]){
						case 'text':
							$inputField .= '<input
								type="text"
								name="' . $key . '"
								class="' . $class . '"
								value="' . $displayValue . '"
							/>';
							break;
						case 'textarea':
							$inputField .= '<textarea
								name="' . $key . '"
								class="' . $class . '"
								rows="20"
								cols="60"
							>' . $displayValue . '</textarea>';
							break;
						case 'select':
							$inputField .= '<select name="' . $key . '" class="' . $class . '">';
							if(is_array($value[4]) && count($value[4]) > 0){
								foreach($value[4] as $optionKey => $optionValue){
									$inputField .= '<option value="' . $optionKey . '" ' . selected($displayValue, $optionKey, false) . '>
										' . $optionValue . '
									</option>';
								}
							}
							$inputField .= '</select>';
							break;
						case 'radio':
							if(is_array($value[4]) && count($value[4]) > 0){
								foreach($value[4] as $radioKey => $radioValue){
									$inputField .= '<label><input
										type="radio"
										name="' . $key . '"
										class="' . $class . '"
										value="' . $radioKey . '" ' .
										checked($displayValue, $radioKey, false) .
										' />' . $radioValue . '</label><br />';
								}
							}
							break;
						default:
							$inputField = null;
							break;
					};

					$inputFields[$key] = $inputField;
				}
			}

			if($cacheEnabled)
				self::$inputFields = $inputFields;
		}else{
			$inputFields = self::$inputFields;
		}

		return $inputFields;
	}
}