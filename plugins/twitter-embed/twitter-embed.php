<?php
/*
 * Plugin Name: Twitter Embed
 * Plugin URI: http://kovshenin.com/wordpress/plugins/twitter-embed/
 * Description: Easily embed tweets in your WordPress posts and pages via shortcode, embed HTML or URL on a line by itself.
 * Version: 1.0.1
 * Author: kovshenin
 * Author URI: http://kovshenin.com
 * License: GPL2
 */

/**
 * Twitter Embed Plugin Class
 */
class Twitter_Embed_Plugin {
	
	// This regular expression is used to compare URLs against tweet status URLs
	private $regex = '#^https?://twitter\.com/(?:\#!/)?(\w+)/status(es)?/(\d+)$#i';
	
	// Fired when loading plugins
	function __construct() {
		add_shortcode( 'tweet', array( $this, 'tweet_shortcode_handler' ) );
		wp_embed_register_handler( 'twitter-embed', $this->regex, array( $this, 'tweet_embed_handler' ) );
		add_filter( 'pre_kses', array( $this, 'tweet_embed_reversal' ) );
	}
	
	/**
	 * Embed Reversal
	 *
	 * Filters pre_kses, looks for the twitter-tweet blockquote and
	 * replaces with the appropriate shortcode if one is found. This
	 * is used to reverse embed HTML into shortcodes for authors and
	 * other user levels where HTML is filtered.
	 *
	 * @uses DomDocument
	 */
	function tweet_embed_reversal( $content ) {
		if ( preg_match( '#<blockquote class="twitter-tweet">(.+)</blockquote>#', $content, $matches ) ) {
			$tweet_content = $matches[1];
			$doc = new DomDocument;
			$doc->loadHTML( $tweet_content );
			$links = $doc->getElementsByTagName( 'a' );
			foreach ( $links as $link ) {
				$link = $link->getAttribute( 'href' );
				if ( preg_match( $this->regex, $link ) ) {
					$content = str_replace( $matches[0], '[tweet ' . esc_url( $link ) . ']', $content );
					break;
				}
			}
		}
		
		return $content;
	}
	
	/**
	 * Tweet Embed Handler
	 *
	 * The "URL on a line by itself" embed handler for
	 * tweets. Attached in __construct, uses shortcode handler
	 * to output the embedded tweets.
	 *
	 * @uses tweet_shortcode_handler
	 */
	function tweet_embed_handler( $matches, $attr, $url, $rawattr ) {
		return $this->tweet_shortcode_handler( array( $url ) );
	}
	
	/**
	 * Tweet Shortcode Handler
	 *
	 * Handles the [tweet URL] shortcode, where URL is the 0'th
	 * attribute in $atts. Uses the classes regex to match URL.
	 * Queries the Twitter API /oembed method and caches in post
	 * meta.
	 *
	 * @uses wp_remote_get, wp_remote_retrieve_body, get_post_meta, update_post_meta
	 */
	function tweet_shortcode_handler( $atts ) {
		global $post, $content_width;

		if ( ! isset( $atts[0] ) || ! preg_match( $this->regex, $atts[0], $matches ) ) return;
		
		$url = $atts[0];
		$author = $matches[1];
		$tweet_id = $matches[3];
		$meta_key = '_tweet-' . $tweet_id;
		
		$tweet = get_post_meta( $post->ID, $meta_key, true );
		
		if ( ! $tweet || empty( $tweet ) ) {

			$query_args = array( 'id' => $tweet_id, 'lang' => 'en', 'maxwidth' => $content_width );
			$response = wp_remote_get( add_query_arg( $query_args, 'https://api.twitter.com/1/statuses/oembed.json' ) );
			if ( ! is_wp_error( $response ) ) {
				$body = wp_remote_retrieve_body( $response );
				$tweet = json_decode( $body );
				$tweet = $tweet->html;
				
				update_post_meta( $post->ID, $meta_key, $tweet );
			} else {
				trigger_error( $response->get_error_message() );
			}
		}
		
 		return $tweet;
	}
}

// Initialize an object
$twitter_embed_plugin = new Twitter_Embed_Plugin;