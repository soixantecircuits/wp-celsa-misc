<?php

define('LACANDSNW_YOU_HAVE_NOT_ADDED_ANY_API_KEY',  __('You have not added any API Key'));
define('LACANDSNW_API_KEY_ADDED',                   __('API Key has been added successfully'));
define('LACANDSNW_ERROR_LOADING_API_KEYS',          __('Error occured while trying to load the API Keys. Please try again later'));
define('LACANDSNW_CURRENTLY_PUBLISHING',        	__('You are currently Publishing your Blog to'));
define('LACANDSNW_SOCIAL_NETWORKS',                 __('Networks'));
define('LACANDSNW_SOCIAL_NETWORK',                  __('Network'));
define('LACANDSNW_PLUGIN_NAME',                     __('cs'));
define('LACANDSNW_PLUGIN_VERSION',                  '5.0.1');
define('LACANDSNW_WP_PLUGIN_URL',                  	lacandsnw_get_plugin_dir());
define('LACANDSNW_WIDGET_NAME_POST_EDITOR', 		'1-Click');


add_action('admin_notices', 'lacandsnw_auth_errors');


function lacandsnw_set_options() {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if(is_array($options)) {
		if(!array_key_exists('lacandsnw_auth_error_show', $options)) {
			$options['lacandsnw_auth_error_show'] = 1;
		}
		if(!array_key_exists('lacandsnw_mixed_mode_alert_show', $options)) {
			$options['lacandsnw_mixed_mode_alert_show'] = 1;
		}	
	} else {
		$options['lacandsnw_auth_error_show'] = 1;
		$options['lacandsnw_mixed_mode_alert_show'] = 1;
	}	
	update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
}

function lacandsnw_load_options() {
	global $lacandsnw_auth_error_show, $lacandsnw_mixed_mode_alert_show;
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if(is_array($options)) {
		//Auth Error show hide
    	if(array_key_exists('lacandsnw_auth_error_show', $options)) {
			$lacandsnw_auth_error_show = $options['lacandsnw_auth_error_show'];
			if($lacandsnw_auth_error_show) {
				$lacandsnw_auth_error_show = 'checked';	
			} else {
				$lacandsnw_auth_error_show = '';
			}
		} else {
			$lacandsnw_auth_error_show = 'checked';
		}
		//Mixed Mode Alert
    	if(array_key_exists('lacandsnw_mixed_mode_alert_show', $options)) {
			$lacandsnw_mixed_mode_alert_show = $options['lacandsnw_mixed_mode_alert_show'];
			if($lacandsnw_mixed_mode_alert_show) {
				$lacandsnw_mixed_mode_alert_show = 'checked';	
			} else {
				$lacandsnw_mixed_mode_alert_show = '';
			}
		} else {
			$lacandsnw_mixed_mode_alert_show = 'checked';
		}
	} else {
		$lacandsnw_auth_error_show = 'checked';
		$lacandsnw_mixed_mode_alert_show = 'checked';
	}
	lacandsnw_mixed_mode();
}


add_action('admin_head', 'lacandsnw_save_options_javascript');

function lacandsnw_save_options_javascript() {
?>
<script type="text/javascript" >
jQuery(document).ready(function($) {
	jQuery(".lacandsnw_options").live("click", function() {
		var this_form = jQuery(this).parents('form:first');
		var lacandsnw_ajax_msg = jQuery(this).parents(".lacandsnw_content_box:first").prev();
		lacandsnw_ajax_msg.show();
		lacandsnw_ajax_msg.html('Updating...');
		jQuery.post(ajaxurl, this_form.serialize(), function(data) {
			lacandsnw_ajax_msg.html('Setting has been updated successfully');
			oneclick_msg_fade(lacandsnw_ajax_msg);
		});
        return false;
    });

});
</script>
<?php
}
add_action('wp_ajax_lacandsnw_save_options', 'lacandsnw_save_options');

function lacandsnw_create_post_meta_box() {
	add_meta_box( 'lacandsnw_meta_box', LAECHONW_WIDGET_NAME, 'lacandsnw_post_meta_box', 'post', 'side', 'high' );
    add_meta_box( 'lacandsnw_meta_box', LAECHONW_WIDGET_NAME, 'lacandsnw_post_meta_box', 'page', 'side', 'high' );
    add_meta_box( 'lacandsnw_meta_box', LAECHONW_WIDGET_NAME, 'lacandsnw_post_meta_box', 'link', 'side', 'high' );
    if(function_exists('get_post_types')) {
        $args=array('public'   => true,
                    '_builtin' => false);
        $post_types=get_post_types($args, '');
        foreach($post_types as $key=>$val) {
            add_meta_box( 'lacandsnw_meta_box', LAECHONW_WIDGET_NAME, 'lacandsnw_post_meta_box', $val->name, 'side', 'core', array($key) );
        }
    }
}

function lacandsnw_post_meta_box($object, $box) {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	$this_post_type = $object -> post_type;
	if(!$this_post_type) {
	     $this_post_type = $box['args'][0];
	}
	//1 Click Publish
	$curr_val = get_post_meta( $object->ID, '_lacands_meta_show', true );
	if($curr_val == '') {
		$curr_val = 1;
	}
    $html  = '<div class="misc-pub-section">';
	if($curr_val) {
		$html .= '<input type="checkbox" name="lacands_meta_cb_show"    id="lacands_meta_cb_show" checked />';
	} else {
		$html .= '<input type="checkbox" name="lacands_meta_cb_show"    id="lacands_meta_cb_show" />';
	}
	$html .= '&nbsp;<label for="lacands_meta_cb_show">Show Social Buttons</a></label>';
	//Hidden
	$html .= '<input type="hidden" name="lacands_meta_nonce" value="'. wp_create_nonce( plugin_basename( __FILE__ ) ).'" />';
	$html .= '</div>';
	//Published
	$lacandsnw_meta_published = get_post_meta($object -> ID, '_lacandsnw_meta_published', true);
		if (in_array($lacandsnw_meta_published, array('done', 'failed'))) {
		$inputs_disabled = 'disabled="disabled"';
	} else {
		$inputs_disabled = '';
	}
	$curr_val_publish = get_post_meta($object -> ID, '_lacandsnw_meta_publish', true);
	if ($curr_val_publish == '') {
		$curr_val_publish = 1;
	}
	$html .= '<div class="misc-pub-section">';
	$html_label = '&nbsp;<label for="lacandsnw_meta_cb_publish">' . __('Publish this') . ' ' . ucfirst($this_post_type) . __(' to') . ' <a href="' . LACANDS_PLUGIN_ADMIN_URL . '">' . __('configured Networks') . '</a></label>';
	$html_label_type_disabled = '&nbsp;<label for="lacandsnw_meta_cb_publish">' . __('Publishing of') . ' ' . ucfirst($this_post_type) . ' <a href="http://codex.wordpress.org/Post_Types" target="_blank">' . __('') . '</a>' . __(' to') . ' <a href="' . LACANDS_PLUGIN_ADMIN_URL . '">' . __('configured Networks') . '</a>' . ' ' . __('has been disabled. Check this box') . '</a>' . __(' to enable again.') . '</label>';
	if ($curr_val_publish) {
		if (array_key_exists('lacandsnw_post_types', $options)) {
			if (in_array($this_post_type, explode(',', $options['lacandsnw_post_types']))) {
				$html .= '<input type="checkbox" name="lacandsnw_meta_cb_publish" id="lacandsnw_meta_cb_publish" checked ' . $inputs_disabled . ' />';
			} else {
				$inputs_disabled = 'disabled="disabled"';
				$html .= '<input type="checkbox" name="lacandsnw_meta_cb_publish" id="lacandsnw_meta_cb_publish" ' . $inputs_disabled . ' />';
				$html_label = $html_label_type_disabled;
			}
		} else {
			$html .= '<input type="checkbox" name="lacandsnw_meta_cb_publish" id="lacandsnw_meta_cb_publish" checked ' . $inputs_disabled . ' />';
		}
	} else {
		if (in_array($this_post_type, explode(',', $options['lacandsnw_post_types']))) {
			$html .= '<input type="checkbox" name="lacandsnw_meta_cb_publish" id="lacandsnw_meta_cb_publish" ' . $inputs_disabled . ' />';
		} else {
			$inputs_disabled = 'disabled="disabled"';
			$html .= '<input type="checkbox" name="lacandsnw_meta_cb_publish" id="lacandsnw_meta_cb_publish" ' . $inputs_disabled . ' />';
			$html_label = $html_label_type_disabled;
		}
	}
	$html .= $html_label;
	$html .= '</div>';
	// Message
	$curr_val_message = get_post_meta($object -> ID, 'lacandsnw_postmessage', true);
	$html .= '<div class="misc-pub-section">';
	$html .= '<div class="lacandsnw_post_meta_box_label_box"><label class="lacandsnw_post_meta_box_label" for="lacandsnw_postmessage"><a target="_blank" href="http://help.linksalpha.com/wordpress-plugin-network-publisher/message">'. __('Message').'</a>'.(' to be included in the post(for Facebook & LinkedIn):') . '</label></div>';
	$html .= '<textarea name="lacandsnw_postmessage" id="lacandsnw_postmessage">' . $curr_val_message . '</textarea>';
	$html .= '</div>';
	// Twitter handle
	$curr_val_twitterhandle = get_post_meta($object -> ID, 'lacandsnw_twitterhandle', true);
	$html .= '<div class="misc-pub-section">';
	$html .= '<div class="lacandsnw_post_meta_box_label_box"><label class="lacandsnw_post_meta_box_label" for="lacandsnw_twitterhandle">@<a target="_blank" href="http://help.linksalpha.com/wordpress-plugin-network-publisher/twitter-handle">' .__('Twitter handles').'</a>'.__(' to mention in the post:') . '</label></div>';
	$html .= '<input type="text" name="lacandsnw_twitterhandle" id="lacandsnw_twitterhandle" value="'. $curr_val_twitterhandle .'" />';
	$html .= '<div class="lacandsnw_post_meta_box_helper">2 max, comma separated</div>';
	$html .= '</div>';
	//Twitter hash
	$curr_val_twitterhash = get_post_meta($object -> ID, 'lacandsnw_twitterhash', true);
	$html .= '<div class="misc-pub-section">';
	$html .= '<div class="lacandsnw_post_meta_box_label_box"><label class="lacandsnw_post_meta_box_label" for="lacandsnw_twitterhash"><a target="_blank" href="http://help.linksalpha.com/wordpress-plugin-network-publisher/twitter-hashtag">' . __('Twitter hashtags').'</a>'.__(' to be included in the post:') . '</label></div>';
	$html .= '<input type="text" name="lacandsnw_twitterhash" id="lacandsnw_twitterhash" value="'.$curr_val_twitterhash.'" />';
	$html .= '<div class="lacandsnw_post_meta_box_helper">2 max, comma separated</div>';
	$html .= '</div>';
	//Content
	$curr_val_content = get_post_meta($object -> ID, '_lacandsnw_meta_content', true);
	if ($curr_val_content == '') {
		$curr_val_content = 0;
	}
	$html .= '<div class="misc-pub-section">';
	if ($curr_val_content) {
		$html .= '<input type="checkbox" name="lacandsnw_meta_cb_content" id="lacandsnw_meta_cb_content" checked ' . $inputs_disabled . ' />';
	} else {
		$html .= '<input type="checkbox" name="lacandsnw_meta_cb_content" id="lacandsnw_meta_cb_content" ' . $inputs_disabled . ' />';
	}
	$html .= '&nbsp;<label for="lacandsnw_meta_cb_content">' . __('Use Excerpt for publishing to Networks') . '</label>';
	$html .= '</div>';
    //Content Sent successfully
    if ($lacandsnw_meta_published == 'failed') {
		$html .= '<div class="misc-pub-section" style="color:red;"><img src="' . LACANDSNW_WP_PLUGIN_URL . 'alert.png" />&nbsp;' . __('Post to social networks failed.') . '</div>';
	} elseif ($lacandsnw_meta_published == 'done') {
		$html .= '<div class="misc-pub-section" style="color:green;"><input type="checkbox" checked disabled="disabled" />&nbsp;<label for="lacandsnw_meta_cb_content">' . __('Data sent successfully.') . '</label></div>';
	}
	//nonce
	$html .= '<input type="hidden" name="lacandsnw_meta_nonce" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
	//Return
	echo $html;
}

function lacandsnw_save_post_meta_box($post_id, $post) {
	//Save 1 Click published
	if ( !wp_verify_nonce( $_POST['lacands_meta_nonce'], plugin_basename( __FILE__ ) ) ) {
		return $post_id;	
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}
	//Show
	if($_POST['lacands_meta_cb_show']) {
		$new_meta_value = 1;
	} else {
		$new_meta_value = 0;
	}
	update_post_meta( $post_id, '_lacands_meta_show', $new_meta_value );		
	if (empty($_POST['lacandsnw_meta_nonce'])) {
		return $post_id;
	}
	if (!wp_verify_nonce($_POST['lacandsnw_meta_nonce'], plugin_basename(__FILE__))) {
		return $post_id;
	}
	if (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	// Postmessage - Facebook
	$new_meta_value_postmessage = '';
	if (!empty($_POST['lacandsnw_postmessage'])) {
		if ($_POST['lacandsnw_postmessage']) {
			$new_meta_value_postmessage = strip_tags($_POST['lacandsnw_postmessage']);
		}
	}
	update_post_meta($post_id, 'lacandsnw_postmessage', $new_meta_value_postmessage);
	// Twitterhandle
	$new_meta_value_twitterhandle = '';
	if (!empty($_POST['lacandsnw_twitterhandle'])) {
		if ($_POST['lacandsnw_twitterhandle']) {
			$new_meta_value_twitterhandle = strip_tags($_POST['lacandsnw_twitterhandle']);
			$new_meta_value_twitterhandle = str_replace("@", "", $new_meta_value_twitterhandle);
		}
	}
	update_post_meta($post_id, 'lacandsnw_twitterhandle', $new_meta_value_twitterhandle);
	// Twitterhash
	$new_meta_value_twitterhash = '';
	if (!empty($_POST['lacandsnw_twitterhash'])) {
		if ($_POST['lacandsnw_twitterhash']) {
			$new_meta_value_twitterhash = strip_tags($_POST['lacandsnw_twitterhash']);
			$new_meta_value_twitterhash = str_replace("#", "", $new_meta_value_twitterhash);
		}
	}
	update_post_meta($post_id, 'lacandsnw_twitterhash', $new_meta_value_twitterhash);
	// Published
	$new_meta_value_publish = 0;
	if (!empty($_POST['lacandsnw_meta_cb_publish'])) {
		if ($_POST['lacandsnw_meta_cb_publish']) {
			$new_meta_value_publish = 1;
		}
	}
	update_post_meta($post_id, '_lacandsnw_meta_publish', $new_meta_value_publish);
	// Content
	$new_meta_value_content = 0;
	if (!empty($_POST['lacandsnw_meta_cb_content'])) {
		if ($_POST['lacandsnw_meta_cb_content']) {
			$new_meta_value_content = 1;
		}
	}
	update_post_meta($post_id, '_lacandsnw_meta_content', $new_meta_value_content);
}

function lacandsnw_auth_errors() {
	//Get options
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if(!is_array($options)) {
		return;
	}
	if(empty($options['lacandsnw_auth_error_show'])) {
		return;
	}
	$lacandsnw_auth_error_show = $options['lacandsnw_auth_error_show'];
	if(!$lacandsnw_auth_error_show) {
		return;
	}
	if (empty($options['api_key'])) {
		return;
	}
	$api_key = $options['api_key'];
	$link = 'http://www.linksalpha.com/a/networkpubautherrors';
	$params = array('api_key'=>$api_key,
					'plugin'=>LAECHONW_PLUGIN_NAME,
					'plugin_version'=>lacandsnw_version(),
					);
	$response_full = lacandsnw_http_post($link, $params);
	$response_code = $response_full[0];
	if($response_code == 200) {
        return;
	}
	if($response_code == 401) {
		echo "
		<div class='updated fade' style='padding:10px;'>
			<div style='color:red;font-weight:bold;'>
				<img src='".LACANDSNW_WP_PLUGIN_URL ."/icons/alert.png' style='vertical-align:text-bottom;' />&nbsp;".LACANDSNW_WIDGET_NAME_POST_EDITOR.' - '.__("Authorization Error")."
			</div>
			<div style='padding-top:0px;'>
				".__("Authorization provided on one or more of your Network accounts has expired. Please")." <a target='_blank' href='http://www.linksalpha.com/networks'>".__("add the related Account")."</a> ".__("again to be able to publish content. To learn more, ")."<a target='_blank' href='http://help.linksalpha.com/networks/authorization-error'>".__("Click Here")."</a>. ".__("To access Settings page of the plugin, ")."<a href='".LAECHO_PLUGIN_ADMIN_URL."'>".__("Click Here.")."</a>
			</div>
		</div>
		";
        return;
	}
    return;
}

function lacandsnw_auth_error_show($lacandsnw_auth_error_show) {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	$options['lacandsnw_auth_error_show'] = $lacandsnw_auth_error_show;
	update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
	return;
}

function lacandsnw_mixed_mode() {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if(!is_array($options)) {
		return;
	}
	if(empty($options['lacandsnw_mixed_mode_alert_show'])) {
		return;
	}
	$lacandsnw_mixed_mode_alert_show = $options['lacandsnw_mixed_mode_alert_show'];
	if(!$lacandsnw_mixed_mode_alert_show) {
		return;
	}
	if (empty($options['id_2'])) {
		return;
	}
	$id = $options['id_2'];
	$link = 'http://www.linksalpha.com/a/networkpubmixedmode';
	$params = array('id'=>$id,
					'plugin'=>LAECHONW_PLUGIN_NAME,
					'plugin_version'=>lacandsnw_version(),
					);
	$response_full = lacandsnw_http_post($link, $params);
	$response_code = $response_full[0];
	if($response_code == 200) {
		$response = lacandsnw_json_decode($response_full[1]);
		if ($response->errorCode > 0) {
			if($response->errorMessage == 'mixed mode') {
				echo "
				<div class='updated fade' style='padding:10px;'>
					<div style='color:red;font-weight:bold;'>
						<img src='".LACANDSNW_WP_PLUGIN_URL ."/icons/alert.png' style='vertical-align:text-bottom;' />&nbsp;".LACANDSNW_WIDGET_NAME_POST_EDITOR.' - '.__("Mixed Mode Alert")."
					</div>
					<div style='padding-top:0px;'>
						".__("Publishing of your website content via LinksAlpha Publisher seems to be configured using both the WordPress Plugin and RSS Feed of your website. LinksAlpha recommends use of plugin over RSS Feed. ")."<a target='_blank' href='http://help.linksalpha.com/wordpress-plugin-network-publisher/mixed-mode-alert'>".__("Click here")."</a> ".__("to read the help document that will help resolve this Mixed Mode configuration issue.")."
					</div>
				</div>
				";
			}
		}
	}
}

function lacandsnw_mixed_mode_alert_show($lacandsnw_mixed_mode_alert_show) {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	$options['lacandsnw_mixed_mode_alert_show'] = $lacandsnw_mixed_mode_alert_show;
	update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
	return;
}

function lacandsnw_networkping($id) {
	if(!$id) {
		return FALSE;
	}
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if(empty($options['lacandsnw_id']) or empty($options['api_key'])) {
		return;
	}
	$link = 'http://www.linksalpha.com/a/ping?id='.$options['lacandsnw_id'];
	$response_full = lacandsnw_http($link);
	return;
}

function lacandsnw_networkping_custom($new, $old, $post) {
    if ($new == 'publish' && $old != 'publish') {
        $post_types = get_post_types( array('public' => true), 'objects' );
        foreach ( $post_types as $post_type ) {
            if ( $post->post_type == $post_type->name ) {
                lacandsnw_networkping($post->ID, $post);
                break;
            }
        }
	}
    return;
}

function lacandsnw_convert($id) {
	if(!$id) {
		return;
	}
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if(!empty($options['id_2'])) {
		return;
	}
	if(empty($options['lacandsnw_id']) or empty($options['api_key'])) {
		return;
	}
	// Build Params
	$link = 'http://www.linksalpha.com/a/networkpubconvert';
	$params = array('id'=>$options['lacandsnw_id'],
					'api_key'=>$options['api_key'],
					'plugin'=>LACANDSNW_PLUGIN_NAME,
					);
	//HTTP Call
	$response_full = lacandsnw_http_post($link, $params);
	$response_code = $response_full[0];
	if ($response_code != 200) {
		return;
	}
	$response = lacandsnw_json_decode($response_full[1]);
	if ($response->errorCode > 0) {
		return;
	}
	//Update options
	$options['id_2'] = $response->results;
	//Save
	update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
	return;
}

function lacandsnw_post($post_id) {
	//Network keys
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if (empty($options['api_key']) or empty($options['id_2'])) {
		return;
	}
	$id = $options['id_2'];
	$api_key = $options['api_key'];
    //Post data
	$post_data = get_post( $post_id, ARRAY_A );
    //Post Published?
	if (!in_array($post_data['post_status'], array('future', 'publish'))) {
		return;
	}
	//Post too old
    $post_date = strtotime($post_data['post_date_gmt']);
    $current_date = time();
    $diff = $current_date - $post_date;
 	$days = floor( $diff / (60*60*24) );
    if($days > 3) {
        return;
     }
	$post_message = get_post_meta($post_id, 'lacandsnw_postmessage', true);
	$post_twitterhandle = get_post_meta($post_id, 'lacandsnw_twitterhandle', true);
	$post_twitterhash = get_post_meta($post_id, 'lacandsnw_twitterhash', true);
	$lacandsnw_meta_publish = get_post_meta($post_id, '_lacandsnw_meta_publish', true);
	if ($lacandsnw_meta_publish == "") {
		}
	 elseif 
	 	($lacandsnw_meta_publish == 0) {
		return;
		}
	$lacandsnw_meta_published = get_post_meta($post_id, '_lacandsnw_meta_published', true);
	if ($lacandsnw_meta_published == 'done') {
		return;
		}
	//Post meta - lacandsnw_meta_content
	$lacandsnw_meta_content = get_post_meta($post_id, '_lacandsnw_meta_content', true);
	//Post data: id, content and title
	$post_title = $post_data['post_title'];
	if ($lacandsnw_meta_content) {
		$post_content = $post_data['post_excerpt'];
	} else {
		$post_content = $post_data['post_content'];
	}
	//Post data: Permalink
	$post_link = get_permalink($post_id);
	//Post data: Categories
	$post_categories_array = array();
	$post_categories_data = get_the_category( $post_id );
	foreach($post_categories_data as $category) {
	$post_categories_array[] = $category->cat_name;
	}
	$post_categories = implode(",", $post_categories_array);
	//Post tags
	$post_tags_array = array();
	$post_tags_data = wp_get_post_tags( $post_id );
	foreach($post_tags_data as $tag) {
		$post_tags_array[] = $tag->name;
	}
	$post_tags = implode(",", $post_tags_array);
	//Post Geo
	if(function_exists('get_wpgeo_latitude')) {
		if(get_wpgeo_latitude( $post_id ) and get_wpgeo_longitude( $post_id )) {
			$post_geotag = get_wpgeo_latitude( $post_id ).' '.get_wpgeo_longitude( $post_id );			}
		}
	if(!isset($post_geotag)) {
		$post_geotag = '';
	}
	// Build Params
	$link = 'http://www.linksalpha.com/a/networkpubpost';
	$params = array('id'=>$id,
					'api_key'=>$api_key,
					'post_id'=>$post_id,
					'post_link'=>$post_link,
					'post_title'=>$post_title,
					'post_content'=>$post_content,
					'post_geotag' => $post_geotag, 
					'content_message' => $post_message,
					'twitterhandle' => $post_twitterhandle, 
					'hashtag' => $post_twitterhash,
					'plugin'=>LACANDSNW_PLUGIN_NAME,
					'plugin_version'=>lacandsnw_version(),
					'post_categories'=>$post_categories,
					'post_tags'=>$post_tags,
					'post_geotag'=>$post_geotag
					);
	//Featured Image
	$post_image = lacandsnw_thumbnail_link( $post_id );
	if($post_image) {
		$params['post_image'] = $post_image;
	}
	//HTTP Call
	$response_full = lacandsnw_http_post($link,$params);
    $response_code = $response_full[0];
	if ($response_code == 200) {
		update_post_meta($post_id, '_lacandsnw_meta_published', 'done');
		return;
	}
	update_post_meta($post_id, '_lacandsnw_meta_published', 'failed');
    return;
}

function lacandsnw_post_xmlrpc($post_id) {
    lacandsnw_post($post_id);
}

function lacandsnw_post_custom($new, $old, $post) {
    if ($new == 'publish' && $old != 'publish') {
        $post_types = get_post_types( array('public' => true), 'objects' );
        foreach ( $post_types as $post_type ) {
            if ( $post->post_type == $post_type->name ) {
                lacandsnw_post($post->ID);
                break;
            }
        }
	}
    return;
}

function lacandsnw_networkpub_add($api_key) {
	if (!$api_key) {
		$errdesc = lacandsnw_error_msgs('invalid key');
		echo $errdesc;
		return;
	}
	$url = get_bloginfo('url');
	if (!$url) {
		$errdesc = lacandsnw_error_msgs('invalid url');
		echo $errdesc;
		return;
	}
	$desc = get_bloginfo('description');
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if(!empty($options['lacandsnw_id'])) {
		$id = $options['lacandsnw_id'];
	} elseif (!empty($options['id_2'])) {
		$id = $options['id_2'];
	} else {
		$id = '';
	}
	$url_parsed = parse_url($url);
	$url_host = $url_parsed['host'];
	if( substr_count($url, 'localhost') or strpos($url_host, '192.168.') === 0 or strpos($url_host, '127.0.0') === 0 or (strpos($url_host, '172.') === 0 and (int)substr($url_host, 4, 2) > 15 and (int)substr($url_host, 4, 2) < 32 ) or strpos($url_host, '10.') === 0 ) {
		$errdesc = lacandsnw_error_msgs('localhost url');
		echo $errdesc;
		return FALSE;
	}
	$link   = 'http://www.linksalpha.com/a/networkpubaddone';
	// Build Params
	$params = array('url'=>urlencode($url),
					'key'=>$api_key,
					'plugin'=>LACANDSNW_PLUGIN_NAME,
					'version'=>LACANDSNW_PLUGIN_VERSION,
					'all_keys'=>$options['api_key'],
					'id'=>$id);
	//HTTP Call
	$response_full = lacandsnw_http_post($link,$params);
	$response_code = $response_full[0];
	if ($response_code != 200) {
		$errdesc = lacandsnw_error_msgs($response_full[1]);
		echo $errdesc;
		return FALSE;
	}
	$response = lacandsnw_json_decode($response_full[1]);
	if ($response->errorCode > 0) {
		$errdesc = lacandsnw_error_msgs($response->errorMessage);
		echo $errdesc;
		return FALSE;
	}
	//Update options - Site id
	$options['id_2'] = $response->results->id;
	//Update options - Network Keys
	if(empty($options['api_key'])) {
		$options['api_key'] = $response->results->api_key;	
	} else {
		$option_api_key_array = explode(',', $options['api_key']);
		$option_api_key_new = $response->results->api_key;
		$option_api_key_new_array = explode(',', $option_api_key_new);
		foreach($option_api_key_new_array as $key=>$val) {
			if(!in_array($val, $option_api_key_array)) {
				$options['api_key'] = $options['api_key'].','.$val;
			}
		}
	}
	//Save
	update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
	//Return
	echo '<div class="updated fade" style="width:94%;margin-left:5px;padding:5px;text-align:center">API Key has been added successfully</div>';
	return;
}

function lacandsnw_networkpub_load() {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if (empty($options['api_key'])) {		
		$html = '<div class="msg_error">'.LACANDSNW_YOU_HAVE_NOT_ADDED_ANY_API_KEY.'</div>';
		echo $html;
		return;
	}
	$link = 'http://www.linksalpha.com/a/networkpubget';
	$body = array('key'=>$options['api_key'], 'version'=>2);	
	$response_full = lacandsnw_http_post($link, $body);
	$response_code = $response_full[0];
	if ($response_code != 200) {
		$errdeschtml = lacandsnw_error_msgs($response_full[1]); 
		echo $errdeschtml;
		return;		
	}
	$response = lacandsnw_json_decode($response_full[1]);
	if($response->errorCode > 0) {
		$html = '<div class="msg_error">'.LACANDSNW_ERROR_LOADING_API_KEYS.'.</div>';
		echo $html;
		return;
	}
	if(count($response->results_deleted)) {
		$option_api_key_array = explode(',', $options['api_key']);
		foreach($response->results_deleted as $row) {
			if(in_array($row, $option_api_key_array)) {
				$pos = $option_api_key_array[$row];
				unset($option_api_key_array[$pos]);
			}
		}
		$api_key = implode(",", $option_api_key_array);
		$options['api_key'] = $api_key;
		update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
	}
	if(!count($response->results)) {
		return '<div class="msg_error">You have not added an API Key</div>';
	}
	if(count($response->results) == 1) {
		$html = '<div style="padding:0px 10px 10px 10px;">'.LACANDSNW_CURRENTLY_PUBLISHING.'&nbsp;<span id="lacands_pub_count">'.count($response->results).'&nbsp;'.LACANDSNW_SOCIAL_NETWORK.'</span></div>';	
	} else {
		$html = '<div style="padding:0px 10px 10px 10px;">'.LACANDSNW_CURRENTLY_PUBLISHING.'&nbsp;<span id="lacands_pub_count">'.count($response->results).'&nbsp;'.LACANDSNW_SOCIAL_NETWORKS.'</span></div>';
	}
	$html .= '<table class="lacands_networkpub_added"><tr><th>'.__('Network').'</th><th>'.__('Option').'</th><th>'.__('Results').'</th><th>'.__('Remove').'</th></tr>';
	$i = 1;
	foreach($response->results as $row) {
		$html .= '<tr id="r_key_'.$row->api_key.'">';
		if($i&1) {
			$html .= '<td>';
		} else {
			$html .= '<td style="background-color:#F7F7F7;">';
		}
		$html .= '<a target="_blank" href="'.$row->profile_url.'">'.$row->name.'</a></td>';
		if($i&1) {
			$html .= '<td style="text-align:center;">';
		} else {
			$html .= '<td style="text-align:center;background-color:#F7F7F7;">';
		}
		$html .= '<a href="http://www.linksalpha.com/a/networkpuboptions?api_key='.$row->api_key.'&id='.$options['id_2'].'&version='.lacandsnw_version().'&KeepThis=true&TB_iframe=true&height=465&width=650" title="Publish Options" class="thickbox" type="button">'.__('Options').'</a></td>';
		if($i&1) {
			$html .= '<td style="text-align:center;">';
		} else {
			$html .= '<td style="text-align:center;background-color:#F7F7F7;">';
		}
		$html .= '<a href="https://www.linksalpha.com/a/networkpublogs?api_key=' . $row -> api_key . '&id=' . $options['id_2'] . '&version=' . lacandsnw_version() . '&KeepThis=true&TB_iframe=true&height=400&width=920" title="Publish Results" class="thickbox" type="button" />' . __('Results') . '</a></td>';
		if ($i % 2) {
			$html .= '<td ' . $auth_error_class . ' style="text-align:center;">';
		} else {
			$html .= '<td ' . $auth_error_class . ' style="text-align:center;background-color:#F7F7F7;">';
		}
		$html .= '<a href="#" id="key_'.$row->api_key.'" class="lacandsnw_remove">'.__('Remove').'</a></td>';
		$html .= '</tr>';
		$i++;
	}
	$html .= '</table>';
	echo $html;
	return;
}
add_action('admin_head', 'lacandsnw_networkpub_remove_javascript');

function lacandsnw_networkpub_remove_javascript() {
?>
<script type="text/javascript" >
	jQuery(document).ready(function($) {
		jQuery(".lacandsnw_remove").live("click", function() {
			var lacandsnw_ajax_msg = jQuery(this).parents(".lacandsnw_content_box:first").prev();
			lacandsnw_ajax_msg.show();
			lacandsnw_ajax_msg.html('Removing...');
	        var key = jQuery(this).attr("id");
	        var this_row = jQuery(this).parents('tr:first');
	        this_row.css('opacity', '.30');
	        jQuery.post(ajaxurl, {lacandsnw_networkpub_key:key, type:'remove'}, function(data) {
		        if (data == '500') {
	            	lacandsnw_ajax_msg.html('Error occured while removing the Network. As a workaround, you can remove this publishing at the following link: <a target="_blank" href="http://www.linksalpha.com/publisher/pubs">LinksAlpha Publisher</a>');
	            } else {
	            	this_row.remove();
	                lacandsnw_ajax_msg.html('Network has been removed successfully');
	                var lacands_pub_count = jQuery(".lacandsnw_remove").length;
	                if(lacands_pub_count > 1) {
	                	$("#lacands_pub_count").html(lacands_pub_count+' <?php echo LACANDSNW_SOCIAL_NETWORKS ?>');
			        } else {
			        	$("#lacands_pub_count").html(lacands_pub_count+' <?php echo LACANDSNW_SOCIAL_NETWORK ?>');
			        }
	            }
	            oneclick_msg_fade(lacandsnw_ajax_msg);
	        });
	        return false;
	    });
	});
</script>
<?php
}
add_action('wp_ajax_lacandsnw_networkpub_remove', 'lacandsnw_networkpub_remove');

function lacandsnw_networkpub_remove() {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if (!empty($_POST['lacandsnw_networkpub_key'])) {
		$key_full = $_POST['lacandsnw_networkpub_key'];
		$key_only = trim(substr($key_full, 4));
		$link = 'http://www.linksalpha.com/a/networkpubremove';
		$body = array('id'=>$options['id_2'], 'key'=>$key_only);
		$response_full = lacandsnw_http_post($link, $body);
		$response_code = $response_full[0];
		if ($response_code != 200) {
			$errdesc = lacandsnw_error_msgs($response_full[1]); 
			echo $errdesc;		
			return;
		}
		$api_key = $options['api_key'];
		$api_key_array = explode(',', $api_key);
		$loc = array_search($key_only, $api_key_array, True);
		if($loc !== FALSE) {
			unset($api_key_array[$loc]);
		}
		$api_key = implode(",", $api_key_array);
		$options['api_key'] = $api_key;
		update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
		echo $key_full;
		return;
	}
}

function lacandsnw_json_decode($str) {
	if (function_exists("json_decode")) {
	    return json_decode($str);
	} else {
		if (!class_exists('Services_JSON')) {
			require_once("JSON.php");
		}
	    $json = new Services_JSON();
	    return $json->decode($str);
	}
}

function lacandsnw_http($link) {
	if (!$link) {
		return array(500, 'invalid url');
	}
	if( !class_exists( 'WP_Http' ) ) {
		include_once( ABSPATH . WPINC. '/class-http.php' );
	}
	if (class_exists('WP_Http')) {
		$request = new WP_Http;
		$headers = array( 'Agent' => LAECHONW_WIDGET_NAME.' - '.get_bloginfo('url') );
		$response_full = $request->request( $link, array( 'timeout'=>30 ) );
        if(isset($response_full->errors)) {			
			return array(500, 'internal error');			
		}
		$response_code = $response_full['response']['code'];
		if ($response_code == 200) {
			$response = $response_full['body'];
			return array($response_code, $response);
		}
		$response_msg = $response_full['response']['message'];
		return array($response_code, $response_msg);
	}
	require_once(ABSPATH.WPINC.'/class-snoopy.php');
	$snoop = new Snoopy;
	$snoop->agent = LAECHONW_WIDGET_NAME.' - '.get_bloginfo('url');
	if($snoop->fetchtext($link)){
		if (strpos($snoop->response_code, '200')) {
			$response = $snoop->results;
			return array(200, $response);
		}
	}
	return array(500, 'internal error');
}

function lacandsnw_http_post($link, $body) {
	if (!$link) {
		return array(500, 'invalid url');
	}
	if( !class_exists( 'WP_Http' ) ) {
		include_once( ABSPATH . WPINC. '/class-http.php' );
	}
	if (class_exists('WP_Http')) {
		$request = new WP_Http;
		$headers = array( 'Agent' => LAECHONW_WIDGET_NAME.' - '.get_bloginfo('url') );
		$response_full = $request->request( $link, array( 'method' => 'POST', 'body' => $body, 'headers'=>$headers, 'timeout'=>30 ) );
		if(isset($response_full->errors)) {
			return array(500, 'internal error');
		}
		$response_code = $response_full['response']['code'];
		if ($response_code == 200) {
			$response = $response_full['body'];
			return array($response_code, $response);
		}
		$response_msg = $response_full['response']['message'];
		return array($response_code, $response_msg);
	}
	require_once(ABSPATH.WPINC.'/class-snoopy.php');
	$snoop = new Snoopy;
	$snoop->agent = LAECHONW_WIDGET_NAME.' - '.get_bloginfo('url');
	if($snoop->submit($link, $body)){
		if (strpos($snoop->response_code, '200')) {
			$response = $snoop->results;
			return array(200, $response);
		} 
	}	
	return array(500, 'internal error');
}

function lacandsnw_error_msgs($errMsg) {
	$arr_errCodes  = explode(";", $errMsg);
	$errCodesCount = count($arr_errCodes);
	switch (trim($arr_errCodes[0])) {
		case 'internal error':
			$html = '<div class="lacandsnw_error">'.__('An unknown error occured. Please try again later. Else, open a ticket with').'&nbsp;<a target="_blank" href="http://support.linksalpha.com">'.__('LinksAlpha Help Desk').'</div>';
			return $html;		
			break;
		case 'invalid url':
			$html  = 	'<div class="lacandsnw_error">
							<div class="lacandsnw_error_header"><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;'.__('Your website URL is invalid').'</div>
							<div>'.__('URL of your website is not valid and as a result LinksAlpha.com is not able to connect to it. You can try adding the website URL directly in the').'&nbsp;'.'<a target="_blank" href="https://www.linksalpha.com/websites">'.__('LinksAlpha Website Manager.').'</a>&nbsp;'.__('If that also does not work, please open a ticket at').'&nbsp;'.'<a target="_blank" href="http://support.linksalpha.com">'.__('LinksAlpha Help Desk.').'</a></div>
						</div>';
			return $html;
			break;
		case 'remote url error':
			$html  = 	'<div class="lacandsnw_error">
							<div class="lacandsnw_error_header"><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;'.__('Remote URL error').'</div>
							<div>'.__('Your website is either loading extremely slowly or it is in maintenance mode. As a result LinksAlpha.com is not able to connect to it. You can try adding the website URL directly in the').'&nbsp;'.'<a target="_blank" href="https://www.linksalpha.com/websites">'.__('LinksAlpha Website Manager.').'</a>&nbsp;'.__('If that also does not work, please open a ticket at').'&nbsp;'.'<a target="_blank" href="http://support.linksalpha.com">'.__('LinksAlpha Help Desk.').'</a></div>
						</div>';
			return $html;
			break;
		case 'feed parsing error':
			$html  = 	'<div class="lacandsnw_error">
							<div class="lacandsnw_error_header"><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;'.__('RSS Feed parsing error').'</div>
							<div>'.__('Your RSS feed has errors and as a result LinksAlpha.com is not able to connect to it. You can try validating your RSS feed using').'&nbsp;'.'<a target="_blank" href="http://feedvalidator.org/">'.__('Feed Validator.').'</a>&nbsp;'.__('If the RSS feed is indeed valid and you continue to face isses, please open a ticket at').'&nbsp;'.'<a target="_blank" href="http://support.linksalpha.com">'.__('LinksAlpha Help Desk.').'</a></div>
						</div>';
			return $html;
			break;
		case 'feed not found':
			$html  = 	'<div class="lacandsnw_error">
							<div class="lacandsnw_error_header"><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;'.__('RSS Feed URL not found').'</div>
							<div>'.__('Plugin was not able to find RSS feed URL for your website. Please ensure that under Settings').'->'.__('General').'->'.__('Blog address (URL)').'&nbsp;'.__('the URL is filled-in correctly').'</div>
							<div>'.__('If you still face issues, please open a ticket at: ').'<a target="_blank" href="http://support.linksalpha.com/">LinksAlpha.com '.__('Help Desk').'</a></div>
						</div>';
			return $html;
			break;
		case 'invalid key':
			$html  = 	'<div class="lacandsnw_error">
							<div class="lacandsnw_error_header"><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;'.__('Invalid Key').'</div>
							<div>'.__('The').'&nbsp;'.'<a target="_blank" href="https://www.linksalpha.com/account/your_api_key">'.__('User').'</a>&nbsp;'.__('or').'&nbsp;<a target="_blank" href="https://www.linksalpha.com/networks">'.__('Network').'</a>&nbsp;'.__('API key that you entered is not valid. Please input a valid key and try again.').'</div>
							<div>'.__('If you still face issues, please open a ticket at: ').'<a target="_blank" href="http://support.linksalpha.com/">LinksAlpha.com '.__('Help Desk').'</a></div>
						</div>';
			return $html;
			break;
		case 'subscription upgrade required':
			$html  = 	'<div class="lacandsnw_error">
							<div class="lacandsnw_error_header"><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;'.__('Account Error').'</div>
							<div>'.__('Please ').'&nbsp;'.'<a target="_blank" href="http://www.linksalpha.com/account">'.__('Upgrade your Account').'</a>&nbsp;'.__('to be able to Publish to more Networks. You can learn more about LinksAlpha Networks by').'&nbsp;<a target="_blank" href="http://help.linksalpha.com/networks-1">'.__('clicking here').'</a></div>
							<div>'.__('If you still face issues, please open a ticket at: ').'<a target="_blank" href="http://support.linksalpha.com/">LinksAlpha.com '.__('Help Desk').'</a></div>
						</div>';
			return $html;
			break;
		case 'localhost url':
			$html  = 	'<div class="lacandsnw_error">
							<div class="lacandsnw_error_header"><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;'.__('Website/Blog inaccessible').'</div>
							<div>'.__('You are trying to use the plugin on localhost or behind a firewall which is not supported. Please install the plugin on a Wordpress blog on a live server.').'</div>
							<div>'.__('If you still face issues, please open a ticket at: ').'<a target="_blank" href="http://support.linksalpha.com/">LinksAlpha.com '.__('Help Desk').'</a></div>
						</div>';
			return $html;
			break;
		case 'multiple accounts':
			$html = '<div class="lacandsnw_error">
                        <div class="lacandsnw_error_header"><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;Account Error</div>
                        <div>'.__('The key that you entered is for a LinksAlpha account that is different from the currently used account for this website. You can use API key from only one account on this website. Please input a valid <a target="_blank" href="http://www.linksalpha.com/account/your_api_key">User</a> or <a target="_blank" href="http://www.linksalpha.com/user/networks">Network</a> API key and try again').'.</div>
                        <div>'.__('If you still face issues, please open a ticket at: ').'<a target="_blank" href="http://support.linksalpha.com/">LinksAlpha.com '.__('Help Desk').'</a></div>
                    </div>';
			return $html;
			break;
		case 'no networks':
			$html = '<div class="lacandsnw_error">
                        <div class="lacandsnw_error_header"><b><img src="'.LAECHONW_WP_PLUGIN_URL .'alert.png" style="vertical-align:text-bottom;" />&nbsp;'.__('No Network Accounts Found').'</b></div>
                        <div>'.__('You should first authorize LinksAlpha to publish to your social network profiles').' <a target="_blank" href="http://www.linksalpha.com/networks">'.__('Click Here').'</a> '.__('to get started.').'</div>
                        <div>'.__('If you still face issues, please open a ticket at: ').'<a target="_blank" href="http://support.linksalpha.com/">LinksAlpha.com '.__('Help Desk').'</a></div>
                    </div>';
			return $html;
			break;
		default:
			$html = '<div class="lacandsnw_error">'.__('An unknown error occured. Please try again later. Else, open a ticket with').'&nbsp;<a target="_blank" href="http://support.linksalpha.com">'.__('LinksAlpha Help Desk').'</div>';
			return $html;		
			break;			
	}	
}

function lacandsnw_get_plugin_dir() {
	global $wp_version;
	if ( version_compare($wp_version, '2.8', '<') ) {
		$path = dirname(plugin_basename(__FILE__));
		if ( $path == '.' )
		$path = '';
		$plugin_path = trailingslashit( plugins_url( $path ) );
	} 
	else {
		$plugin_path = trailingslashit( plugins_url( '', __FILE__) );
	}	
	return $plugin_path;
}

function lacandsnw_pushpresscheck() {
	$active_plugins = get_option('active_plugins');
	$pushpress_plugin = 'pushpress/pushpress.php';
	$this_plugin_key = array_search($pushpress_plugin, $active_plugins);
	if ($this_plugin_key) {
		$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
		if(array_key_exists('lacandsnw_id', $options)) {
			if($options['lacandsnw_id']) {
				$link = 'http://www.linksalpha.com/a/pushpress';
				$body = array('id'=>$options['lacandsnw_id']);
				$response_full = lacandsnw_http_post($link, $body);
				$response_code = $response_full[0];	
			}	
		}
	}
}

function lacandsnw_networkpubcheck() {
	$active_plugins = get_option('active_plugins');
	$pushpress_plugin = 'network-publisher/networkpub.php';
	$this_plugin_key = array_search($pushpress_plugin, $active_plugins);
	if ($this_plugin_key) {
		return True;
	}
	return False;
}

function lacandsnw_postbox_url() {
	global $wp_version;
	if ( version_compare($wp_version, '3.0.0', '<') ) {
		$admin_url = get_bloginfo('url').'/wp-admin/edit.php?page='.LACANDSNW_WIDGET_NAME_POSTBOX_INTERNAL;	
	} else {
		$admin_url = get_admin_url().'/edit.php?page='.LACANDSNW_WIDGET_NAME_POSTBOX_INTERNAL;
	}
	return $admin_url;
}

function lacandsnw_postbox(){
	$html  = '<div class="lacands_widget_title"><img src="http://lh4.ggpht.com/owLnuUNOtSkZCW2PKk1MKSutmjbQAjMB4_N094Zz6uTBENTsGRLt2lQWG0o6yMXheS_93DwahbndU-EPqc8=s28" />&nbsp;'.LACANDSNW_WIDGET_NAME_POSTBOX.'</div>';
	$html .= '<div class="lacands_widget_content"><iframe id="networkpub_postbox" src="http://www.linksalpha.com/post?source=wordpress&netpublink='.urlencode(LACANDSNW_WP_PLUGIN_URL).'&sourcelink='.urlencode(lacandsnw_postbox_url()).'#'.urlencode(lacandsnw_postbox_url()).'" width="1050px;" height="700px;" scrolling="no" style="border:none !important;" frameBorder="0"></iframe>';
	$html .= '<div style="padding:10px 10px 6px 10px;background-color:#FFFFFF;margin-bottom:15px;margin-top:0px;border:1px solid #F0F0F0;width:1005px;">
                <div style="width:130px;float:left;font-weight:bold;">
                    '.__('Share this Plugin').'
                </div>
                <div style="width:600px">
                    <div style="margin:0px 0px 0px 0px !important;" id="linksalpha_tag_32587491111" class="linksalpha-email-button" data-url="http://www.linksalpha.com" data-text="LinksAlpha - Making Social Easy" data-desc="LinksAlpha provides quick and easy way for companies and users to connect and share on social web. Using LinksAlpha tools, you can integrate Social Media Buttons into your website, Publish your Website Content Automatically to Social Media Sites, and Track Social Media Profiles, all from one place." data-site="http://www.linksalpha.com" data-image="http://www.linksalpha.com/images/LALOGO_s175.png" ></div>
					<script type="text/javascript" src="http://www.linksalpha.com/social/loader?tag_id=linksalpha_tag_32587491111&link=http%3A%2F%2Fwww.linksalpha.com&halign=left&fblikeverb=like&fblikeref=linksalpha&fblikefont=arial&v=2&twitterw=110&facebookw=90&googleplus=1&facebook=1&twitter=1&linkedin=1&reddit=1&stumbleupon=1&pinterest=1&identica=1&yammer=1&gmail=1&yahoomail=1&hotmail=1&aolmail=1&mailru=1&email=1&print=1&digg=1&delicious=1&diigo=1&posterous=1&tumblr=1&myspace=1&evernote=1&instapaper=1&readitlater=1&msn=1&livejournal=1&sonico=1&netlog=1&hyves=1&xing=1&vkontakte=1&weibo=1&button=googleplus%2Cfacebook%2Ctwitter&gpluslang=en-US&twitterlang=en&xinglang=en&fblikelang=en_US&twittermention=vivekpuri&twitterrelated1=linksalpha&twitterhash=linksalpha&twitterrelated=linksalpha&counters=googleplus%2Cfacebook%2Ctwitter%2Clinkedin"></script>
                </div>
              </div></div>';
	echo $html;
	return;
}

function lacandsnw_thumbnail_link( $post_id ) {
	$lacandsnw_thumbnail_size = 'full';
	if (function_exists('get_post_thumbnail_id') and function_exists('wp_get_attachment_image_src')) {
		$src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $lacandsnw_thumbnail_size);
		if ($src) {
			$src = $src[0];
			return $src;
		}
	}
	if (!$post_content) {
		return False;
	}
	if (class_exists("DOMDocument") and function_exists('simplexml_import_dom')) {
		libxml_use_internal_errors(true);
		$doc = new DOMDocument();
		if (!($doc -> loadHTML($post_content))) {
			return False;
		}
		try {
			$xml = @simplexml_import_dom($doc);
			if ($xml) {
				$images = $xml -> xpath('//img');
				if (!empty($images)) {
					return $images[0]['src'];
				}
			} else {
				return False;
			}
		} catch (Exception $e) {
			return False;
		}
	}
}

function lacandsnw_get_posts() {
	if(!empty($_GET['linksalpha_request_type'])) {
		$args = array(
	    'numberposts'     => 20,
	    'offset'          => 0,
	    'orderby'         => 'post_date',
	    'order'           => 'DESC',
	    'post_type'       => 'post',
	    'post_status'     => 'publish' );
		$posts_array = get_posts( $args );
		$html  = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head>';
		$html .= '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>';
		$html .= '<script type="text/javascript" src="'.LACANDSNW_WP_PLUGIN_URL.'jquery.ba-postmessage.min.js"></script>';
		$html .= '<script type="text/javascript" src="'.LACANDSNW_WP_PLUGIN_URL.'la-click-and-share.js"></script>';
		$html .= '</head><body style="margin:0 !important;padding:0 !important;">';
		$html .= '<select style="margin:0 !important;padding:0 !important;width:300px !important;" id="site_links" name="site_links" class="post_network" >';
		$html .= '<option class="post_network" value="" selected >---</option>';
		foreach( $posts_array as $post ) {
			$params = array();
			$post_link = get_permalink($post->ID);
			$params['content_link'] = $post_link;
			$params['title'] = trim(strip_tags($post->post_title));
			$params['content_text'] = trim(strip_tags($post->post_title));
			$params['content_body'] = trim(strip_tags($post->post_content));
			$post_image = lacandsnw_thumbnail_link( $post_id );
			if($post_image) {
				$params['content_image'] = $post_image;
			}
			$form_data = http_build_query($params);
			$html .= '<option class="post_network" value="'.$form_data.'">'.$post->post_title.'</option>';
		}
		$html .= '</select></body></html>';
		echo $html;
	}
	return;
}

function lacandsnw_version() {
	return LACANDSNW_PLUGIN_VERSION;
}
?>