<?php
/*
Plugin Name: 1-click Retweet/Share/Like
Plugin URI: http://www.linksalpha.com
Description: Adds Facebook Like, Facebook Share, Twitter, Google +1, LinkedIn Share, Facebook Recommendations. Automatic publishing of content to 30+ Social Networks.
Author: linksalpha
Author URI: http://www.linksalpha.com
Version: 5.0.1
*/

/*
    Copyright (C) 2010 LinksAlpha.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a  copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


require("la-click-and-share-utility-fns.php");
require("la-click-and-share-networkpub.php");
require("la-click-and-share-fb-meta.php");

define('LACANDS_PLUGIN_URL', 						lacands_get_plugin_dir());
define('LAECHONW_WIDGET_NAME', 						__('1-Click Retweet/Share/Like'));
define('LACANDS_FB_RECOMMENDATIONS_ID',  			'LACANDS_Facebook_Recommendations');
define('LACANDS_FB_RECOMMENDATIONS_NAME',  			__('Facebook Recommendations'));
define('LAECHONW_WIDGET_NAME_INTERNAL',				'LAECHONW_WIDGET_NAME_INTERNAL');
define('LACANDSNW_WIDGET_NAME_INTERNAL', 			'lacandsnw_networkpub');
define('LACANDSNW_WIDGET_PREFIX',        			'lacandsnw_networkpub');
define('LACANDSNW_NETWORKPUB', 						__('Automatically publish your blog posts to 25+ Social Networks including Facebook, Twitter, LinkedIn, Yahoo, MySpace...'));
define('LACANDSNW_ERROR_INTERNAL',       			'internal error');
define('LACANDSNW_ERROR_INVALID_URL',    			'invalid url');
define('LACANDSNW_ERROR_INVALID_KEY',    			'invalid key');
define('LACANDSNW_WIDGET_NAME_POSTBOX', 			'Postbox');
define('LACANDSNW_WIDGET_NAME_POSTBOX_INTERNAL', 	'networkpubpostbox');
define('LACANDS_SETTINGS_SAVED', 					__('Settings saved for 1-click Retweet/Share/Like'));
define('LACANDS_DISPLAYING', 						__('Displaying'));
define('LACANDS_DONE', 								__('Done'));
define('LACANDS_PENDING', 							__('Pending'));
define('LACANDS_DISABLE_THIS_MESSAGE', 				__('To disable this message, go to Settings'));
define('LACANDS_DISABLE_THIS_MESSAGE2', 			__("'Auto Publish on Social Networks' and check the 'Warning box' and save changes"));
define('LACANDS_PLUGIN_IS_ALMOST_READY', 			__("plugin is almost ready"));
define('LACANDS_TO', 								__("To"));
define('LACANDS_YOU_MUST', 							__("you must"));
define('LACANDS_ENTER_API_KEY', 					__("enter API key"));
define('LACANDS_ENTER_API_KEY_UPPER', 				__("Enter API key"));
define('LACANDS_UNDER_SETTINGS', 					__("under Settings"));
define('LACANDS_AUTO_PUBLISH_ON_NETWORKS', 			__("Auto Publish on Social Networks"));
define('LACANDS_PLUGIN_ADMIN_URL', 					__("options-general.php?page=1-click-retweetsharelike/la-click-and-share.php"));
define('LACANDS_DEFAULT', 							__("Default"));
define('LACANDS_SHOW', 								__("Show"));
define('LACANDS_DONT_SHOW', 						__("Don't Show"));

$lacandsnw_networkpub_settings['api_key'] 	= array('label'=>__('API Key:'), 'type'=>'text', 'default'=>'');
$lacandsnw_networkpub_settings['id']      	= array('label'=>__('id'), 'type'=>'text', 'default'=>'');
$lacandsnw_options                        	= get_option(LACANDSNW_WIDGET_NAME_INTERNAL);
$lacands_version_number 					= '5.0.1';


function lacands_init() {
	global $lacands_version_number;
	$lacands_version_number_db = get_option('lacands-html-version-number');
	if($lacands_version_number != $lacands_version_number_db) {
		update_option('lacands-html-version-number', $lacands_version_number);
		lacands_writeOptionsValuesToWPDatabase('default');
	}
}


function lacands_readOptionsValuesFromWPDatabase() {
	global $lacands_opt_widget_counters_location, $lacands_widget_disable_cntr_display;
	global $lacands_opt_widget_margin_top, $lacands_opt_widget_margin_right, $lacands_opt_widget_margin_bottom, $lacands_opt_widget_margin_left;
	global $lacands_opt_cntr_font_color, $lacands_opt_widget_fb_like, $lacands_opt_widget_font_style;
	global $lacands_display_pages, $lacands_like_layout, $lacandsnw_opt_warning_msg;
	global $lacands_opt_widget_fb_ref, $lacands_opt_widget_fb_like_lang, $lacands_opt_widget_twitter_lang, $lacands_opt_widget_twitter_mention, $lacands_opt_widget_twitter_related1, $lacands_opt_widget_twitter_related2, $lacands_opt_widget_twitter_counter, $lacands_opt_widget_linkedin_button;
	global $lacands_opt_widget_g1_button, $lacands_opt_widget_g1_counter, $lacands_opt_widget_g1_lang;
	global $lacands_opt_widget_fb_share_counter, $lacands_opt_widget_fb_like_show, $lacands_opt_widget_linkedin_counter, $lacands_opt_widget_fb_share_lang, $lacands_opt_widget_fb_share_button, $lacands_opt_widget_fb_send_button;
	global $lacands_opt_widget_buzz_counter, $lacands_opt_widget_digg_counter, $lacands_opt_widget_stumble_counter;
	global $lacands_opt_widget_fb_reco_width, $lacands_opt_widget_fb_reco_height, $lacands_opt_widget_fb_reco_header, $lacands_opt_widget_fb_reco_color, $lacands_opt_widget_fb_reco_font, $lacands_opt_widget_fb_reco_border;
	global $lacands_opt_widget_fb_reco_margin_top, $lacands_opt_widget_fb_reco_margin_right, $lacands_opt_widget_fb_reco_margin_bottom, $lacands_opt_widget_fb_reco_margin_left;
	global $lacands_opt_widget_fb_reco_title;
	global $lacands_opt_widget_buzz_button, $lacands_opt_widget_buzz_lang, $lacands_opt_widget_fb_like_button, $lacands_opt_widget_digg_button, $lacands_opt_widget_stumble_button, $lacands_opt_widget_twitter_button;
    global $lacands_opt_widget_display_password_protected, $lacands_opt_widget_display_not_postids;
    global $lacands_opt_widget_mobile_hide;
    global $lacands_opt_fb_app_id, $lacands_opt_fb_metatags, $lacands_opt_googleplus_metatags, $lacands_opt_googleplus_page_type, $lacands_opt_extra_params;

	$lacands_opt_widget_counters_location           = get_option('lacands-html-widget-counters-location');
	$lacands_opt_widget_margin_top                  = get_option('lacands-html-widget-margin-top');
	$lacands_opt_widget_margin_right                = get_option('lacands-html-widget-margin-right');
	$lacands_opt_widget_margin_bottom               = get_option('lacands-html-widget-margin-bottom');
	$lacands_opt_widget_margin_left                 = get_option('lacands-html-widget-margin-left');
	$lacands_widget_disable_cntr_display            = get_option('lacands-html-widget-disable-cntr-display');
	$lacands_opt_cntr_font_color                    = get_option('lacands-html-cntr-font-color');
	$lacands_opt_widget_fb_like                     = get_option('lacands-html-widget-fb-like');
	$lacands_opt_widget_font_style                  = get_option('lacands-html-widget-font-style');
	$lacands_opt_widget_fb_ref                      = get_option('lacands-html-widget-fb-ref');
	$lacands_opt_widget_fb_like_button              = get_option('lacands-html-widget-fb-like-button');
	$lacands_opt_widget_fb_like_lang                = get_option('lacands-html-widget-fb-like-lang');
	$lacands_opt_widget_fb_like_show                = get_option('lacands-html-widget-fb-like-show');
	$lacands_opt_widget_fb_share_button             = get_option('lacands-html-widget-fb-share-button');
	$lacands_opt_widget_fb_share_counter            = get_option('lacands-html-widget-fb-share-counter');
	$lacands_opt_widget_fb_share_lang               = get_option('lacands-html-widget-fb-share-lang');
	$lacands_opt_widget_fb_send_button              = get_option('lacands-html-widget-fb-send-button');
	$lacands_opt_widget_twitter_button              = get_option('lacands-html-widget-twitter-button');
	$lacands_opt_widget_twitter_lang                = get_option('lacands-html-widget-twitter-lang');
	$lacands_opt_widget_twitter_mention             = get_option('lacands-html-widget-twitter-mention');
	$lacands_opt_widget_twitter_related1            = get_option('lacands-html-widget-twitter-related1');
	$lacands_opt_widget_twitter_related2            = get_option('lacands-html-widget-twitter-related2');
	$lacands_opt_widget_twitter_counter             = get_option('lacands-html-widget-twitter-counter');
	$lacands_opt_widget_linkedin_button             = get_option('lacands-html-widget-linkedin-button');
	$lacands_opt_widget_linkedin_counter            = get_option('lacands-html-widget-linkedin-counter');
	$lacands_opt_widget_stumble_button              = get_option('lacands-html-widget-stumble-button');
	$lacands_opt_widget_stumble_counter             = get_option('lacands-html-widget-stumble-counter');
	$lacands_opt_widget_buzz_button                 = get_option('lacands-html-widget-buzz-button');
	$lacands_opt_widget_buzz_lang                   = get_option('lacands-html-widget-buzz-lang');
	$lacands_opt_widget_buzz_counter                = get_option('lacands-html-widget-buzz-counter');
	$lacands_opt_widget_digg_button                 = get_option('lacands-html-widget-digg-button');
	$lacands_opt_widget_digg_counter                = get_option('lacands-html-widget-digg-counter');
	$lacands_opt_widget_g1_button                   = get_option('lacands-html-widget-g1-button');
	$lacands_opt_widget_g1_counter                  = get_option('lacands-html-widget-g1-counter');
	$lacands_opt_widget_g1_lang                     = get_option('lacands-html-widget-g1-lang');
	$lacands_opt_widget_fb_reco_width               = get_option('lacands-html-widget-fb-reco-width');
	$lacands_opt_widget_fb_reco_height              = get_option('lacands-html-widget-fb-reco-height');
	$lacands_opt_widget_fb_reco_header              = get_option('lacands-html-widget-fb-reco-header');
	$lacands_opt_widget_fb_reco_color               = get_option('lacands-html-widget-fb-reco-color');
	$lacands_opt_widget_fb_reco_font                = get_option('lacands-html-widget-fb-reco-font');
	$lacands_opt_widget_fb_reco_border              = get_option('lacands-html-widget-fb-reco-border');
	$lacands_opt_widget_fb_reco_margin_top          = get_option('lacands-html-widget-fb-reco-margin-top');
	$lacands_opt_widget_fb_reco_margin_right        = get_option('lacands-html-widget-fb-reco-margin-right');
	$lacands_opt_widget_fb_reco_margin_bottom       = get_option('lacands-html-widget-fb-reco-margin-bottom');
	$lacands_opt_widget_fb_reco_margin_left         = get_option('lacands-html-widget-fb-reco-margin-left');
	$lacands_opt_widget_fb_reco_title               = get_option('lacands-html-widget-fb-reco-title');
	$lacands_display_pages                          = get_option('lacands-html-display-pages');
	$lacands_like_layout                            = get_option('lacands-html-like-layout');
	$lacandsnw_opt_warning_msg                      = get_option('lacandsnw-html-warning-msg');
    $lacands_opt_widget_display_password_protected  = get_option('lacands-html-widget-display-password-protected');
    $lacands_opt_widget_display_not_postids         = get_option('lacands-html-widget-display-not-postids');
    $lacands_opt_widget_mobile_hide                 = get_option('lacands-html-widget-mobile-hide');
    $lacands_opt_fb_app_id 							= get_option('lacands-html-fb-app-id');
    $lacands_opt_fb_metatags						= get_option('lacands-html-fb-metatags');
    $lacands_opt_googleplus_metatags				= get_option('lacands-html-googleplus-metatags');
    $lacands_opt_googleplus_page_type 				= get_option('lacands-html-googleplus-page-type');
    $lacands_opt_extra_params 						= get_option('lacands-html-extra-params');   
}


function lacands_writeOptionsValuesToWPDatabase_twitter() {
	$lacands_opt_widget_twitter_mention       	= get_option('lacands-html-widget-twitter-mention');
	if($lacands_opt_widget_twitter_mention == 'en') {
		update_option('lacands-html-widget-twitter-mention', '');
	}
	$lacands_opt_widget_twitter_related1      	= get_option('lacands-html-widget-twitter-related1');
	if($lacands_opt_widget_twitter_related1 == 'en') {
		update_option('lacands-html-widget-twitter-related1', '');
	}
	$lacands_opt_widget_twitter_related2      	= get_option('lacands-html-widget-twitter-related2');
	if($lacands_opt_widget_twitter_related2 == 'en') {
		update_option('lacands-html-widget-twitter-related2', '');
	}
}

function lacands_writeOptionsValuesToWPDatabase($option) {
	global $lacands_display_pages;
	global $lacands_version_number;
    if($option == 'default') {
		$lacands_eget = get_bloginfo('admin_email'); $lacands_uget = get_bloginfo('url'); $lacands_nget = get_bloginfo('name');
		$lacands_dget = get_bloginfo('description'); $lacands_cget = get_bloginfo('charset'); $lacands_vget = get_bloginfo('version');
		$lacands_lget = get_bloginfo('language'); $link='http://www.linksalpha.com/a/bloginfo';
		$lacands_bloginfo = array('email'=>$lacands_eget, 'url'=>$lacands_uget, 'name'=>$lacands_nget, 'desc'=>$lacands_dget, 'charset'=>$lacands_cget, 'version'=>$lacands_vget, 'lang'=>$lacands_lget, 'plugin'=>'cs');
		lacands_http_post($link, $lacands_bloginfo);
		$lacands_display_pages = array('single'=>'1','home'=>'1','archive'=>'1', 'category'=>'1', 'tags'=>'1', 'date'=>'1', 'author'=>'1', 'page'=>'1', 'search'=>'1');
		add_option('lacands-html-widget-counters-location', 			'beforeAndafter');
		add_option('lacands-html-widget-margin-top',    				'5');
		add_option('lacands-html-widget-margin-right',  				'0');
		add_option('lacands-html-widget-margin-bottom', 				'5');
		add_option('lacands-html-widget-margin-left',   				'0');
		add_option('lacands-html-widget-disable-cntr-display-after', 	'0');
		add_option('lacands-html-cntr-font-color', 						'333333');
		add_option('lacands-html-widget-fb-like', 						'like');
		add_option('lacands-html-widget-font-style', 					'arial');
		add_option('lacands-html-widget-fb-ref', 						'facebook');
		add_option('lacands-html-widget-fb-like-button', 				1);
		add_option('lacands-html-widget-fb-like-lang', 					'en_US');
		add_option('lacands-html-widget-fb-share-button', 				1);
		add_option('lacands-html-widget-fb-share-counter', 				'1');
		add_option('lacands-html-widget-fb-share-lang', 				'en');
		add_option('lacands-html-widget-fb-send-button', 				1);
		add_option('lacands-html-widget-fb-like-show', 					'1');
		add_option('lacands-html-widget-twitter-button', 				1);
		add_option('lacands-html-widget-twitter-lang', 					'en');
		add_option('lacands-html-widget-twitter-mention', 				'');
		add_option('lacands-html-widget-twitter-related1', 				'');
		add_option('lacands-html-widget-twitter-related2', 				'');
		add_option('lacands-html-widget-twitter-counter', 				'1');
		add_option('lacands-html-widget-linkedin-button', 				'noshow');
		add_option('lacands-html-widget-linkedin-counter', 				'1');
		add_option('lacands-html-widget-fb-reco-width', 				'300');
		add_option('lacands-html-widget-fb-reco-height', 				'300');
		add_option('lacands-html-widget-fb-reco-header', 				'true');
		add_option('lacands-html-widget-fb-reco-color', 				'light');
		add_option('lacands-html-widget-fb-reco-font', 					'arial');
		add_option('lacands-html-widget-fb-reco-border', 				'#AAAAAA');
		add_option('lacands-html-widget-fb-reco-margin-top',    		'5');
		add_option('lacands-html-widget-fb-reco-margin-right',  		'0');
		add_option('lacands-html-widget-fb-reco-margin-bottom', 		'5');
		add_option('lacands-html-widget-fb-reco-margin-left',   		'0');
		add_option('lacands-html-widget-fb-reco-title',   				'');
		add_option('lacands-html-widget-stumble-button', 				1);
		add_option('lacands-html-widget-stumble-counter', 				'1');
		add_option('lacands-html-widget-buzz-button', 					1);
		add_option('lacands-html-widget-buzz-lang', 					'en');
		add_option('lacands-html-widget-buzz-counter', 					'1');
		add_option('lacands-html-widget-digg-button', 					1);
		add_option('lacands-html-widget-digg-counter', 					'1');
		add_option('lacands-html-display-pages', 						$lacands_display_pages);
		add_option('lacands-html-like-layout', 							'button_count');
		add_option('lacandsnw-html-warning-msg', 						'0');
		add_option('lacands-html-widget-g1-button', 					1);
		add_option('lacands-html-widget-g1-counter', 					1);
		add_option('lacands-html-widget-g1-lang', 						'en-US');
        add_option('lacands-html-widget-display-password-protected',    0);
        add_option('lacands-html-widget-display-not-postids',           0);
        add_option('lacands-html-widget-mobile-hide',                   0);
        add_option('lacands-html-fb-app-id', 							'');
    	add_option('lacands-html-fb-metatags', 							1);
    	add_option('lacands-html-googleplus-metatags', 					1);
    	add_option('lacands-html-googleplus-page-type', 				'Article');
    	add_option('lacands-html-extra-params',							'');
        update_option('lacands-html-widget-mobile-hide',                0);
		update_option('lacands-html-version-number', 					$lacands_version_number);
	} else if ($option == 'update') {
		if(!empty($_POST['lacands-html-widget-counters-location'])) {
			update_option('lacands-html-widget-counters-location', 		$_POST['lacands-html-widget-counters-location']);
		}

		if($_POST['lacands-html-widget-margin-top'] != NULL) {
			update_option('lacands-html-widget-margin-top',    			(string)$_POST['lacands-html-widget-margin-top']);
		} else {
			update_option('lacands-html-widget-margin-top',    			'0');
		}

		if($_POST['lacands-html-widget-margin-right'] != NULL) {
			update_option('lacands-html-widget-margin-right',  			(string)$_POST['lacands-html-widget-margin-right']);
		} else {
			update_option('lacands-html-widget-margin-right',    		'0');
		}

		if($_POST['lacands-html-widget-margin-bottom'] != NULL) {
			update_option('lacands-html-widget-margin-bottom', 			(string)$_POST['lacands-html-widget-margin-bottom']);
		} else {
			update_option('lacands-html-widget-margin-bottom',    		'0');
		}

		if($_POST['lacands-html-widget-margin-left'] != NULL) {
			update_option('lacands-html-widget-margin-left',   			(string)$_POST['lacands-html-widget-margin-left']);
		} else {
			update_option('lacands-html-widget-margin-left',    		'0');
		}

		if(!empty($_POST['lacands-html-widget-disable-cntr-display'])) {
			update_option('lacands-html-widget-disable-cntr-display',   (string)$_POST['lacands-html-widget-disable-cntr-display']);
		} else {
			update_option('lacands-html-widget-disable-cntr-display', 	'0');
		}

		if(!empty($_POST['lacands-html-cntr-font-color'])) {
			update_option('lacands-html-cntr-font-color',				(string)$_POST['lacands-html-cntr-font-color']);
		} else {
			update_option('lacands-html-cntr-font-color', 				'333333');
		}

		if(!empty($_POST['lacands-html-widget-fb-like'])) {
			update_option('lacands-html-widget-fb-like',				(string)$_POST['lacands-html-widget-fb-like']);
		} else {
			update_option('lacands-html-widget-fb-like', 				'Like');
		}

		if(!empty($_POST['lacands-html-widget-font-style'])) {
			update_option('lacands-html-widget-font-style',				(string)$_POST['lacands-html-widget-font-style']);
		} else {
			update_option('lacands-html-widget-font-style', 			'Like');
		}
		
		if(!empty($_POST['lacands-html-widget-fb-ref'])) {
			update_option('lacands-html-widget-fb-ref',					(string)$_POST['lacands-html-widget-fb-ref']);
		} else {
			update_option('lacands-html-widget-fb-ref', 				'facebook');
		}
		
		if(!empty($_POST['lacands-html-widget-fb-like-button'])) {
			update_option('lacands-html-widget-fb-like-button',			(string)$_POST['lacands-html-widget-fb-like-button']);
		} else {
			update_option('lacands-html-widget-fb-like-button', 			0);
		}
		
		if(!empty($_POST['lacands-html-widget-fb-like-lang'])) {
			update_option('lacands-html-widget-fb-like-lang',			(string)$_POST['lacands-html-widget-fb-like-lang']);
		} else {
			update_option('lacands-html-widget-fb-like-lang', 			'Like');
		}
		
		if(!empty($_POST['lacands-html-widget-fb-share-button'])) {
			update_option('lacands-html-widget-fb-share-button',	$_POST['lacands-html-widget-fb-share-button']);
		} else {
			update_option('lacands-html-widget-fb-share-button', 		0);
		}
		
		if(!empty($_POST['lacands-html-widget-fb-share-counter'])) {
			update_option('lacands-html-widget-fb-share-counter',		(string)$_POST['lacands-html-widget-fb-share-counter']);
		} else {
			update_option('lacands-html-widget-fb-share-counter', 		'0');
		}
		
		if(!empty($_POST['lacands-html-widget-fb-share-lang'])) {
			update_option('lacands-html-widget-fb-share-lang',			(string)$_POST['lacands-html-widget-fb-share-lang']);
		} else {
			update_option('lacands-html-widget-fb-share-lang', 			'Share');
		}
		
		if(!empty($_POST['lacands-html-widget-fb-like-show'])) {
			update_option('lacands-html-widget-fb-like-show',			(string)$_POST['lacands-html-widget-fb-like-show']);
		} else {
			update_option('lacands-html-widget-fb-like-show', 			'0');
		}
		
		if(!empty($_POST['lacands-html-widget-twitter-button'])) {
			update_option('lacands-html-widget-twitter-button',	$_POST['lacands-html-widget-twitter-button']);
		} else {
			update_option('lacands-html-widget-twitter-button', 		0);
		}
		
		if(!empty($_POST['lacands-html-widget-twitter-lang'])) {
			update_option('lacands-html-widget-twitter-lang',			(string)$_POST['lacands-html-widget-twitter-lang']);
		} else {
			update_option('lacands-html-widget-twitter-lang', 			'Like');
		}

		if(!empty($_POST['lacands-html-widget-twitter-mention'])) {
			update_option('lacands-html-widget-twitter-mention',		(string)$_POST['lacands-html-widget-twitter-mention']);
		} else {
			update_option('lacands-html-widget-twitter-mention', 		'');
		}
		
		if(!empty($_POST['lacands-html-widget-twitter-related1'])) {
			update_option('lacands-html-widget-twitter-related1',		(string)$_POST['lacands-html-widget-twitter-related1']);
		} else {
			update_option('lacands-html-widget-twitter-related1', 		'');
		}
		
		if(!empty($_POST['lacands-html-widget-twitter-related2'])) {
			update_option('lacands-html-widget-twitter-related2',		(string)$_POST['lacands-html-widget-twitter-related2']);
		} else {
			update_option('lacands-html-widget-twitter-related2', 		'');
		}
		
		if(!empty($_POST['lacands-html-widget-twitter-counter'])) {
			update_option('lacands-html-widget-twitter-counter',		(string)$_POST['lacands-html-widget-twitter-counter']);
		} else {
			update_option('lacands-html-widget-twitter-counter', 		'0');
		}
		
		if(!empty($_POST['lacands-html-widget-linkedin-button'])) {
			update_option('lacands-html-widget-linkedin-button',		(string)$_POST['lacands-html-widget-linkedin-button']);
		} else {
			update_option('lacands-html-widget-linkedin-button', 		'');
		}
	    
		if(!empty($_POST['lacands-html-widget-linkedin-counter'])) {
			update_option('lacands-html-widget-linkedin-counter',		(string)$_POST['lacands-html-widget-linkedin-counter']);
		} else {
			update_option('lacands-html-widget-linkedin-counter', 		'0');
		}
		
		if(!empty($_POST['lacands-html-widget-stumble-button'])) {
			update_option('lacands-html-widget-stumble-button',	$_POST['lacands-html-widget-stumble-button']);
		} else {
			update_option('lacands-html-widget-stumble-button', 		0);
		}
		
		if(!empty($_POST['lacands-html-widget-stumble-counter'])) {
			update_option('lacands-html-widget-stumble-counter',		(string)$_POST['lacands-html-widget-stumble-counter']);
		} else {
			update_option('lacands-html-widget-stumble-counter', 		'0');
		}
		
		if(!empty($_POST['lacands-html-widget-buzz-button'])) {
			update_option('lacands-html-widget-buzz-button',	$_POST['lacands-html-widget-buzz-button']);
		} else {
			update_option('lacands-html-widget-buzz-button', 		0);
		}
		
		if(!empty($_POST['lacands-html-widget-buzz-lang'])) {
			update_option('lacands-html-widget-buzz-lang',	$_POST['lacands-html-widget-buzz-lang']);
		} else {
			update_option('lacands-html-widget-buzz-lang', 		'en');
		}
		
		if(!empty($_POST['lacands-html-widget-buzz-counter'])) {
			update_option('lacands-html-widget-buzz-counter',			(string)$_POST['lacands-html-widget-buzz-counter']);
		} else {
			update_option('lacands-html-widget-buzz-counter', 			'0');
		}
		
		if(!empty($_POST['lacands-html-widget-digg-button'])) {
			update_option('lacands-html-widget-digg-button',	$_POST['lacands-html-widget-digg-button']);
		} else {
			update_option('lacands-html-widget-digg-button', 		0);
		}
		
		if(!empty($_POST['lacands-html-widget-digg-counter'])) {
			update_option('lacands-html-widget-digg-counter',			(string)$_POST['lacands-html-widget-digg-counter']);
		} else {
			update_option('lacands-html-widget-digg-counter', 			'0');
		}
		
		if(!empty($_POST['lacands-html-display-page-home'])) {
			$lacands_display_pages['home'] = '1';
		} else {
			$lacands_display_pages['home'] = '0';
		}

		if(!empty($_POST['lacands-html-display-page-archive'])) {
			$lacands_display_pages['archive'] = '1';
		} else {
			$lacands_display_pages['archive'] = '0';
		}
		    
		if(!empty($_POST['lacands-html-display-page-page'])) {
			$lacands_display_pages['page'] = '1';
		} else {
			$lacands_display_pages['page'] = '0';
		}
		    
		if(!empty($_POST['lacands-html-display-page-date'])) {
			$lacands_display_pages['date'] = '1';
		} else {
			$lacands_display_pages['date'] = '0';
		}
		    
		if(!empty($_POST['lacands-html-display-page-category'])) {
			$lacands_display_pages['category'] = '1';
		} else {
			$lacands_display_pages['category'] = '0';
		}
		    
		if(!empty($_POST['lacands-html-display-page-tag'])) {
			$lacands_display_pages['tag'] = '1';
		} else {
			$lacands_display_pages['tag'] = '0';
		}
		    
		if(!empty($_POST['lacands-html-display-page-author'])) {
			$lacands_display_pages['author'] = '1';
		} else {
			$lacands_display_pages['author'] = '0';
		}
		
		if(!empty($_POST['lacands-html-display-page-page'])) {
			$lacands_display_pages['page'] = '1';
		} else {
			$lacands_display_pages['page'] = '0';
		}
		
		if(!empty($_POST['lacands-html-display-page-search'])) {
			$lacands_display_pages['search'] = '1';
		} else {
			$lacands_display_pages['search'] = '0';
		}
		update_option('lacands-html-display-pages', $lacands_display_pages);
        
		if(!empty($_POST['lacands-html-widget-g1-button'])) {
			update_option('lacands-html-widget-g1-button',	$_POST['lacands-html-widget-g1-button']);
		} else {
			update_option('lacands-html-widget-g1-button', 		0);
		}
		
		if(!empty($_POST['lacands-html-widget-g1-counter'])) {
			update_option('lacands-html-widget-g1-counter',	$_POST['lacands-html-widget-g1-counter']);
		} else {
			update_option('lacands-html-widget-g1-counter', 		0);
		}
		
		if(!empty($_POST['lacands-html-widget-g1-lang'])) {
			update_option('lacands-html-widget-g1-lang',	$_POST['lacands-html-widget-g1-lang']);
		} else {
			update_option('lacands-html-widget-g1-lang', 		'en-US');
		}
		
		if(!empty($_POST['lacands-html-widget-fb-send-button'])) {
			update_option('lacands-html-widget-fb-send-button',	$_POST['lacands-html-widget-fb-send-button']);
		} else {
			update_option('lacands-html-widget-fb-send-button', 		0);
		}
		
		if(!empty($_POST['lacands-html-like-layout'])) {
		    update_option('lacands-html-like-layout', 		(string)$_POST['lacands-html-like-layout']);
		}
	    
        if(!empty($_POST['lacands-html-widget-display-password-protected'])) {
			update_option('lacands-html-widget-display-password-protected',	$_POST['lacands-html-widget-display-password-protected']);
		} else {
			update_option('lacands-html-widget-display-password-protected', 		0);
		}
		
		if(!empty($_POST['lacands-html-widget-display-not-postids'])) {
            $disable_post_ids = $_POST['lacands-html-widget-display-not-postids'];
            $disable_post_ids_array = explode(',', $disable_post_ids);
            $disable_post_ids_array_clean = array();
            foreach($disable_post_ids_array as $key=>$val) {
                $disable_post_ids_array_clean[] = trim($val);
            }
            $disable_post_ids_clean = implode(',', $disable_post_ids_array_clean);
			update_option('lacands-html-widget-display-not-postids',	$disable_post_ids_clean);
		} else {
			update_option('lacands-html-widget-display-not-postids', 	0);
		}
		
		if (isset($_POST['warning_msg'])) {
			if(!empty($_POST['lacandsnw-html-warning-msg'])) {
				update_option('lacandsnw-html-warning-msg',  			(string)$_POST['lacandsnw-html-warning-msg']);
			} else {
				update_option('lacandsnw-html-warning-msg', 			'0');
			}
		}	    
        if(!empty($_POST['lacands-html-widget-mobile-hide'])) {
			update_option('lacands-html-widget-mobile-hide',	$_POST['lacands-html-widget-mobile-hide']);
		} else {
			update_option('lacands-html-widget-mobile-hide',            0);
		}
		
		if(!empty($_POST['lacands-html-fb-app-id'])) {
			update_option('lacands-html-fb-app-id', 							$_POST['lacands-html-fb-app-id']);
		} else {
			update_option('lacands-html-fb-app-id', 							'');
		}
		
		if(!empty($_POST['lacands-html-fb-metatags'])) {
    		update_option('lacands-html-fb-metatags', 							$_POST['lacands-html-fb-metatags']);
		} else {
			update_option('lacands-html-fb-metatags', 							0);
		}
		
		if(!empty($_POST['lacands-html-googleplus-metatags'])) {
    		update_option('lacands-html-googleplus-metatags', 					$_POST['lacands-html-googleplus-metatags']);
		} else {
			update_option('lacands-html-googleplus-metatags', 					0);
		}
		
		if(!empty($_POST['lacands-html-googleplus-page-type'])) {
    		update_option('lacands-html-googleplus-page-type', 					$_POST['lacands-html-googleplus-page-type']);
		} else {
			update_option('lacands-html-googleplus-page-type', 					'Article');
		}
	} 
}


function lacands_wp_filter_post_content ( $related_content ) {
	global $lacands_opt_widget_counters_location;
	global $lacands_widget_disable_cntr_display;
	
	$lacands_widget_disable_cntr_display  = get_option('lacands-html-widget-disable-cntr-display');
	$lacands_opt_widget_counters_location = get_option('lacands-html-widget-counters-location');
	$lacands_display_pages = get_option('lacands-html-display-pages');
	
	if($lacands_widget_disable_cntr_display == '0') {
		if($lacands_opt_widget_counters_location == "beforeAndafter") {
			$related_content_beforeAndafter = lacands_wp_filter_content_widget(FALSE);
			if ((is_tag()  && ($lacands_display_pages['tag'])) || (is_category()  && ($lacands_display_pages['category'])) || (is_author() && ($lacands_display_pages['author'])) || (is_date()  && ($lacands_display_pages['date'])) || (is_page()  && ($lacands_display_pages['page']))  || (is_search()  && ($lacands_display_pages['search']))) {
				echo $related_content_beforeAndafter;
			} else {
				$related_content = $related_content_beforeAndafter.$related_content.$related_content_beforeAndafter;
			}
		} else if($lacands_opt_widget_counters_location == "before") {
			if ((is_tag()  && ($lacands_display_pages['tag'])) || (is_category()  && ($lacands_display_pages['category'])) || (is_author() && ($lacands_display_pages['author'])) || (is_date()  && ($lacands_display_pages['date'])) || (is_page()  && ($lacands_display_pages['page']))  || (is_search()  && ($lacands_display_pages['search']))) {
				echo lacands_wp_filter_content_widget(FALSE);
			} else {
				$related_content = lacands_wp_filter_content_widget(FALSE).$related_content;
			}
		} else if($lacands_opt_widget_counters_location == "after") {
			if ((is_tag()  && ($lacands_display_pages['tag'])) || (is_category()  && ($lacands_display_pages['category'])) || (is_author() && ($lacands_display_pages['author'])) || (is_date()  && ($lacands_display_pages['date'])) || (is_page()  && ($lacands_display_pages['page']))  || (is_search()  && ($lacands_display_pages['search']))) {
				echo lacands_wp_filter_content_widget(FALSE);
			} else {
				$related_content = $related_content.lacands_wp_filter_content_widget(FALSE);
			}
		}
	}
	return ($related_content);
}


function lacands_wp_filter_content_widget ($show=TRUE) {
	global $lacands_opt_widget_counters_location, $lacands_widget_disable_cntr_display;
	global $lacands_opt_widget_margin_top, $lacands_opt_widget_margin_right, $lacands_opt_widget_margin_bottom, $lacands_opt_widget_margin_left;
	global $lacands_opt_cntr_font_color, $lacands_opt_widget_fb_like, $lacands_opt_widget_font_style;
	global $lacands_display_pages, $lacands_like_layout;
	global $lacands_opt_widget_fb_ref, $lacands_opt_widget_fb_like_lang, $lacands_opt_widget_twitter_lang, $lacands_opt_widget_twitter_mention, $lacands_opt_widget_twitter_related1, $lacands_opt_widget_twitter_related2, $lacands_opt_widget_twitter_counter, $lacands_opt_widget_linkedin_button;
	global $lacands_opt_widget_fb_share_counter, $lacands_opt_widget_fb_like_show, $lacands_opt_widget_linkedin_counter, $lacands_opt_widget_fb_share_lang, $lacands_opt_widget_fb_share_button, $lacands_opt_widget_fb_send_button;
	global $lacands_opt_widget_buzz_counter, $lacands_opt_widget_digg_counter, $lacands_opt_widget_stumble_counter;
	global $lacands_opt_widget_g1_button, $lacands_opt_widget_g1_counter, $lacands_opt_widget_g1_lang;
	global $lacands_opt_widget_buzz_button, $lacands_opt_widget_buzz_lang, $lacands_opt_widget_fb_like_button, $lacands_opt_widget_digg_button, $lacands_opt_widget_stumble_button, $lacands_opt_widget_twitter_button;
    global $lacands_opt_widget_display_password_protected, $lacands_opt_widget_display_not_postids;
    global $lacands_opt_widget_mobile_hide;
    global $lacands_opt_fb_app_id, $lacands_opt_fb_metatags, $lacands_opt_googleplus_metatags, $lacands_opt_googleplus_page_type, $lacands_opt_extra_params;
	global $post;
    
    lacands_readOptionsValuesFromWPDatabase();
    if($lacands_opt_widget_mobile_hide) {
        $isMobile = (bool)preg_match('#\b(ip(hone|od|ad)|android|opera m(ob|in)i|windows (phone|ce)|blackberry|tablet'.
                    '|s(ymbian|eries60|amsung)|p(laybook|alm|rofile/midp|laystation portable)|nokia|fennec|htc[\-_]'.
                    '|mobile|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER['HTTP_USER_AGENT'] );
        if($isMobile) {
            return;
        }
    }
    
	$p = $post;
    $position = '';
	if( $lacands_widget_disable_cntr_display == '0') {
		$position = 'padding-top:'.$lacands_opt_widget_margin_top.'px;padding-right:'.$lacands_opt_widget_margin_right.'px;padding-bottom:'.$lacands_opt_widget_margin_bottom.'px;padding-left:'.$lacands_opt_widget_margin_left.'px;';
	}
	
    $show_widget = FALSE;
    if ($show) {
        $show_widget = TRUE;
    } elseif ( is_single() ) {
        $show_widget = TRUE;
    } elseif ( is_home()        && $lacands_display_pages['home'] ) {
        $show_widget = TRUE;
    } elseif ( is_archive()     && $lacands_display_pages['archive'] ) {
        $show_widget = TRUE;
    } elseif ( is_category()    && $lacands_display_pages['category'] ) {
        $show_widget = TRUE;
    } elseif ( is_tag()         && $lacands_display_pages['tag'] ) {
        $show_widget = TRUE;
    } elseif ( is_author()      && $lacands_display_pages['author'] ) {
        $show_widget = TRUE;
    } elseif ( is_date()        && $lacands_display_pages['date'] ) {
        $show_widget = TRUE;
    } elseif ( is_feed()        && $lacands_display_pages['feed'] ) {
        $show_widget = TRUE;
    } elseif ( is_page()        && $lacands_display_pages['page'] ) {
        $show_widget = TRUE;
    } elseif ( is_search()      && $lacands_display_pages['search'] ) {
        $show_widget = TRUE;
    }
    
    #Show/Hide on Password protected posts
    if($show_widget) {
        if($p->post_password or $p->post_status == 'private') {
            if (!$lacands_opt_widget_display_password_protected) {
                $show_widget = FALSE;
            }
        }
    }
    
    #Show/Hide as per _lacands_meta_show
    if($show_widget) {
        $lacands_meta_show = get_post_meta( $post->ID, '_lacands_meta_show', true );
        if($lacands_meta_show == "") {
            $lacands_meta_show = 1;
        } 
        if(!$lacands_meta_show) {
            $show_widget = FALSE;
        }
    }
    
    #Show Hide on posts
    if($lacands_opt_widget_display_not_postids) {
        $disable_post_ids = explode(',', $lacands_opt_widget_display_not_postids);
        foreach ($disable_post_ids as $key=>$val) {
            if($p->ID == $val) {
                $show_widget = FALSE;
                break;
            }
        }
    }
    
    if ($show_widget) {
		$post_data = lacands_get_post_data($post);
		$lacands_opt_cntr_font_color = 	str_replace('#', '', $lacands_opt_cntr_font_color);
		$lacands_opt_cntr_font_color = 	trim($lacands_opt_cntr_font_color);
		$args = array();
		$args['blog'] =				get_bloginfo('name');
		$args['link'] = 			$post_data['link'];
		$args['title'] = 			$post_data['title'];
		$args['desc'] = 			$post_data['description'];
		$args['fc'] = 				$lacands_opt_cntr_font_color;
		$args['fs'] = 				$lacands_opt_widget_font_style;
		$args['fblname'] = 			$lacands_opt_widget_fb_like;
		$args['fblref'] = 			$lacands_opt_widget_fb_ref;
		$args['fbllang'] = 			$lacands_opt_widget_fb_like_lang;
		$args['fblshow'] = 			$lacands_opt_widget_fb_like_show;
		$args['fbsbutton'] = 		$lacands_opt_widget_fb_share_button;
		$args['fbsctr'] = 			$lacands_opt_widget_fb_share_counter;
		$args['fbslang'] =			$lacands_opt_widget_fb_share_lang;
		$args['fbsendbutton'] = 	$lacands_opt_widget_fb_send_button;
		$args['twbutton'] = 		$lacands_opt_widget_twitter_button;
		$args['twlang'] = 			$lacands_opt_widget_twitter_lang;
		$args['twmention'] = 		$lacands_opt_widget_twitter_mention;
		$args['twrelated1'] = 		$lacands_opt_widget_twitter_related1;
		$args['twrelated2'] = 		$lacands_opt_widget_twitter_related2;
		$args['twctr'] = 			$lacands_opt_widget_twitter_counter;
		$args['lnkdshow'] = 		$lacands_opt_widget_linkedin_button;
		$args['lnkdctr'] = 			$lacands_opt_widget_linkedin_counter;
		$args['buzzbutton'] = 		$lacands_opt_widget_buzz_button;
		$args['buzzlang'] =			$lacands_opt_widget_buzz_lang;
		$args['buzzctr'] = 			$lacands_opt_widget_buzz_counter;
		$args['diggbutton'] = 		$lacands_opt_widget_digg_button;
		$args['diggctr'] = 			$lacands_opt_widget_digg_counter;
		$args['stblbutton'] = 		$lacands_opt_widget_stumble_button;
		$args['stblctr'] = 			$lacands_opt_widget_stumble_counter;
		$args['g1button'] = 		$lacands_opt_widget_g1_button;
		$args['g1ctr'] = 			$lacands_opt_widget_g1_counter;
		$args['g1lang'] = 			$lacands_opt_widget_g1_lang;
        if(isset($_SERVER['HTTP_REFERER'])) {
        	if(strlen($_SERVER['HTTP_REFERER']) < 300) {
            	$args['referer'] = $_SERVER['HTTP_REFERER'];
        	}
        }
		$args_data = http_build_query($args);
		if($lacands_opt_extra_params) {
        	$args_data = $args_data.'&'.$lacands_opt_extra_params;
        }
		
		$widget_width = 460;
		if($lacands_opt_widget_fb_share_button and $lacands_opt_widget_g1_button) {
			if($lacands_opt_widget_g1_counter) {
				$widget_width += 90;
			} else {
				$widget_width += 32;	
			}
		}
		
		$lacands_widget_display_cntrs = '<div style="'.$position.';">
											<iframe
												style="height:25px !important; border:0px solid gray !important; overflow:hidden !important; width:'.$widget_width.'px !important;" frameborder="0" scrolling="no" allowTransparency="true"
												src="http://www.linksalpha.com/social?'.$args_data.'">
											</iframe>
										</div>';
		if($show) {
			echo $lacands_widget_display_cntrs;
			return;
		}
		return $lacands_widget_display_cntrs;
	}
	return;
}


function lacands_wp_admin_options_settings () {
    global $lacands_opt_widget_counters_location, $lacands_widget_disable_cntr_display;
	global $lacands_opt_widget_margin_top, $lacands_opt_widget_margin_right, $lacands_opt_widget_margin_bottom, $lacands_opt_widget_margin_left;
	global $lacands_opt_cntr_font_color, $lacands_opt_widget_fb_like, $lacands_opt_widget_font_style;
	global $lacands_display_pages, $lacands_like_layout;
	global $lacandsnw_networkpub_settings;
	global $lacandsnw_opt_warning_msg;
	global $lacands_opt_widget_fb_ref, $lacands_opt_widget_fb_like_lang, $lacands_opt_widget_twitter_lang, $lacands_opt_widget_twitter_mention, $lacands_opt_widget_twitter_related1, $lacands_opt_widget_twitter_related2, $lacands_opt_widget_twitter_counter, $lacands_opt_widget_linkedin_button;
	global $lacands_opt_widget_fb_share_counter, $lacands_opt_widget_fb_like_show, $lacands_opt_widget_linkedin_counter, $lacands_opt_widget_fb_share_lang, $lacands_opt_widget_fb_share_button, $lacands_opt_widget_fb_send_button;
	global $lacands_opt_widget_buzz_counter, $lacands_opt_widget_digg_counter, $lacands_opt_widget_stumble_counter;
	global $lacands_opt_widget_g1_button, $lacands_opt_widget_g1_counter, $lacands_opt_widget_g1_lang;
	global $lacands_opt_widget_buzz_button, $lacands_opt_widget_buzz_lang, $lacands_opt_widget_fb_like_button, $lacands_opt_widget_digg_button, $lacands_opt_widget_stumble_button, $lacands_opt_widget_twitter_button;
    global $lacands_opt_widget_display_password_protected, $lacands_opt_widget_display_not_postids;
    global $lacands_opt_widget_mobile_hide;
    global $lacands_opt_fb_app_id, $lacands_opt_fb_metatags, $lacands_opt_googleplus_metatags, $lacands_opt_googleplus_page_type, $lacands_opt_extra_params;
    
	if (isset($_POST['lacands_widget_update'])) {
		if ( function_exists('current_user_can') && !current_user_can('manage_options') ) {
			die(__('Cheatin&#8217; uh?'));
		}
		lacands_writeOptionsValuesToWPDatabase('update');
		echo '<div id="message" class="updated fade" style="margin:20px;text-align:center;"><p><strong>'.LACANDS_SETTINGS_SAVED.'</strong></p></div>';
		echo '</strong></p></div>';
	}
	
	if (isset($_POST['AddAPIKey'])) {
		if ( function_exists('current_user_can') && !current_user_can('manage_options') ) {
			die(__('Cheatin&#8217; uh?'));
		}
		$field_name = sprintf('%s_%s', LACANDSNW_WIDGET_PREFIX, 'api_key');
		$value = strip_tags(stripslashes($_POST[$field_name]));
		if($value) {
			$networkadd = lacandsnw_networkpub_add($value);
		}
	}
	
	if (isset($_POST['warning_msg'])) {
		if ( function_exists('current_user_can') && !current_user_can('manage_options') ) {
			die(__('Cheatin&#8217; uh?'));
		}
		if(!empty($_POST['lacandsnw-html-warning-msg'])) {
			update_option('lacandsnw-html-warning-msg',  (string)$_POST['lacandsnw-html-warning-msg']);
		} else {
			update_option('lacandsnw-html-warning-msg', '0');
		}
		echo '<div id="message" class="updated fade" style="margin:20px;text-align:center;"><p><strong>'.LACANDS_SETTINGS_SAVED.'</strong></p></div>';
		echo '</strong></p></div>';
	}
	
	if (isset($_POST['extra_params'])) {
		if ( function_exists('current_user_can') && !current_user_can('manage_options') ) {
			die(__('Cheatin&#8217; uh?'));
		}
		if(!empty($_POST['lacands-html-extra-params'])) {
			update_option('lacands-html-extra-params', 							$_POST['lacands-html-extra-params']);
		} else {
			update_option('lacands-html-extra-params', 							'');
		}
		echo '<div id="message" class="updated fade" style="margin:20px;text-align:center;"><p><strong>'.LACANDS_SETTINGS_SAVED.'</strong></p></div>';
		echo '</strong></p></div>';
	}
	
	if ( !empty($_GET['linksalpha_request_type'])) {
		if($_GET['linksalpha_request_type'] == 'get_posts') {
 			lacandsnw_get_posts();
 		}		
 		return;
	}
	//NetworkPub
	$curr_field = 'api_key';
	$field_name = sprintf('%s_%s', LACANDSNW_WIDGET_PREFIX, $curr_field);
	global $lacandsnw_auth_error_show, $lacandsnw_mixed_mode_alert_show;
	lacandsnw_load_options();
	
	//Defaults
	lacands_readOptionsValuesFromWPDatabase();
	require("la-click-and-share-comboAdmin.html");	
}


function lacands_wp_admin() {
	if (function_exists('add_options_page')) {
	    add_options_page('1-click Retweet/Share/Like', '1-click Retweet/Share/Like', 'manage_options', __FILE__, 'lacands_wp_admin_options_settings');
	}
}


function lacands_pages() {
	if ( function_exists('add_submenu_page') ) {
		if(!lacandsnw_networkpubcheck()) {
			$page = add_submenu_page('edit.php', 	LACANDSNW_WIDGET_NAME_POSTBOX, LACANDSNW_WIDGET_NAME_POSTBOX, 'manage_options', LACANDSNW_WIDGET_NAME_POSTBOX_INTERNAL, 'lacandsnw_postbox');
		}
	}	
}


function lacands_activate() {
	lacands_writeOptionsValuesToWPDatabase('default');
}


function lacands_deactivate() {
	lacands_writeOptionsValuesToWPDatabase('delete');
}


function lacands_warning() {
	$options 		= get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	$show_warning_msg 	= get_option('lacandsnw-html-warning-msg');

	if( ($show_warning_msg == 1) || (!empty($options['api_key']) ) ) {
		return;
	} else {
		$html = "<div class='updated fade lacands_warning_message'>
					<div class='lacands_warning_message_header'><a href=\"http://wordpress.org/extend/plugins/1-click-retweetsharelike/\" target=\"_blank\">".LAECHONW_WIDGET_NAME."</a>&nbsp;".LACANDS_PLUGIN_IS_ALMOST_READY."</div>
					<ol>";
		if(empty($options['api_key'])) {
			if (!isset($_POST['AddAPIKey'])) {
			    $html .= "<li><span class='lacands_warning_message_ol_item_header lacands_warning_message_ol_item_header_alert'>".__('Pending:')."</span><span>&nbsp;<a href='".LACANDS_PLUGIN_ADMIN_URL."'>".__('Enter your API key')."</a>&nbsp;".__('to automatically post your blog articles to Social Networks (Twitter, Facebook Profile, Facebook Pages, LinkedIn, MySpace, Yammer, Yahoo, and Identi.ca)')."</span></li>";
			}
		}
		if(!empty($options['api_key'])) {
		    $html .= 	"<li>
							<div>
								<span class='lacands_warning_message_ol_item_header'>".__('Done:')."</span>
								<span>".__('Automatic posting of your blog articles to 20+ Social Networks including Twitter, Facebook Profile, Facebook Pages, LinkedIn, MySpace, Yammer, Yahoo, Identi.ca, etc.')."</span>
							</div>
						</li>";
		}
		$html .= "<li><span class='lacands_warning_message_ol_item_header'>".__('Done:')."</span><span>&nbsp;".__('Displaying Social Buttons')."</span></li></ol>";
		$html .= "<div>".__("To disable this message, go to Settings->").LAECHONW_WIDGET_NAME.__("->Show/Hide Message and check the checkbox and save changes.")."</div></div>";
		echo $html;
	}
}


function lacands_la_langs() {
	$langs = array();
	$response_full = lacands_http_post("http://www.facebook.com/translations/FacebookLocales.xml", array());
	$response_code = $response_full[0];
	if ($response_code == 200) {
		preg_match_all('/<locale>\s*<englishName>([^<]+)<\/englishName>\s*<codes>\s*<code>\s*<standard>.+?<representation>([^<]+)<\/representation>/s', utf8_decode($response_full[1]), $langslist, PREG_PATTERN_ORDER);
		foreach ($langslist[1] as $key=>$val) {
			$langs[$langslist[2][$key]] = $val;
		}
	} else {
		$langs['default'] = "Default";
	}
	return $langs;
}


function lacands_fbs_langs() {
	$langs = array();
	$response_full = lacands_http_post("http://www.linksalpha.com/a/translate", array('type'=>'share'));
	$response_code = $response_full[0];
	if ($response_code == 200) {
		$response = lacandsnw_json_decode($response_full[1]);
		foreach($response->results as $key=>$val) {
			$langs[$key] = $val;
		}
	} else {
		$langs['en'] = "English";
	}
	return $langs;
}


function lacands_googleplus_langs() {
	$langs = array();
	$response_full = lacands_http_post("http://www.linksalpha.com/a/socialbuttonlangs", array('type'=>'googleplus'));
	$response_code = $response_full[0];
	if ($response_code == 200) {
		$response = lacandsnw_json_decode($response_full[1]);
		foreach($response as $key=>$val) {
			$langs[$key] = $val;
		}
	} else {
		$langs['en-US'] = "English (US)";
	}
	return $langs;
}


function lacands_twitter_langs() {
	$langs = array();
	$response_full = lacands_http_post("http://www.linksalpha.com/a/socialbuttonlangs", array('type'=>'twitter'));
	$response_code = $response_full[0];
	if ($response_code == 200) {
		$response = lacandsnw_json_decode($response_full[1]);
		foreach($response as $key=>$val) {
			$langs[$key] = $val;
		}
	} else {
		$langs['en'] = "English";
	}
	return $langs;
}


function lacands_get_post_data($p) {
	$post_data = array();
	$post_data['title'] 		=	lacands_prepare_text($p->post_title);
	$post_data['link'] 			=	get_permalink($p);
	$post_data['description'] 	= 	lacands_prepare_text($p->post_content);
	$post_data['image'] 		= 	lacands_thumbnail_link($p->ID, $p->post_content);
	return $post_data;
}


function lacands_fb_recommendations() {
	global $lacands_opt_widget_fb_reco_width, $lacands_opt_widget_fb_reco_height, $lacands_opt_widget_fb_reco_header, $lacands_opt_widget_fb_reco_color, $lacands_opt_widget_fb_reco_font, $lacands_opt_widget_fb_reco_border;
	global $lacands_opt_widget_fb_reco_margin_top, $lacands_opt_widget_fb_reco_margin_right, $lacands_opt_widget_fb_reco_margin_bottom, $lacands_opt_widget_fb_reco_margin_left;
	global $lacands_opt_widget_fb_reco_title;
	lacands_readOptionsValuesFromWPDatabase();
	$args = array('site'=>get_bloginfo('url'),'width'=>$lacands_opt_widget_fb_reco_width, 'height'=>$lacands_opt_widget_fb_reco_height, 'header'=>$lacands_opt_widget_fb_reco_header, 'colorscheme'=>$lacands_opt_widget_fb_reco_color, 'font'=>$lacands_opt_widget_fb_reco_font, 'border_color'=>$lacands_opt_widget_fb_reco_border);
	$args_data = http_build_query($args, '', '&amp;');
	$html  = '<div style="margin:'.$lacands_opt_widget_fb_reco_margin_top.'px '.$lacands_opt_widget_fb_reco_margin_right.'px '.$lacands_opt_widget_fb_reco_margin_bottom.'px '.$lacands_opt_widget_fb_reco_margin_left.'px">';
	if($lacands_opt_widget_fb_reco_title) {
		$html .= '<h3 class="widget-title">'.$lacands_opt_widget_fb_reco_title.'</h3>';
	}
	$html .= '<iframe src="http://www.facebook.com/plugins/recommendations.php?'.$args_data.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:300px;" allowTransparency="true"></iframe>';
	$html .= '</div>';
	echo $html;
	return;
}

function lacands_fb_recommendations_settings($data) {
	$fb_reco_options = array('lacands-html-widget-fb-reco-width'=>'300', 'lacands-html-widget-fb-reco-height'=>'300', 'lacands-html-widget-fb-reco-header'=>'true', 'lacands-html-widget-fb-reco-color'=>'light', 'lacands-html-widget-fb-reco-font'=>'arial', 'lacands-html-widget-fb-reco-border'=>'#AAAAAA', 'lacands-html-widget-fb-reco-margin-top'=>'10', 'lacands-html-widget-fb-reco-margin-right'=>'0', 'lacands-html-widget-fb-reco-margin-bottom'=>'10', 'lacands-html-widget-fb-reco-margin-left'=>'0', 'lacands-html-widget-fb-reco-title'=>'');
	foreach($fb_reco_options as $key=>$val) {
		if(!get_option($key)) {
			add_option($key, $val);
		}
	}
	global $lacands_opt_widget_fb_reco_width, $lacands_opt_widget_fb_reco_height, $lacands_opt_widget_fb_reco_header, $lacands_opt_widget_fb_reco_color, $lacands_opt_widget_fb_reco_font, $lacands_opt_widget_fb_reco_border;
	global $lacands_opt_widget_fb_reco_margin_top, $lacands_opt_widget_fb_reco_margin_right, $lacands_opt_widget_fb_reco_margin_bottom, $lacands_opt_widget_fb_reco_margin_left;
	global $lacands_opt_widget_fb_reco_title;
	lacands_readOptionsValuesFromWPDatabase();
	foreach($fb_reco_options as $key=>$val) {
		if($key != 'lacands-html-widget-fb-reco-title') {
			if(!empty($_POST[$key])) {
				update_option($key, (string)$_POST[$key]);
			}
		} else {
			if(!empty($_POST[$key])) {
				update_option($key, (string)$_POST[$key]);
			} else {
				update_option($key, '');
			}
		}
	}
	require("la-click-and-share-fb-recommendation.html");
}

function lacands_set_options() {
	add_option('lacands-html-fb-app-id', 							'');
    add_option('lacands-html-fb-metatags', 							1);
    add_option('lacands-html-googleplus-metatags', 					1);
    add_option('lacands-html-googleplus-page-type', 				'Article');
    add_option('lacands-html-extra-params', 						'');
}

function lacands_main() {
	lacands_init();
	lacands_writeOptionsValuesToWPDatabase_twitter();
	$dims = array('width' => 250, 'height' => 300);
	$widget_ops = array('description' => LACANDS_FB_RECOMMENDATIONS_NAME);
	register_activation_hook( __FILE__, 'lacands_activate' );
	if ( is_admin() ) {
		lacands_set_options();
		lacandsnw_set_options();
		wp_enqueue_style('thickbox');
		wp_enqueue_script('jquery');
		wp_enqueue_script('thickbox');
		wp_register_script('postmessagejs', LACANDS_PLUGIN_URL .'jquery.ba-postmessage.min.js');
		wp_enqueue_script('postmessagejs');
		wp_register_script('lacandsjs', LACANDS_PLUGIN_URL.'la-click-and-share.js');
		wp_enqueue_script ('lacandsjs');
		wp_register_style ('lacandsnetworkpubcss', LACANDS_PLUGIN_URL.'la-click-and-share-networkpub.css');
		wp_enqueue_style  ('lacandsnetworkpubcss');
		add_action('admin_menu',  'lacands_wp_admin');
		add_action('admin_menu',  'lacands_pages');
		add_action('admin_notices', 'lacands_warning');
		add_action('activate_{$plugin}', 'lacandsnw_pushpresscheck');
		add_action('activated_plugin', 'lacandsnw_pushpresscheck');
		wp_register_widget_control(LACANDS_FB_RECOMMENDATIONS_ID, LACANDS_FB_RECOMMENDATIONS_NAME, 'lacands_fb_recommendations_settings', $dims, $widget_ops);
	}
	add_filter ( 'the_content', 'lacands_wp_filter_post_content');
	wp_register_sidebar_widget(LACANDS_FB_RECOMMENDATIONS_ID, LACANDS_FB_RECOMMENDATIONS_NAME, 'lacands_fb_recommendations', $widget_ops);
	register_deactivation_hook( __FILE__, 'lacands_deactivate' );
}


// Add a link to this plugin's settings page
function lacands_actlinks( $links ) { 
    $settings_link = '<a href="'.LACANDS_PLUGIN_ADMIN_URL.'">Settings</a>'; 
    array_unshift( $links, $settings_link ); 
    return $links; 
}
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'lacands_actlinks' ); 


add_action ( 'init', 								'lacandsnw_networkpub_remove' );
add_action ( 'init', 								'lacandsnw_get_posts' );

add_action ( 'xmlrpc_publish_post',                 'lacandsnw_networkping' );
add_action ( '{$new_status}_{$post->post_type}',	'lacandsnw_networkping' );
add_action ( 'publish_post',                    	'lacandsnw_networkping' );
add_action ( 'future_to_publish', 					'lacandsnw_networkping' );
add_action ( 'transition_post_status',              'lacandsnw_networkping_custom',     12,     3 );

add_action ( 'xmlrpc_publish_post',                 'lacandsnw_post_xmlrpc' );
add_action ( '{$new_status}_{$post->post_type}', 	'lacandsnw_post' );
add_action ( 'publish_post', 						'lacandsnw_post' );
add_action ( 'future_to_publish', 					'lacandsnw_post' );
add_action ( 'transition_post_status',              'lacandsnw_post_custom',            12,     3 );

add_action ( '{$new_status}_{$post->post_type}', 	'lacandsnw_convert' );
add_action ( 'publish_post', 						'lacandsnw_convert' );
add_action ( 'future_to_publish', 					'lacandsnw_convert' );

add_action ( 'wp_head',                             'lacands_fb_meta' );

add_action ( 'admin_menu',                          'lacandsnw_create_post_meta_box' );
add_action ( 'save_post',                           'lacandsnw_save_post_meta_box',       5,      2 );


add_filter ( 'language_attributes', 				'lacands_html_schema' );

lacands_main();

?>