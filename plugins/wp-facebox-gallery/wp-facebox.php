<?php
/*
Plugin Name: Facebox Gallery
Plugin URI: http://www.crunchingpixels.com/portfolio/2010/02/wp-facebox-gallery/
Description: Facebox gallery is a lightbox alternative using jQuery and styled like a facebook modal box. Facebox gallery is derived from <a href="http://wordpress.org/extend/plugins/wp-facebox/" target="_blank">Daniel Stockman's Facebox v1.2.2</a> and turned into a gallery plugin much like that at famspam.com. Additional enhancements include image titles and descriptions/captions.
Version: 2.0
Author: Dave Bergschneider
Author URI: http://www.crunchingpixels.com
*/

class WP_Facebox {
	var $opts;
	var $site;
	var $home;
	var $root; // plugin root dir
    var $ver = 3;

	/*
		Utilities
	*/
	function header() {
        if ( $this->ver == 1 ) {
            echo <<<HTML
<link rel="stylesheet" type="text/css" href="{$this->root}/facebox.css" />
<script type="text/javascript">/* wp-facebox */
	WPFB = { root: "{$this->root}", home: "{$this->home}", site: "{$this->site}" };
	WPFB.options = { loadingImage: WPFB.root + '/images/v2/loading.gif', closeImage: WPFB.root + '/images/v2/closelabel.gif', opacity: 0.5 };
</script>\n
HTML;
        } elseif ( $this->ver == 2 ) {
            echo <<<HTML
<link rel="stylesheet" type="text/css" href="{$this->root}/facebox2.css" />
<script type="text/javascript">/* wp-facebox */
	WPFB = { root: "{$this->root}", home: "{$this->home}", site: "{$this->site}" };
	WPFB.options = {
        loading_image   : WPFB.root + '/images/v2/loading.gif',
        close_image     : WPFB.root + '/images/v2/closelabel.gif',
        image_types     : [ 'png', 'jpg', 'jpeg', 'gif' ],
        next_image      : WPFB.root + '/images/v2/fast_forward.png',
        prev_image      : WPFB.root + '/images/v2/rewind.png',
        play_image      : WPFB.root + '/images/v2/play.png',
        pause_image     : WPFB.root + '/images/v2/pause.png'
    };
</script>\n
HTML;
        } elseif ( $this->ver == 3 ) {
            echo <<<HTML
<link rel="stylesheet" type="text/css" href="{$this->root}/facebox3.css" />
<script type="text/javascript">/* wp-facebox */
	WPFB = { root: "{$this->root}", home: "{$this->home}", site: "{$this->site}" };
	WPFB.options = {
		image_types     : [ 'png', 'jpg', 'jpeg', 'gif' ],
		loadingImage	: WPFB.root + '/images/v3/loading.gif',
		closeImage		: WPFB.root + '/images/v3/closelabel.png',
		next_image      : WPFB.root + '/images/v3/fast_forward.png',
        prev_image      : WPFB.root + '/images/v3/rewind.png',
        play_image      : WPFB.root + '/images/v3/play.png',
        pause_image     : WPFB.root + '/images/v3/pause.png'
	};
</script>\n
HTML;
        }
	}

	function invoke_header() {
		$selectors = array();
		if ( $this->opts['do_default'] ) $selectors[] = "a[rel*='facebox']";
		if ( $this->opts['do_gallery'] ) $selectors[] = ".gallery-item a";
		$selectors = implode(', ', $selectors);
		if ( !empty($selectors) )
			echo "<script type=\"text/javascript\">if (jQuery && jQuery.facebox) jQuery(function($) { $(\"$selectors\").facebox(WPFB.options); });</script>\n";
	}

	function rel_replace( $content ) {
		$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
		$replacement = '<a$1href=$2$3.$4$5 rel="facebox"$6>$7</a>';
		$content = preg_replace($pattern, $replacement, $content);
		return $content;
	}

	function filter_gallery_link( $link, $id ) {
		// By default, the gallery shortcode creates permalinks to the attachment
		// Facebox, however, expects a direct link to the resource
		// wp_get_attachment_url does this for us
		// I <3 filters
		return wp_get_attachment_url( $id );
	}

	/*
		Init / Constructor
	*/
	function init() {
		$this->home = get_option('home');
		$this->site = get_option('siteurl');
		$this->root = $this->site . '/wp-content/plugins/wp-facebox-gallery';

        if ( $this->ver == 1) {
            wp_register_script( 'facebox', "{$this->root}/facebox.js", array('jquery'), '1.2' );
        } elseif ( $this->ver == 2) {
            wp_register_script( 'facebox', "{$this->root}/facebox2.js", array('jquery'), '2.0' );
        } elseif ( $this->ver == 3) {
            wp_register_script( 'facebox', "{$this->root}/facebox3.js", array('jquery'), '3.0' );
        }

		if ( $this->opts['loadscript'] ) {
			wp_enqueue_script( 'facebox' );
			add_action( 'wp_print_scripts', array(&$this, 'header') );
			add_action( 'wp_head',   array(&$this, 'invoke_header') );
			// turn gallery permalinks into direct links
			add_filter( 'attachment_link', array(&$this, 'filter_gallery_link'), 11, 2 );
		}

		if ( $this->opts['autofilter'] ) {
			add_filter( 'the_content', array(&$this, 'rel_replace') );
		}
	}

	function WP_Facebox() {	// constructor
		// TODO: implement admin options interface for these values
		// For the time being, turn off options by replacing 1 with 0
		$this->opts = array(
			'autofilter' => 1,
			'do_default' => 1,
			'do_gallery' => 1,
			'loadscript' => 1
		);
		// don't disable 'loadscript', unless you're only after the header output
		$this->init();
	}
}

// make those julienne fries, baby
$wp_facebox = new WP_Facebox();

?>