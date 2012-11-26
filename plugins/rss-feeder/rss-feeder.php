<?php
/*
Plugin Name: RSS Feeder
Plugin URI: http://www.wpxpand.com
Description:
Author: WPXpand
Version: 0.5.1
Author URI: http://www.wpxpand.com
*/
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

/**
 * AJAX processing
 *
 * @author Steven Raynham
 * @since 0.5
 *
 * @param stdin
 * @return null
 */
if ( isset( $_POST['ajax'] ) ) {
	require( dirname(__FILE__) . '/../../../wp-config.php' );
	wp_cache_init();
	$nonce = wp_create_nonce( 'rss-feeder' );
	if ( isset( $_POST['nonce'] ) && ( $_POST['nonce'] == $nonce ) ) {
		switch ( $_POST['ajax'] ) {
			case 'external':
				if ( isset( $_POST['ajaxaction'] ) ) {
					switch ( $_POST['ajaxaction'] ) {
						case 'activate':
							if ( isset( $_POST['id'] ) ) {
								$sql = "UPDATE " . $wpdb->prefix . "rss_feeder_external " .
									   "SET active='1' " .
									   "WHERE id='" . $_POST['id'] . "';";
							}
							break;
						case 'deactivate':
							if ( isset( $_POST['id'] ) ) {
								$sql = "UPDATE " . $wpdb->prefix . "rss_feeder_external " .
									   "SET active='0' " .
									   "WHERE id='" . $_POST['id'] . "';";
							}
							break;
					}
					if ( isset( $sql ) ) {
						$wpdb->query( $sql );
					}
				}
				break;
			case 'custom':
				if ( isset( $_POST['ajaxaction'] ) ) {
					switch ( $_POST['ajaxaction'] ) {
						case 'activate':
							if ( isset( $_POST['id'] ) ) {
								$sql = "UPDATE " . $wpdb->prefix . "rss_feeder_custom " .
									   "SET active='1' " .
									   "WHERE id='" . $_POST['id'] . "';";
							}
							break;
						case 'deactivate':
							if ( isset( $_POST['id'] ) ) {
								$sql = "UPDATE " . $wpdb->prefix . "rss_feeder_custom " .
									   "SET active='0' " .
									   "WHERE id='" . $_POST['id'] . "';";
							}
							break;
					}
					if ( isset( $sql ) ) {
						$wpdb->query( $sql );
					}
				}
				break;
		}
	}
	exit;
}

if ( !@defined( RSS_FEEDER_PATH ) ) define( 'RSS_FEEDER_PATH', dirname( __FILE__ ) . '/' );
else wp_die( __( 'RSS Feeder plugin conflicts with another plugin. Please contact the developer with a full list of your plugins.' ), 'Plugin error' );

if ( !@defined( RSS_FEEDER_URL ) ) define( 'RSS_FEEDER_URL', WP_PLUGIN_URL . '/' . str_replace( basename( __FILE__ ), '', plugin_basename( __FILE__ ) ) );
else wp_die( __( 'RSS Feeder plugin conflicts with another plugin. Please contact the developer with a full list of your plugins.' ), 'Plugin error' );

include_once( 'debug.php' );
require_once( RSS_FEEDER_PATH . 'includes/functions.php' );

/**
 * RSS Feeder Class
 *
 * @copyright 2009 Business Xpand
 * @license GPL v2.0
 * @author Steven Raynham
 * @version 0.5.1
 * @link http://www.businessxpand.com/
 * @since File available since Release 0.5
 */
if ( !class_exists( 'RssFeeder' ) ) {
	class RssFeeder
	{
		/**
		 * Set initial variables
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 */
		var $message, $nonce, $helpStyle;
		var $buttonList = "'bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','hr','forecolor','bgcolor','link','unlink','xhtml'";
		var $defaultWidgetOptions = array(
			'title' => 'RSS Feed'
		);
		var $bxNews;

		/**
		 * Construct class
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param void
		 * @return null
		 */
		function RssFeeder()
		{
			if (is_admin()) {
				$this->helpStyle = 'background-color:#FFFFBF;padding:3px;border:1px solid;font-size:8pt;word-wrap:break-word;max-width:300px;';
				add_action( 'init', array( &$this, 'initAdmin' ) );
				add_action( 'admin_menu', array( &$this, 'adminMenu' ) );
				add_action( 'admin_footer', array( &$this, 'adminFooter' ) );
				if ( !class_exists( 'BxNews' ) ) include_once( RSS_FEEDER_PATH . '/includes/class-bx-news.php' );
				$this->bxNews = new BxNews( 'http://www.wpxpand.com/feeds/wordpress-plugins/', false );
			} else {
				add_filter( 'generate_rewrite_rules', array( &$this, 'generateRewriteRules' ) );
				add_filter( 'query_vars', array( &$this, 'queryVars' ) );
				add_action( 'init', array( &$this, 'initWp' ) );
				add_action( 'wp_head', array( &$this, 'wpHead' ) );
				add_filter( 'the_content', array( &$this, 'theContent' ) );
			}
			add_action( 'widgets_init', array( &$this, 'widgetsInit') );
		}

		/**
		 * Initialize admin
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param void
		 * @return null
		 */
		function initAdmin()
		{
			$this->nonce = wp_create_nonce( 'rss-feeder' );
			ob_start();
		}

		/**
		 * Setup admin menu
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param void
		 * @return null
		 */
		function adminMenu()
		{
			add_menu_page( __( 'RSS Feeder' ), __( 'RSS Feeder' ), 'level_7', basename( __FILE__ ), array( &$this, 'menuPage' ) );
			add_submenu_page( basename( __FILE__ ), __( 'External Feeds' ), __( 'External Feeds' ), 'level_7', 'rssfeeder-external', array( &$this, 'externalFeeds' ) );
			add_submenu_page( basename( __FILE__ ), __( 'Custom Feeds' ), __( 'Custom Feeds' ), 'level_7', 'rssfeeder-custom', array( &$this, 'customFeeds' ) );
			add_submenu_page( basename( __FILE__ ), __( 'Import Feeds' ), __( 'Import Feeds' ), 'level_7', 'rssfeeder-import', array( &$this, 'importFeeds' ) );
			add_submenu_page( basename( __FILE__ ), __( 'Help' ), __( 'Help' ), 'level_7', 'rssfeeder-help', array( &$this, 'help' ) );
		}

		/**
		 * Flush output of admin
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param void
		 * @return null
		 */
		function adminFooter()
		{
			ob_end_flush;
		}

		/**
		 * Main menu page
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param void
		 * @return null
		 */
		function menuPage()
		{
			global $wpdb;
			$options = get_option( 'rss_feeder' );
			if ( !class_exists( 'IslForm' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-forms.php' );
			$this->nonce = wp_create_nonce( 'rss-feeder' );
			$form = new IslForm();
			$form->setForm( array( 'action' => $this->cleanUrl( $_SERVER['REQUEST_URI'], array( 'page', 'redirect' ) ), 'method' => 'post' ) );
			$form->title = __( 'RSS Feeder' );
			$form->addField( 'hidden', array( 'name' => 'action',
											  'forcedvalue' => 'update' ) );
			$form->addField( 'hidden', array( 'name' => 'nonce',
											  'forcedvalue' => $this->nonce ) );
			$form->addField( 'text', array( 'name' => 'rss_feeder[permalink]',
											'label' => __( 'Permalink' ),
											'help' => array( 'content' => __( 'Use the %link% tag to reference the custom feed;<br/>e.g. /feeds/%link%/' ),
															 'contentparameters' => array( 'style' => $this->helpStyle ) ),
											'value' => rssFeederDisplayField( $options['permalink'] ),
											'validate' => array( 'type' => 'string',
																 'required' => true,
																 'length' => 255 ) ) );
			$form->addField( 'text', array( 'name' => 'rss_feeder[google_analytics]',
											'label' => __( 'Google Analytics Account' ),
											'help' => array( 'content' => __( 'You can track hits to your feed by adding your Google Analytics account number here;<br/>e.g. UA-123456-78' ),
															 'contentparameters' => array( 'style' => $this->helpStyle ) ),
											'value' => rssFeederDisplayField( ( isset( $options['google_analytics'] ) ? $options['google_analytics'] : '' ) ),
											'validate' => array( 'type' => 'string' ) ) );
			$form->addField( 'checkbox', array( 'name' => 'rss_feeder[wp_pages]',
												'label' => __( 'Include in Wordpress RSS' ),
												'help' => array( 'content' => __( 'You can adjust the existing Wordpress RSS here.' ),
																 'contentparameters' => array( 'style' => $this->helpStyle ) ),
												'options' => array( 'Include Pages in blog feed' => 'pages' ),
												'value' => isset( $options['wp_pages'] ) ? $options['wp_pages'] : '',
												'validate' => array( 'type' => 'string' ) ) );
			$sql = "SELECT t.term_id as id, t.name as name FROM " . $wpdb->prefix . "terms t, " . $wpdb->prefix . "term_taxonomy tt WHERE t.term_id=tt.term_id AND tt.taxonomy='category';";
			$results = $wpdb->get_results( $sql, ARRAY_A );
			if ( count( $results ) > 0 ) {
				foreach ( $results as $result ) {
					$categoriesArray[$result['name']] = $result['id'];
				}
				if ( !isset( $options['wp_categories'] ) ) $options['wp_categories'] = $wpCategories;
				$form->addField( 'multiselect', array( 'name' => 'rss_feeder[wp_categories]',
													   'html' => array( 'style' => 'height:auto;' ),
													   'label' => __( 'Show Just Categories' ),
													   'help' => array( 'content' => __( 'Select just the categories you would like to display, if nothing is selected all categories will be displayed. Due to the structure of Wordpress, pages will not display if categories are selected as pages have no associated category by default. Use CTRL+ to select more than one category.' ),
																		'contentparameters' => array( 'style' => $this->helpStyle ) ),
													   'options' => $categoriesArray,
													   'value' => ( isset( $options['wp_categories'] ) ? $options['wp_categories'] : '' ),
													   'validate' => array( 'type' => 'string' ) ) );
			}
			$form->addField( 'checkbox', array( 'name' => 'rss_feeder[wp_remove]',
												'label' => __( 'Remove Wordpress RSS' ),
												'help' => array( 'content' => __( 'You can remove existing Wordpress RSS feeds here. Removing these defaults will prevent the blog feeds from being linked in the header.' ),
																 'contentparameters' => array( 'style' => $this->helpStyle ) ),
												'options' => array( __( 'Post/comments' ) => 'posts',
																	__( 'Extras' ) => 'extras' ),
												'value' => maybe_unserialize( $options['wp_remove'] ),
												'validate' => array( 'type' => 'string' ) ) );
			$form->addField( 'submit', array( 'name' => 'submit',
											  'forcedvalue' => __( 'Save' ),
											  'html' => array( 'class' => 'button-primary' ) ) );
			if ( isset( $form->valid ) && $form->valid ) {
				if ( isset( $_REQUEST['nonce'] ) && ( $_REQUEST['nonce'] == $this->nonce ) ) {
					if ( isset( $_REQUEST['action'] ) ) {
						switch ( $_REQUEST['action'] ) {
							case 'update':
								if ( isset( $_REQUEST['rss_feeder'] ) ) {
									unset( $options );
									foreach ( $_REQUEST['rss_feeder'] as $field => $value ) {
										if ( is_array( $value ) ) $value = serialize( $value );
										if ( !empty( $value ) ) {
											$options[$field] = trim( $value );
										}
									}
									if ( get_option( 'rss_feeder' ) ) update_option( 'rss_feeder', $options ); add_option( 'rss_feeder', $options );
									$form->message = __( 'Settings updated' );
								}
								break;
						}
					}
				}
			}
			if ( !class_exists( 'IslTemplate' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-templates.php' );
			$template = new IslTemplate();
			$template->files = RSS_FEEDER_PATH . 'includes/template-admin.php';
			$template->elements = $form;
			$template->output( true );
?>
<div class="wrap">
	<?php $this->bxNews->getFeed( '', array( 'http://wordpress.org/extend/plugins/rss-feeder/' ) ); ?>
</div>
<?php
		}

		/**
		 * Generate rewrite rules
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param array $wp_rewrite
		 * @return null
		 */
		function generateRewriteRules( $wp_rewrite )
		{
			$options = get_option( 'rss_feeder' );
			$options['permalink'] = $this->cleanPermalink( $options['permalink'] );
			$newRules[$options['permalink']] = 'index.php?rssfeeder=$matches[1]';
			$wp_rewrite->rules = $newRules + $wp_rewrite->rules;
		}

		/**
		 * Clean up the rss permalink
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param string $permalink
		 * @return string
		 */
		function cleanPermalink( $permalink ) {
			$permalink = trim( $permalink, '/' );
			$permalink = preg_replace( '/^(.*)(%link%)(.*)$/i', '$1(.+)$3/?$', $permalink );
			return $permalink;
		}

		/**
		 * Get feeds permalink
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param string $link
		 * @return string
		 */
		function getFeedPermalink( $link ) {
			global $wpdb;
			if ( get_option( 'permalink_structure' ) ) {
				$options = get_option( 'rss_feeder' );
				$permalink = ltrim( $options['permalink'], '/' );
				$return = get_option( 'siteurl' ) . '/' . str_replace( '%link%', $link, $permalink );
			} else
				$return = get_option( 'siteurl' ) . '/?rssfeeder=' . $link;
			return $return;
		}

		/**
		 * Allocate the query variables
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param array $publicQueryVars
		 * @return array
		 */
		function queryVars( $publicQueryVars )
		{
			$publicQueryVars[] = 'rssfeeder';
			return $publicQueryVars;
		}

		/**
		 * Initialise blog
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param void
		 * @return null
		 */
		function initWp()
		{
			global $wpdb, $wp_rewrite;
			$options = get_option( 'rss_feeder' );
			if ( isset( $options['wp_remove'] ) ) {
				$wpRemove = maybe_unserialize( $options['wp_remove'] );
				if ( in_array( 'posts', $wpRemove ) ) remove_action( 'wp_head', 'feed_links', 2 );
				if ( in_array( 'extras', $wpRemove ) ) remove_action( 'wp_head', 'feed_links_extra', 3 );
			}
			if ( isset( $options['wp_pages'] ) ) add_filter( 'pre_get_posts', array( &$this, 'preGetPostsPages' ) );
			if ( isset( $options['wp_categories'] ) ) add_filter( 'pre_get_posts', array( &$this, 'preGetPostsCategories' ) );
			$wp_rewrite->flush_rules();
			ob_start();
		}

		function preGetPostsPages( $query )
		{
			if ( $query->is_feed ) $query->set( 'post_type', 'any' );
			return $query;
		}

		function preGetPostsCategories( $query )
		{
			if ( $query->is_feed ) {
				$options = get_option( 'rss_feeder' );
				if ( isset( $options['wp_categories'] ) ) {
					$categoriesArray = maybe_unserialize( $options['wp_categories'] );
					$categoryText = '';
					foreach ( $categoriesArray as $category ) {
						if ( !empty( $categoryText ) ) $categoryText .= ',';
						$categoryText .= $category;
					}
					$query->set( 'cat', $categoryText );
				}
			}
			return $query;
		}

		/**
		 * Add to blog header or generate RSS feed
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param void
		 * @return null
		 */
		function wpHead()
		{
			global $wpdb, $wp_query;
			$options = get_option( 'rss_feeder' );
			$rssFeeder = get_query_var( 'rssfeeder' );
			if ( empty( $rssFeeder ) ) {
				echo "\r\n";
				$sql = "SELECT title, url FROM " . $wpdb->prefix . "rss_feeder_external WHERE active = '1';";
				$results = $wpdb->get_results( $sql, ARRAY_A );
				if ( count( $results ) > 0 ) {
					foreach ( $results as $result ) {
						echo '<link rel="alternate" type="application/rss+xml" title="' . htmlentities( $result['title'] ) . '" href="' . $result['url'] . '"/>' . "\r\n";
					}
				}
				$sql = "SELECT title, link FROM " . $wpdb->prefix . "rss_feeder_custom WHERE active = '1';";
				$results = $wpdb->get_results( $sql, ARRAY_A );
				if ( count( $results ) > 0 ) {
					foreach ( $results as $result ) {
						echo '<link rel="alternate" type="application/rss+xml" title="' . htmlentities( $result['title'] ) . '" href="' . $this->getFeedPermalink( stripslashes( $result['link'] ) ) . '"/>' . "\r\n";
					}
				}
				ob_end_flush;
			} else {
				$sql = "SELECT * FROM " . $wpdb->prefix . "rss_feeder_custom WHERE link='" . $rssFeeder . "';";
				$headerResult = $wpdb->get_row( $sql, ARRAY_A );
				if ( count( $headerResult ) > 0 ) {
					ob_end_clean();
					if ( isset( $options['google_analytics'] ) && !empty( $options['google_analytics'] ) ) {
						if ( !class_exists( 'Galvanize' ) ) require_once( RSS_FEEDER_PATH . 'includes/Galvanize.php' );
						$googleAnalytics = new Galvanize( $options['google_analytics'] );
						$googleAnalytics->trackPageView( str_replace( '%link%', $headerResult['link'], $options['permalink'] ), $headerResult['title'] );
					}
					header( 'Content-type: application/rss+xml' );
					echo '<?xml version=\'1.0\'?>' . "\r\n";
	?>
	<rss version="2.0"
		xmlns:content="http://purl.org/rss/1.0/modules/content/"
		xmlns:wfw="http://wellformedweb.org/CommentAPI/"
		xmlns:dc="http://purl.org/dc/elements/1.1/"
		xmlns:atom="http://www.w3.org/2005/Atom"
		xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	>
	<channel>
	<title><?php echo stripslashes( $headerResult['title'] ); ?></title>
	<link><?php echo $this->getFeedPermalink( stripslashes( $headerResult['link'] ) ); ?></link>
	<description><?php echo $headerResult['description']; ?></description>
	<generator><?php _e( 'Wordpress RSS Feeder' ); ?></generator>
	<atom:link href="<?php echo $this->getFeedPermalink( stripslashes( $headerResult['link'] ) ); ?>" rel="self" type="application/rss+xml"/>
	<language>en</language>
	<sy:updatePeriod>hourly</sy:updatePeriod>
	<sy:updateFrequency>1</sy:updateFrequency>
	<?php
					if ( !empty( $headerResult['categories'] ) ) {
						$categories = explode( ',', $headerResult['categories'] );
						foreach ( $categories as $category ) {
	?>
	<category><![CDATA[<?php echo stripslashes( $category ); ?>]]></category>
	<?php
						}
					}
					$sql = "SELECT * FROM " . $wpdb->prefix . "rss_feeder_custom_items WHERE feed_id='" . $headerResult['id'] . "' AND pubdate<=NOW() ORDER BY pubdate DESC;";
					$itemResults = $wpdb->get_results( $sql, ARRAY_A );
					if ( count( $itemResults ) > 0 ) {
						$pubDateArray = strptime( stripslashes( $itemResults[0]['pubdate'] ), '%Y-%m-%d %H:%M:%S' );
						$pubDate = mktime( $pubDateArray['tm_hour'], $pubDateArray['tm_min'], $pubDateArray['tm_sec'], $pubDateArray['tm_mon'] + 1, $pubDateArray['tm_mday'], $pubDateArray['tm_year'] + 1900 );
	?>
	<pubDate><?php echo date( 'r', $pubDate ); ?></pubDate>
	<?php
						foreach ( $itemResults as $itemResult ) {
							$pubDateArray = strptime( stripslashes( $itemResult['pubdate'] ), '%Y-%m-%d %H:%M:%S' );
							$pubDate = mktime( $pubDateArray['tm_hour'], $pubDateArray['tm_min'], $pubDateArray['tm_sec'], $pubDateArray['tm_mon'] + 1, $pubDateArray['tm_mday'], $pubDateArray['tm_year'] + 1900 );
	?>
	<item>
		<title><?php echo stripslashes( $itemResult['title'] ); ?></title>
		<link><?php echo ( empty( $itemResult['link'] ) ? $this->getFeedPermalink( stripslashes( $headerResult['link'] ) ) : stripslashes( $itemResult['link'] ) ); ?></link>
		<pubDate><?php echo date( 'r', $pubDate ); ?></pubDate>
	<?php
							if ( !empty( $itemResult['categories'] ) ) {
								$categories = explode( ',', $itemResult['categories'] );
								foreach ( $categories as $category ) {
	?>
		<category><![CDATA[<?php echo stripslashes( $category ); ?>]]></category>
	<?php
								}
							}
	?>
		<guid isPermaLink="false"><?php echo 'rf-' . $itemResult['feed_id'] . '-' . $itemResult['id']; ?></guid>
	<?php if ( !empty( $itemResult['description'] ) ) { ?>
		<description><![CDATA[<?php echo stripslashes( $itemResult['description'] ); ?>]]></description>
	<?php } ?>
	<?php if ( !empty( $itemResult['content_encoded'] ) ) { ?>
		<content:encoded><![CDATA[<?php echo stripslashes( $itemResult['content_encoded'] ); ?>]]></content:encoded>
	<?php } ?>
	</item>
	<?php
						}
					}
	?>
	</channel>
	</rss><?php
					ob_end_flush;
					exit;
				} else {
					ob_end_flush;
				}
			}
		}

		/**
		 * External feeds menu
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param void
		 * @return null
		 */
		function externalFeeds()
		{
			global $wpdb;
			$showList = true;
			if ( !class_exists( 'IslForm' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-forms.php' );
			$form = new IslForm();
			$form->session = 'rss-feeder';
			$form->setForm( array( 'action' => $this->cleanUrl( $_SERVER['REQUEST_URI'], array( 'page', 'redirect' ) ), 'method' => 'post' ) );
			if ( isset( $_REQUEST['nonce'] ) && ( $_REQUEST['nonce'] == $this->nonce ) ) {
				if ( isset( $_REQUEST['action'] ) ) {
					$showList = false;
					switch ( $_REQUEST['action'] ) {
						case 'new':
							$form->title = __( 'Create new external feed' );
							$form->addField( 'hidden', array( 'name' => 'action',
															  'forcedvalue' => $_REQUEST['action'] ) );
							$form->addField( 'hidden', array( 'name' => 'formaction',
															  'forcedvalue' => 'save' ) );
							$form->addField( 'hidden', array( 'name' => 'nonce',
															  'forcedvalue' => $this->nonce ) );
							$form->addField( 'checkbox', array( 'name' => 'rss_feeder[active]',
																'options' => array( __( 'Active in header' ) => 1 ) ) );
							$form->addField( 'text', array( 'name' => 'rss_feeder[title]',
															'label' => __( 'Title' ),
															'help' => array( 'content' => __( 'This will appear as the title of the feed.' ),
																			 'contentparameters' => array( 'style' => $this->helpStyle ) ),
															'validate' => array( 'type' => 'string',
																				 'required' => true,
																				 'length' => 255 ) ) );
							$form->addField( 'text', array( 'name' => 'rss_feeder[url]',
															'label' => __( 'Feed URL' ),
															'help' => array( 'content' => __( 'The web address of the external feed.' ),
																			 'contentparameters' => array( 'style' => $this->helpStyle ) ),
															'validate' => array( 'type' => 'string',
																				 'required' => true,
																				 'length' => 255 ) ) );
							$form->addField( 'submit', array( 'name' => 'submit',
															  'forcedvalue' => __( 'Save' ),
															  'html' => array( 'class' => 'button-primary' ) ) );
							break;
						case 'setup':
							if ( isset( $_REQUEST['id'] ) ) $id = $_REQUEST['id'];
							elseif  ( isset( $_REQUEST['rss_feeder']['id'] ) ) $id = $_REQUEST['rss_feeder']['id'];
							$sql = "SELECT * FROM " . $wpdb->prefix . "rss_feeder_external WHERE id='" . $id . "';";
							$result = $wpdb->get_row( $sql, ARRAY_A );
							if ( count( $result ) > 0 ) {
								$form->title = __( 'Edit external feed' );
								$form->addField( 'hidden', array( 'name' => 'action',
																  'forcedvalue' => $_REQUEST['action'] ) );
								$form->addField( 'hidden', array( 'name' => 'formaction',
																  'forcedvalue' => 'save' ) );
								$form->addField( 'hidden', array( 'name' => 'nonce',
																  'forcedvalue' => $this->nonce ) );
								$form->addField( 'hidden', array( 'name' => 'rss_feeder[id]',
																  'forcedvalue' => rssFeederDisplayField( $result['id'] ) ) );
								$form->addField( 'checkbox', array( 'name' => 'rss_feeder[active]',
																	'options' => array( __( 'Active in header' ) => 1 ),
																	'value' => rssFeederDisplayField( $result['active'] ) ) );
								$form->addField( 'text', array( 'name' => 'rss_feeder[title]',
																'label' => __( 'Title' ),
																'help' => array( 'content' => __( 'This will appear as the title of the feed.' ),
																				 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																'value' => rssFeederDisplayField( $result['title'] ),
																'validate' => array( 'type' => 'string',
																					 'required' => true,
																					 'length' => 255 ) ) );
								$form->addField( 'text', array( 'name' => 'rss_feeder[url]',
																'label' => __( 'Feed URL' ),
																'help' => array( 'content' => __( 'The web address of the external feed.' ),
																				 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																'value' => rssFeederDisplayField( $result['url'] ),
																'validate' => array( 'type' => 'string',
																					 'required' => true,
																					 'length' => 255 ) ) );
								$form->addField( 'submit', array( 'name' => 'submit',
																  'forcedvalue' => __( 'Update' ),
																  'html' => array( 'class' => 'button-primary' ) ) );
							}
							break;
						case 'delete-selected':
							if ( isset( $_REQUEST['checked'] ) ) {
								foreach ( $_REQUEST['checked'] as $checked ) {
									$sql = "DELETE FROM " . $wpdb->prefix . "rss_feeder_external WHERE id = '" . $checked . "';";
									$wpdb->query( $sql );
								}
								$this->message = 'External feed deleted.';
							}
							$showList = true;
							break;
					}
					if ( count( $form->fields ) > 0 ) {
						if ( isset( $form->valid ) && $form->valid ) {
							if ( isset( $_REQUEST['formaction'] ) ) {
								switch ( $_REQUEST['formaction'] ) {
									case 'save':
										if ( isset( $_SESSION[$form->session]['rss_feeder'] ) ) {
											if ( !isset( $_REQUEST['rss_feeder']['active'] ) ) $_SESSION[$form->session]['rss_feeder']['active'] = 0;
											$sqlRssFeederQuery = '';
											foreach ( $_SESSION[$form->session]['rss_feeder'] as $field => $value ) {
												if ( $field != 'id' ) {
													if ( !empty( $sqlRssFeederQuery ) ) $sqlRssFeederQuery .= ',';
													$sqlRssFeederQuery .= $field . "='" . rssFeederDatabaseField( $value ) . "'";
												}
											}
										}
										if ( isset( $_SESSION[$form->session]['rss_feeder']['id'] ) ) {
											$sql = "SELECT id FROM " . $wpdb->prefix . "rss_feeder_external WHERE id = '" . $_SESSION[$form->session]['rss_feeder']['id'] . "';";
											if ( $id = $wpdb->get_var( $sql  ) ) {
												$rssFeederSql = "UPDATE " . $wpdb->prefix . "rss_feeder_external " .
																"SET " . $sqlRssFeederQuery . " " .
																"WHERE id='" . $id . "';";
												$this->message = 'External feed updated.';
											}
										} else {
												$rssFeederSql = "INSERT INTO " . $wpdb->prefix . "rss_feeder_external " .
																"SET " . $sqlRssFeederQuery . ";";
												$this->message = 'External feed added.';
										}
										if ( isset( $rssFeederSql ) ) {
											$showList = true;
											if ( $wpdb->query( $rssFeederSql ) === false ) {
												$this->message = 'Database failed to post.';
											}
										}
										break;
								}
							}
						}
					} else {
						$showList = true;
					}
				}
			}
			if ( $showList ) {
	?><div class='wrap'>
		<h2><?php _e( 'External Feeds' ); ?></h2>
		<?php if ( !empty( $this->message ) ) { ?><div id="message" class="updated fade"><p><strong><?php _e( $this->message ); ?></strong></p></div><?php } ?>
		<p>External feeds are hosted on other websites that you would like to link in your blog header. If these are not active in the header then your blog will not make any references to these feeds.</p>
		<hr/>
		<div><?php
				$form->clearFields();
				unset( $_REQUEST['rss_feeder'] );
				echo '<button id="rss_feeder_quick_add_new" class="button">' . __( 'New feed' ) . '</button>';
				echo '<div id="rss_feeder_quick_add">';
				echo '<button id="rss_feeder_quick_add_cancel" class="button">'. __( 'Cancel' ) . '</button>';
				$form->addField( 'hidden', array( 'name' => 'action',
												  'forcedvalue' => 'new' ) );
				$form->addField( 'hidden', array( 'name' => 'formaction',
												  'forcedvalue' => 'save' ) );
				$form->addField( 'hidden', array( 'name' => 'nonce',
												  'forcedvalue' => $this->nonce ) );
				$form->addField( 'checkbox', array( 'name' => 'rss_feeder[active]',
													'options' => array( __( 'Active in header' ) => 1 ) ) );
				$form->addField( 'text', array( 'name' => 'rss_feeder[title]',
												'label' => __( 'Title' ),
												'help' => array( 'content' => __( 'This will appear as the title of the feed.' ),
																 'contentparameters' => array( 'style' => $this->helpStyle ) ),
												'validate' => array( 'type' => 'string',
																	 'required' => true,
																	 'length' => 255 ) ) );
				$form->addField( 'text', array( 'name' => 'rss_feeder[url]',
												'label' => __( 'Feed URL' ),
												'help' => array( 'content' => __( 'The web address of the external feed.' ),
																 'contentparameters' => array( 'style' => $this->helpStyle ) ),
												'validate' => array( 'type' => 'string',
																	 'required' => true,
																	 'length' => 255 ) ) );
				$form->addField( 'submit', array( 'name' => 'submit',
												  'forcedvalue' => __( 'Save' ),
												  'html' => array( 'class' => 'button-primary' ) ) );
				if ( !class_exists( 'IslTemplate' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-templates.php' );
				$template = new IslTemplate();
				$template->files = RSS_FEEDER_PATH . 'includes/template-admin.php';
				$template->elements = $form;
				$template->output( true );
				echo '</div>';
				echo '<script type="text/javascript">
	/* <![CDATA[ */
	jQuery(document).ready(function(){
		jQuery("#rss_feeder_quick_add").hide();
		jQuery("#rss_feeder_quick_add_new").click(function(){
			jQuery("#rss_feeder_quick_add_new").hide("slow");
			jQuery("#rss_feeder_table").hide("slow");
			jQuery("#rss_feeder_quick_add").show("slow");
		});
		jQuery("#rss_feeder_quick_add_cancel").click(function(){
			jQuery("#rss_feeder_quick_add").hide("slow");
			jQuery("#rss_feeder_table").show("slow");
			jQuery("#rss_feeder_quick_add_new").show("slow");
		});
	})
	/* ]]> */
	</script>
	';
				$sql = "SELECT * FROM " . $wpdb->prefix . "rss_feeder_external;";
				$results = $wpdb->get_results( $sql, ARRAY_A );
				if ( count( $results ) > 0 ) {
					if ( !class_exists( 'WpAdminTable' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-wp-admin-table.php' );
					$wpAdminTable = new WpAdminTable;
					$wpAdminTable->nonce = array( 'rss-feeder', 'nonce' );
					$wpAdminTable->name = 'import-feeds';
					$wpAdminTable->headings = array( __( 'ID' ),
													 __( 'Active in header' ),
													 __( 'Title' ),
													 __( 'URL' ) );
					$options = get_option( 'rss_feeder' );
					foreach ( $results as $result ) {
						$wpAdminTable->data[$result['id']] = array( $result['id'],
																	'<input type="checkbox" id="' . $result['id'] . '" class="rss_feeder_active" value="1"' . ( ( $result['active'] == 1 ) ? ' checked="checked"' : '' ) . '/>',
																	rssFeederDisplayField( $result['title'] ),
																	'<a href="admin.php?page=' . $_GET['page'] . '&amp;nonce=' . $this->nonce . '&amp;action=setup&amp;id=' . urlencode( $result['id'] ) . '">' . rssFeederDisplayField( $result['url'] ) . '</a>' );
						$wpAdminTable->dataActions[$result['id']] = array( '<a href="admin.php?page=' . $_GET['page'] . '&amp;nonce=' . $this->nonce . '&amp;action=setup&amp;id=' . urlencode( $result['id'] ) . '">' . __( 'Setup' ) . '</a>' );
					}
					$wpAdminTable->bulkActions = array( __( 'Delete' ) => 'delete-selected' );
					echo '<div id="rss_feeder_table">';
					$wpAdminTable->output( true );
					echo '</div>';
					echo '<script type="text/javascript">
	/* <![CDATA[ */
	jQuery(document).ready(function(){
		jQuery("#doaction_external-feeds").click(function(){
			var answer = confirm("' . __( 'Are you sure you want to delete the selected feeds?' ) . '");
			return answer;
		});
		jQuery(".rss_feeder_active").click(function(){
			if (jQuery(this).is(":checked")){
				jQuery.ajax({async:false,
							 type:"POST",
							 url:"' . RSS_FEEDER_URL . 'rss-feeder.php",
							 data:"ajax=external&ajaxaction=activate&nonce=' . $this->nonce . '&id="+jQuery(this).attr("id")
							 });
			} else {
				jQuery.ajax({async:false,
							 type:"POST",
							 url:"' . RSS_FEEDER_URL . 'rss-feeder.php",
							 data:"ajax=external&ajaxaction=deactivate&nonce=' . $this->nonce . '&id="+jQuery(this).attr("id")
							 });
			}
		});
	})
	/* ]]> */
	</script>
	';
				}
	?>
		</div>
	</div><?php
			} else {
				if ( !class_exists( 'IslTemplate' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-templates.php' );
				$template = new IslTemplate();
				$template->files = RSS_FEEDER_PATH . 'includes/template-admin.php';
				$template->elements = $form;
				$template->output( true );
			}
		}

		/**
		 * Custom feeds menu
		 *
		 * @author Steven Raynham
		 * @since 0.5.1
		 *
		 * @param void
		 * @return null
		 */
		function customFeeds()
		{
			global $wpdb;
			$showList = true;
			if ( !class_exists( 'IslForm' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-forms.php' );
			$form = new IslForm();
			$form->session = 'rss-feeder';
			$form->setForm( array( 'action' => $this->cleanUrl( $_SERVER['REQUEST_URI'], array( 'page', 'redirect' ) ), 'method' => 'post' ) );
			if ( isset( $_REQUEST['nonce'] ) && ( $_REQUEST['nonce'] == $this->nonce ) ) {
				if ( isset( $_REQUEST['action'] ) ) {
					$showList = false;
					switch ( $_REQUEST['action'] ) {
						case 'new':
							$form->title = __( 'Create new custom RSS feed' );
							$form->addField( 'hidden', array( 'name' => 'action',
															  'forcedvalue' => $_REQUEST['action'] ) );
							$form->addField( 'hidden', array( 'name' => 'formaction',
															  'forcedvalue' => 'save' ) );
							$form->addField( 'hidden', array( 'name' => 'nonce',
															  'forcedvalue' => $this->nonce ) );
							$form->addField( 'checkbox', array( 'name' => 'rss_feeder[active]',
																'options' => array( __( 'Active in header' ) => 1 ) ) );
							$form->addField( 'text', array( 'name' => 'rss_feeder[title]',
															'label' => __( 'Title' ),
															'help' => array( 'content' => __( 'This will appear as the title of the feed.' ),
																			 'contentparameters' => array( 'style' => $this->helpStyle ) ),
															'html' => array( 'size' => 80 ),
															'validate' => array( 'type' => 'string',
																				 'required' => true,
																				 'length' => 255 ),
															'filter' => array( 'strip_tags' => '' ) ) );
							$form->addField( 'text', array( 'name' => 'rss_feeder[link]',
															'label' => __( 'Permalink' ),
															'help' => array( 'content' => __( 'This will be referenced by the %link% tag.' ),
																			 'contentparameters' => array( 'style' => $this->helpStyle ) ),
															'html' => array( 'size' => 80 ),
															'validate' => array( 'type' => 'string',
																				 'required' => true,
																				 'length' => 255 ),
															'filter' => array( 'strip_tags' => '',
																			   'str_replace' => array( ' ', '-' ),
																			   'urlencode' => '' ) ) );
							$form->addField( 'textarea', array( 'name' => 'rss_feeder[description]',
																'html' => array( 'cols' => '80',
																				 'rows' => '10' ),
																'label' => __( 'Description' ),
																'help' => array( 'content' => __( 'Appears in the head of your feed.' ),
																				 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																'validate' => array( 'type' => 'string',
																					 'required' => true ),
																'filter' => array( 'strip_tags' => '' ) ) );
							$form->addField( 'text', array( 'name' => 'rss_feeder[categories]',
															'label' => __( 'Categories<br/><small>(separate with comma)</small>' ),
															'help' => array( 'content' => __( 'Adds categories to your feed.' ),
																			 'contentparameters' => array( 'style' => $this->helpStyle ) ),
															'html' => array( 'size' => 80 ),
															'validate' => array( 'type' => 'string' ),
															'filter' => array( 'strip_tags' => '' )  ) );
							$form->addField( 'submit', array( 'name' => 'submit',
															  'forcedvalue' => __( 'Save' ),
															  'html' => array( 'class' => 'button-primary' ) ) );
							break;
						case 'setup':
							if ( isset( $_REQUEST['id'] ) ) $id = $_REQUEST['id'];
							elseif  ( isset( $_REQUEST['rss_feeder']['id'] ) ) $id = $_REQUEST['rss_feeder']['id'];
							$sql = "SELECT * FROM " . $wpdb->prefix . "rss_feeder_custom WHERE id='" . $id . "';";
							$result = $wpdb->get_row( $sql, ARRAY_A );
							if ( count( $result ) > 0 ) {
								$form->title = __( 'Custom RSS feed setup' );
								$form->addField( 'hidden', array( 'name' => 'action',
																  'forcedvalue' => $_REQUEST['action'] ) );
								$form->addField( 'hidden', array( 'name' => 'formaction',
																  'forcedvalue' => 'save' ) );
								$form->addField( 'hidden', array( 'name' => 'nonce',
																  'forcedvalue' => $this->nonce ) );
								$form->addField( 'hidden', array( 'name' => 'rss_feeder[id]',
																  'forcedvalue' => rssFeederDisplayField( $result['id'] ) ) );
								$form->addField( 'checkbox', array( 'name' => 'rss_feeder[active]',
																	'options' => array( __( 'Active in header' ) => 1 ),
																	'value' => rssFeederDisplayField( $result['active'] ) ) );
								$form->addField( 'text', array( 'name' => 'rss_feeder[title]',
																'label' => __( 'Title' ),
																'help' => array( 'content' => __( 'This will appear as the title of the feed.' ),
																				 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																'html' => array( 'size' => 80 ),
																'value' => rssFeederDisplayField( $result['title'] ),
																'validate' => array( 'type' => 'string',
																					 'required' => true,
																					 'length' => 255 ),
																'filter' => array( 'strip_tags' => '' ) ) );
								$form->addField( 'text', array( 'name' => 'rss_feeder[link]',
																'label' => __( 'Permalink' ),
																'help' => array( 'content' => __( 'This will be referenced by the %link% tag.' ),
																				 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																'html' => array( 'size' => 80 ),
																'value' => rssFeederDisplayField( $result['link'] ),
																'validate' => array( 'type' => 'string',
																					 'required' => true,
																					 'length' => 255 ),
																'filter' => array( 'strip_tags' => '',
																				   'str_replace' => array( ' ', '-' ),
																				   'urlencode' => '' ) ) );
								$form->addField( 'textarea', array( 'name' => 'rss_feeder[description]',
																	'label' => __( 'Description' ),
																	'help' => array( 'content' => __( 'Appears in the head of your feed.' ),
																					 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																	'html' => array( 'cols' => '80',
																					 'rows' => '10' ),
																	'value' => rssFeederDisplayField( $result['description'] ),
																	'validate' => array( 'type' => 'string',
																						 'required' => true ),
																	'filter' => array( 'strip_tags' => '' ) ) );
								$form->addField( 'text', array( 'name' => 'rss_feeder[categories]',
																'label' => __( 'Categories<br/><small>(separate with comma)</small>' ),
																'help' => array( 'content' => __( 'Adds categories to your feed.' ),
																				 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																'html' => array( 'size' => 80 ),
																'value' => rssFeederDisplayField( $result['categories'] ),
																'validate' => array( 'type' => 'string' ),
																'filter' => array( 'strip_tags' => '' ) ) );
								$form->addField( 'submit', array( 'name' => 'submit',
																  'forcedvalue' => __( 'Save' ),
																  'html' => array( 'class' => 'button-primary' ) ) );
							}
							break;
						case 'delete-selected':
							if ( isset( $_REQUEST['checked'] ) ) {
								foreach ( $_REQUEST['checked'] as $checked ) {
									$sql = "DELETE FROM " . $wpdb->prefix . "rss_feeder_custom WHERE id = '" . $checked . "';";
									$wpdb->query( $sql );
									$sql = "DELETE FROM " . $wpdb->prefix . "rss_feeder_custom_items WHERE feed_id = '" . $checked . "';";
									$wpdb->query( $sql );
								}
								$this->message = 'Feed deleted.';
							}
							$showList = true;
							break;
						case 'items':
							$showFeedList = $_REQUEST['id'];
							break;
						case 'newitem':
							if ( isset( $_REQUEST['id'] ) ) $id = $_REQUEST['id'];
							elseif  ( isset( $_REQUEST['rss_feeder']['feed_id'] ) ) $id = $_REQUEST['rss_feeder']['feed_id'];
							$sql = "SELECT title FROM " . $wpdb->prefix . "rss_feeder_custom WHERE id='" . $id . "';";
							if ( $title = $wpdb->get_var( $sql ) ) {
								$form->title = __( 'Create new item for ' ) . $title;
								$form->addField( 'hidden', array( 'name' => 'action',
																  'forcedvalue' => $_REQUEST['action'] ) );
								$form->addField( 'hidden', array( 'name' => 'formaction',
																  'forcedvalue' => 'saveitem' ) );
								$form->addField( 'hidden', array( 'name' => 'nonce',
																  'forcedvalue' => $this->nonce ) );
								$form->addField( 'hidden', array( 'name' => 'rss_feeder[feed_id]',
																  'forcedvalue' => $id ) );
								$form->addField( 'dateselect', array( 'name' => 'rss_feeder[pubdate]',
																	  'label' => __( 'Publish time-date' ),
																	  'help' => array( 'content' => __( 'Future dates will only appear when they are reached.' ),
																					   'contentparameters' => array( 'style' => $this->helpStyle ) ),
																	  'value' => date( 'Y-m-d H:i:s' ),
																	  'dateparameters' => array( 'displayorder' => '<HOUR>:<MINUTE>:<SECOND> - <DAY><MONTH><YEAR>',
																								 'output' => 'Y-m-d H:i:s',
																								 'showtime' => true ) ) );
								$form->addField( 'text', array( 'name' => 'rss_feeder[title]',
																'label' => __( 'Title' ),
																'help' => array( 'content' => __( 'Title of the item.' ),
																				 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																'html' => array( 'size' => 80 ),
																'validate' => array( 'type' => 'string',
																					 'required' => true,
																					 'length' => 255 ),
																'filter' => array( 'strip_tags' => '' ) ) );
								$form->addField( 'text', array( 'name' => 'rss_feeder[link]',
																'label' => __( 'Link' ),
																'help' => array( 'content' => __( 'Optional web address the item is associated with.' ),
																				 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																'html' => array( 'size' => 80 ),
																'validate' => array( 'type' => 'url',
																					 'length' => 255 ) ) );
								$form->addField( 'textarea', array( 'name' => 'rss_feeder[description]',
																	'label' => __( 'Description' ),
																	'help' => array( 'content' => __( 'Summary of the item.' ),
																					 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																	'html' => array( 'cols' => '80',
																					 'rows' => '10' ),
																	'validate' => array( 'type' => 'string',
																						 'length' => 255 ),
																	'filter' => array( 'strip_tags' => '' ) ) );
								$form->addField( 'textarea', array( 'name' => 'rss_feeder[content_encoded]',
																	'label' => __( 'Content' ),
																	'help' => array( 'content' => __( 'Optional content, this may contain HTML.' ),
																					 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																	'html' => array( 'cols' => '80',
																					 'rows' => '25' ),
																	'validate' => array( 'type' => 'string' ),
																	'htmlarea' => array( 'buttonlist' => $this->buttonList ) ) );
								$form->addField( 'text', array( 'name' => 'rss_feeder[categories]',
																'label' => __( 'Categories<br/><small>(separate with comma)</small>' ),
																'help' => array( 'content' => __( 'Adds categories to your item.' ),
																				 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																'html' => array( 'size' => 80 ),
																'validate' => array( 'type' => 'string' ),
																'filter' => array( 'strip_tags' => '' ) ) );
								$form->addField( 'submit', array( 'name' => 'submit',
																  'forcedvalue' => __( 'Save' ),
																  'html' => array( 'class' => 'button-primary' ) ) );
							}
							break;
						case 'edititem':
							if ( isset( $_REQUEST['id'] ) ) $id = $_REQUEST['id'];
							elseif  ( isset( $_REQUEST['rss_feeder']['id'] ) ) $id = $_REQUEST['rss_feeder']['id'];
							$sql = "SELECT * FROM " . $wpdb->prefix . "rss_feeder_custom_items WHERE id='" . $id . "';";
							$result = $wpdb->get_row( $sql, ARRAY_A );
							$sql = "SELECT title FROM " . $wpdb->prefix . "rss_feeder_custom WHERE id='" . $result['feed_id'] . "';";
							if ( $title = $wpdb->get_var( $sql ) ) {
								$form->title = __( 'Edit item for ' ) . $title;
								$form->addField( 'hidden', array( 'name' => 'action',
																  'forcedvalue' => $_REQUEST['action'] ) );
								$form->addField( 'hidden', array( 'name' => 'formaction',
																  'forcedvalue' => 'saveitem' ) );
								$form->addField( 'hidden', array( 'name' => 'nonce',
																  'forcedvalue' => $this->nonce ) );
								$form->addField( 'hidden', array( 'name' => 'rss_feeder[id]',
																  'forcedvalue' => $id ) );
								$form->addField( 'hidden', array( 'name' => 'rss_feeder[feed_id]',
																  'forcedvalue' => rssFeederDisplayField( $result['feed_id'] ) ) );
								$form->addField( 'dateselect', array( 'name' => 'rss_feeder[pubdate]',
																	  'label' => __( 'Publish time-date' ),
																	  'help' => array( 'content' => __( 'Future dates will only appear when they are reached.' ),
																					   'contentparameters' => array( 'style' => $this->helpStyle ) ),
																	  'value' => rssFeederDisplayField( $result['pubdate'] ),
																	  'dateparameters' => array( 'displayorder' => '<HOUR>:<MINUTE>:<SECOND> - <DAY><MONTH><YEAR>',
																								 'output' => 'Y-m-d H:i:s',
																								 'showtime' => true ) ) );
								$form->addField( 'text', array( 'name' => 'rss_feeder[title]',
																'label' => __( 'Title' ),
																'help' => array( 'content' => __( 'Title of the item.' ),
																				 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																'html' => array( 'size' => 80 ),
																'value' => rssFeederDisplayField( $result['title'] ),
																'validate' => array( 'type' => 'string',
																					 'required' => true,
																					 'length' => 255 ),
																'filter' => array( 'strip_tags' => '' ) ) );
								$form->addField( 'text', array( 'name' => 'rss_feeder[link]',
																'label' => __( 'Link' ),
																'help' => array( 'content' => __( 'Optional web address the item is associated with.' ),
																				 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																'html' => array( 'size' => 80 ),
																'value' => rssFeederDisplayField( $result['link'] ),
																'validate' => array( 'type' => 'url',
																					 'length' => 255 ) ) );
								$form->addField( 'textarea', array( 'name' => 'rss_feeder[description]',
																	'label' => __( 'Description' ),
																	'help' => array( 'content' => __( 'Summary of the item.' ),
																					 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																	'html' => array( 'cols' => '80',
																					 'rows' => '10' ),
																	'value' => rssFeederDisplayField( $result['description'] ),
																	'validate' => array( 'type' => 'string',
																						 'required' => true ),
																	'filter' => array( 'strip_tags' => '' ) ) );
								$form->addField( 'textarea', array( 'name' => 'rss_feeder[content_encoded]',
																	'label' => __( 'Content' ),
																	'help' => array( 'content' => __( 'Optional content, this may contain HTML.' ),
																					 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																	'html' => array( 'cols' => '80',
																					 'rows' => '25' ),
																	'value' => rssFeederDisplayField( $result['content_encoded'] ),
																	'validate' => array( 'type' => 'string' ),
																	'htmlarea' => array( 'buttonlist' => $this->buttonList ) ) );
								$form->addField( 'text', array( 'name' => 'rss_feeder[categories]',
																'label' => __( 'Categories<br/><small>(separate with comma)</small>' ),
																'help' => array( 'content' => __( 'Adds categories to your item.' ),
																				 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																'html' => array( 'size' => 80 ),
																'value' => rssFeederDisplayField( $result['categories'] ),
																'validate' => array( 'type' => 'string' ),
																'filter' => array( 'strip_tags' => '' ) ) );
								$form->addField( 'submit', array( 'name' => 'submit',
																  'forcedvalue' => __( 'Save' ),
																  'html' => array( 'class' => 'button-primary' ) ) );
							}
							break;
						case 'delete-selected-item':
							if ( isset( $_REQUEST['checked'] ) ) {
								foreach ( $_REQUEST['checked'] as $checked ) {
									$sql = "DELETE FROM " . $wpdb->prefix . "rss_feeder_custom_items WHERE id = '" . $checked . "';";
									$wpdb->query( $sql );
								}
								$this->message = 'Item deleted.';
							}
							$showFeedList = $_REQUEST['id'];
							break;
					}
					if ( count( $form->fields ) > 0 ) {
						if ( isset( $form->valid ) && $form->valid ) {
							if ( isset( $_REQUEST['formaction'] ) ) {
								switch ( $_REQUEST['formaction'] ) {
									case 'save':
										if ( isset( $_SESSION[$form->session]['rss_feeder'] ) ) {
											$sqlRssFeederQuery = '';
											foreach ( $_SESSION[$form->session]['rss_feeder'] as $field => $value ) {
												if ( $field != 'id' ) {
													if ( !empty( $sqlRssFeederQuery ) ) $sqlRssFeederQuery .= ',';
													$sqlRssFeederQuery .= $field . "='" . rssFeederDatabaseField( $value ) . "'";
												}
											}
										}
										if ( isset( $_SESSION[$form->session]['rss_feeder']['id'] ) ) {
											$sql = "SELECT id FROM " . $wpdb->prefix . "rss_feeder_custom WHERE id = '" . $_SESSION[$form->session]['rss_feeder']['id'] . "';";
											if ( $id = $wpdb->get_var( $sql  )) {
												$rssFeederCustomSql = "UPDATE " . $wpdb->prefix . "rss_feeder_custom " .
																	  "SET " . $sqlRssFeederQuery .
																	  "WHERE id='" . $id . "';";
												$this->message = 'Custom feed updated.';
											}
										} else {
											$rssFeederCustomSql = "INSERT INTO " . $wpdb->prefix . "rss_feeder_custom " .
																  "SET " . $sqlRssFeederQuery . ";";
											$this->message = 'New custom feed created.';
										}
										if ( isset( $rssFeederCustomSql ) ) {
											$showList = true;
											if ( $wpdb->query( $rssFeederCustomSql ) === false ) {
												$this->message = 'Database failed to post.';
											}
											if ( isset( $_REQUEST['redirect'] ) ) wp_redirect( 'admin.php?page=' . $_REQUEST['redirect'] );
										}
										break;
									case 'saveitem':
										if ( isset( $_REQUEST['rss_feeder']['pubdate'] ) )
											$pubDate = str_pad( $_REQUEST['rss_feeder']['pubdate']['year'], 4, '0', STR_PAD_LEFT ) . '-' .
													   str_pad( $_REQUEST['rss_feeder']['pubdate']['month'], 2, '0', STR_PAD_LEFT ) . '-' .
													   str_pad( $_REQUEST['rss_feeder']['pubdate']['day'], 2, '0', STR_PAD_LEFT ) . ' ' .
													   str_pad( $_REQUEST['rss_feeder']['pubdate']['hour'], 2, '0', STR_PAD_LEFT ) . ':' .
													   str_pad( $_REQUEST['rss_feeder']['pubdate']['minute'], 2, '0', STR_PAD_LEFT ) . ':' .
													   str_pad( $_REQUEST['rss_feeder']['pubdate']['second'], 2, '0', STR_PAD_LEFT );
										else
											$pubDate = date( 'Y-m-d H:i:s' );
										if ( isset( $_SESSION[$form->session]['rss_feeder'] ) ) {
											$sqlRssFeederQuery = '';
											foreach ( $_SESSION[$form->session]['rss_feeder'] as $field => $value ) {
												if ( ( $field != 'id' ) || ( $field != 'pubdate' ) ) {
													if ( !empty( $sqlRssFeederQuery ) ) $sqlRssFeederQuery .= ',';
													$sqlRssFeederQuery .= $field . "='" . rssFeederDatabaseField( $value ) . "'";
												}
											}
										}
										if ( isset( $_SESSION[$form->session]['rss_feeder']['id'] ) ) {
											$sql = "SELECT id FROM " . $wpdb->prefix . "rss_feeder_custom_items WHERE id = '" . $_SESSION[$form->session]['rss_feeder']['id'] . "';";
											if ( $id = $wpdb->get_var( $sql  )) {
												$rssFeederCustomSql = "UPDATE " . $wpdb->prefix . "rss_feeder_custom_items " .
																	  "SET " . $sqlRssFeederQuery . "," .
																		   "pubdate='" . $pubDate . "' " .
																	  "WHERE id='" . $id . "';";
												$this->message = 'Item updated.';
											}
										} else {
											$rssFeederCustomSql = "INSERT INTO " . $wpdb->prefix . "rss_feeder_custom_items " .
																  "SET " . $sqlRssFeederQuery . "," .
																	   "pubdate='" . $pubDate . "';";
											$this->message = 'Item added.';
										}
										if ( isset( $rssFeederCustomSql ) ) {
											$showFeedList = $_SESSION[$form->session]['rss_feeder']['feed_id'];
											if ( $wpdb->query( $rssFeederCustomSql ) === false ) {
												$this->message = 'Database failed to post.';
											}
										}
										break;
								}
							}
						}
					} else {
						$showList = true;
					}
				}
			}
			if ( $showList ) {
	?><div class='wrap'>
		<h2><?php _e( 'Custom Feeds' ); ?></h2>
		<?php if ( !empty( $this->message ) ) { ?><div id="message" class="updated fade"><p><strong><?php _e( $this->message ); ?></strong></p></div><?php } ?>
		<p>Custom feeds are hosted on your blog and can contain any information you wish, including imported feeds.</p>
		<hr/>
		<div><?php
				$form->clearFields();
				unset( $_REQUEST['rss_feeder'] );
				echo '<button id="rss_feeder_quick_add_new" class="button">' . __( 'New feed' ) . '</button>';
				echo '<div id="rss_feeder_quick_add">';
				echo '<button id="rss_feeder_quick_add_cancel" class="button">' . __( 'Cancel' ) . '</button>';
				$form->addField( 'hidden', array( 'name' => 'action',
												  'forcedvalue' => 'new' ) );
				$form->addField( 'hidden', array( 'name' => 'formaction',
												  'forcedvalue' => 'save' ) );
				$form->addField( 'hidden', array( 'name' => 'nonce',
												  'forcedvalue' => $this->nonce ) );
				$form->addField( 'checkbox', array( 'name' => 'rss_feeder[active]',
													'options' => array( __( 'Active in header' ) => 1 ) ) );
				$form->addField( 'text', array( 'name' => 'rss_feeder[title]',
												'label' => __( 'Title' ),
												'help' => array( 'content' => __( 'This will appear as the title of the feed.' ),
																 'contentparameters' => array( 'style' => $this->helpStyle ) ),
												'html' => array( 'size' => 80 ),
												'validate' => array( 'type' => 'string',
																	 'required' => true,
																	 'length' => 255 ) ) );
				$form->addField( 'text', array( 'name' => 'rss_feeder[link]',
												'label' => __( 'Permalink' ),
												'help' => array( 'content' => __( 'This will be referenced by the %link% tag.' ),
																 'contentparameters' => array( 'style' => $this->helpStyle ) ),
												'html' => array( 'size' => 80 ),
												'validate' => array( 'type' => 'string',
																	 'required' => true,
																	 'length' => 255 ),
												'filter' => array( 'strip_tags' => '',
																   'str_replace' => array( ' ', '-' ),
																   'urlencode' => '' ) ) );
				$form->addField( 'textarea', array( 'name' => 'rss_feeder[description]',
													'label' => __( 'Description' ),
													'help' => array( 'content' => __( 'Appears in the head of your feed.' ),
																	 'contentparameters' => array( 'style' => $this->helpStyle ) ),
													'html' => array( 'cols' => '80',
																	 'rows' => '10' ),
													'validate' => array( 'type' => 'string',
																		 'required' => true ),
													'filter' => array( 'strip_tags' => '' ) ) );
				$form->addField( 'text', array( 'name' => 'rss_feeder[categories]',
												'label' => __( 'Categories<br/><small>(separate with comma)</small>' ),
												'help' => array( 'content' => __( 'Adds categories to your feed.' ),
																 'contentparameters' => array( 'style' => $this->helpStyle ) ),
												'html' => array( 'size' => 80 ),
												'validate' => array( 'type' => 'string' ) ) );
				$form->addField( 'submit', array( 'name' => 'submit',
												  'forcedvalue' => __( 'Save' ),
												  'html' => array( 'class' => 'button-primary' ) ) );
				if ( !class_exists( 'IslTemplate' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-templates.php' );
				$template = new IslTemplate();
				$template->files = RSS_FEEDER_PATH . 'includes/template-admin.php';
				$template->elements = $form;
				$template->output( true );
				echo '</div>';
				echo '<script type="text/javascript">
	/* <![CDATA[ */
	jQuery(document).ready(function(){
		jQuery("#rss_feeder_quick_add").hide();
		jQuery("#rss_feeder_quick_add_new").click(function(){
			jQuery("#rss_feeder_quick_add_new").hide("slow");
			jQuery("#rss_feeder_table").hide("slow");
			jQuery("#rss_feeder_quick_add").show("slow");
		});
		jQuery("#rss_feeder_quick_add_cancel").click(function(){
			jQuery("#rss_feeder_quick_add").hide("slow");
			jQuery("#rss_feeder_table").show("slow");
			jQuery("#rss_feeder_quick_add_new").show("slow");
		});
	})
	/* ]]> */
	</script>
	';
				$sql = "SELECT * FROM " . $wpdb->prefix . "rss_feeder_custom;";
				$results = $wpdb->get_results( $sql, ARRAY_A );
				if ( count( $results ) > 0 ) {
					if ( !class_exists( 'WpAdminTable' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-wp-admin-table.php' );
					$wpAdminTable = new WpAdminTable;
					$wpAdminTable->nonce = array( 'rss-feeder', 'nonce' );
					$wpAdminTable->name = 'custom-feeds';
					$wpAdminTable->headings = array( __( 'ID' ),
													 __( 'Active in header' ),
													 __( 'Title' ),
													 __( 'Description' ),
													 __( 'Links' ) );
					$options = get_option( 'rss_feeder' );
					foreach ( $results as $result ) {
						$wpAdminTable->data[$result['id']] = array( $result['id'],
																	'<input type="checkbox" id="' . $result['id'] . '" class="rss_feeder_active" value="1"' . ( ( $result['active'] == 1 ) ? ' checked="checked"' : '' ) . '/>',
																	'<a href="admin.php?page=' . $_GET['page'] . '&amp;nonce=' . $this->nonce . '&amp;action=setup&amp;id=' . urlencode( $result['id'] ) . '">' . rssFeederDisplayField( $result['title'] ) . '</a>',
																	rssFeederDisplayField( $result['description'] ),
																	'<small><strong>' . __( 'Feed' ) . ':</strong> ' . $this->getFeedPermalink( stripslashes( $result['link'] ) ) . '<br/>' .
																	'<strong>' . __( 'Content tag' ) . ':</strong> &lt;!--rss-feeder:template:' . $result['id'] . '--&gt;</small>' );
						$wpAdminTable->dataActions[$result['id']] = array( '<a href="admin.php?page=' . $_GET['page'] . '&amp;nonce=' . $this->nonce . '&amp;action=setup&amp;id=' . urlencode( $result['id'] ) . '">' . __( 'Setup' ) . '</a>',
																		   '<a href="admin.php?page=' . $_GET['page'] . '&amp;nonce=' . $this->nonce . '&amp;action=items&amp;id=' . urlencode( $result['id'] ) . '">' . __( 'Items' ) . '</a>' );
					}
					$wpAdminTable->bulkActions = array( __( 'Delete' ) => 'delete-selected' );
					echo '<div id="rss_feeder_table">';
					$wpAdminTable->output( true );
					echo '</div>';
					echo '<script type="text/javascript">
	/* <![CDATA[ */
	jQuery(document).ready(function(){
		jQuery("#doaction_custom-feeds").click(function(){
			var answer = confirm("' . __( 'Are you sure you want to delete the selected feeds?' ) . '");
			return answer;
		});
		jQuery(".rss_feeder_active").click(function(){
			if (jQuery(this).is(":checked")){
				jQuery.ajax({async:false,
							 type:"POST",
							 url:"' . RSS_FEEDER_URL . 'rss-feeder.php",
							 data:"ajax=custom&ajaxaction=activate&nonce=' . $this->nonce . '&id="+jQuery(this).attr("id")
							 });
			} else {
				jQuery.ajax({async:false,
							 type:"POST",
							 url:"' . RSS_FEEDER_URL . 'rss-feeder.php",
							 data:"ajax=custom&ajaxaction=deactivate&nonce=' . $this->nonce . '&id="+jQuery(this).attr("id")
							 });
			}
		});
	})
	/* ]]> */
	</script>
	';
				}
	?>
		</div>
	</div><?php
			} elseif ( is_numeric( $showFeedList ) ) {
				$sql = "SELECT title FROM " . $wpdb->prefix . "rss_feeder_custom WHERE id='" . $showFeedList . "';";
				if ( $title = $wpdb->get_var( $sql ) ) {
	?><div class='wrap'>
		<h2><?php _e( 'Items for ' . $title ); ?></h2>
		<?php if ( !empty( $this->message ) ) { ?><div id="message" class="updated fade"><p><strong><?php _e( $this->message ); ?></strong></p></div><?php } ?>
		<hr/>
		<div><?php
				$form->clearFields();
				unset( $_REQUEST['rss_feeder'] );
				echo '<button id="rss_feeder_quick_add_new" class="button">' . __( 'New item' ) . '</button>';
				echo '<div id="rss_feeder_quick_add">';
				echo '<button id="rss_feeder_quick_add_cancel" class="button">' . __( 'Cancel' ) . '</button>';
				$form->addField( 'hidden', array( 'name' => 'action',
												  'forcedvalue' => 'newitem' ) );
				$form->addField( 'hidden', array( 'name' => 'formaction',
												  'forcedvalue' => 'saveitem' ) );
				$form->addField( 'hidden', array( 'name' => 'nonce',
												  'forcedvalue' => $this->nonce ) );
				$form->addField( 'hidden', array( 'name' => 'rss_feeder[feed_id]',
												  'forcedvalue' => $showFeedList ) );
				$form->addField( 'dateselect', array( 'name' => 'rss_feeder[pubdate]',
													  'label' => __( 'Publish time-date' ),
													  'help' => array( 'content' => __( 'Future dates will only appear when they are reached.' ),
																	   'contentparameters' => array( 'style' => $this->helpStyle ) ),
													  'value' => date( 'Y-m-d H:i:s' ),
													  'dateparameters' => array( 'displayorder' => '<HOUR>:<MINUTE>:<SECOND> - <DAY><MONTH><YEAR>',
																				 'output' => 'Y-m-d H:i:s',
																				 'showtime' => true ) ) );
				$form->addField( 'text', array( 'name' => 'rss_feeder[title]',
												'label' => __( 'Title' ),
												'help' => array( 'content' => __( 'Title of the item.' ),
																 'contentparameters' => array( 'style' => $this->helpStyle ) ),
												'html' => array( 'size' => 80 ),
												'validate' => array( 'type' => 'string',
																	 'required' => true,
																	 'length' => 255 ),
												'filter' => array( 'strip_tags' => '' ) ) );
				$form->addField( 'text', array( 'name' => 'rss_feeder[link]',
												'label' => __( 'Link' ),
												'help' => array( 'content' => __( 'Optional web address the item is associated with.' ),
																 'contentparameters' => array( 'style' => $this->helpStyle ) ),
												'html' => array( 'size' => 80 ),
												'validate' => array( 'type' => 'url',
																	 'length' => 255 ) ) );
				$form->addField( 'textarea', array( 'name' => 'rss_feeder[description]',
													'label' => __( 'Description' ),
													'help' => array( 'content' => __( 'Summary of the item.' ),
																	 'contentparameters' => array( 'style' => $this->helpStyle ) ),
													'html' => array( 'cols' => '80',
																	 'rows' => '10' ),
													'validate' => array( 'type' => 'string',
																		 'required' => true ),
													'filter' => array( 'strip_tags' => '' ) ) );
				$form->addField( 'textarea', array( 'name' => 'rss_feeder[content_encoded]',
													'label' => __( 'Content' ),
													'help' => array( 'content' => __( 'Optional content, this may contain HTML.' ),
																	 'contentparameters' => array( 'style' => $this->helpStyle ) ),
													'html' => array( 'cols' => '80',
																	 'rows' => '25' ),
													'validate' => array( 'type' => 'string' ),
													'htmlarea' => array( 'buttonlist' => $this->buttonList ) ) );
				$form->addField( 'text', array( 'name' => 'rss_feeder[categories]',
												'label' => __( 'Categories<br/><small>(separate with comma)</small>' ),
												'help' => array( 'content' => __( 'Adds categories to your item.' ),
																 'contentparameters' => array( 'style' => $this->helpStyle ) ),
												'html' => array( 'size' => 80 ),
												'validate' => array( 'type' => 'string' ),
												'filter' => array( 'strip_tags' => '' ) ) );
				$form->addField( 'submit', array( 'name' => 'submit',
												  'forcedvalue' => __( 'Add new item' ),
												  'html' => array( 'class' => 'button-primary' ) ) );
				if ( !class_exists( 'IslTemplate' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-templates.php' );
				$template = new IslTemplate();
				$template->files = RSS_FEEDER_PATH . 'includes/template-admin.php';
				$template->elements = $form;
				$template->output( true );
				echo '</div>';
				echo '<script type="text/javascript">
	/* <![CDATA[ */
	jQuery(document).ready(function(){
		jQuery("#rss_feeder_quick_add").hide();
		jQuery("#rss_feeder_quick_add_new").click(function(){
			jQuery("#rss_feeder_quick_add_new").hide("slow");
			jQuery("#rss_feeder_item_table").hide("slow");
			jQuery("#rss_feeder_quick_add").show("slow");
		});
		jQuery("#rss_feeder_quick_add_cancel").click(function(){
			jQuery("#rss_feeder_quick_add").hide("slow");
			jQuery("#rss_feeder_item_table").show("slow");
			jQuery("#rss_feeder_quick_add_new").show("slow");
		});
	})
	/* ]]> */
	</script>
	';
				$sql = "SELECT * FROM " . $wpdb->prefix . "rss_feeder_custom_items WHERE feed_id='" . $showFeedList . "' ORDER BY pubdate DESC;";
				$results = $wpdb->get_results( $sql, ARRAY_A );
				if ( count( $results ) > 0 ) {
					if ( !class_exists( 'WpAdminTable' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-wp-admin-table.php' );
					$wpAdminTable = new WpAdminTable;
					$wpAdminTable->nonce = array( 'rss-feeder', 'nonce' );
					$wpAdminTable->name = 'custom-feeds';
					$wpAdminTable->headings = array( __( 'Published' ),
													 __( 'Title' ),
													 __( 'Description' ),
													 __( 'Links' ) );
					foreach ( $results as $result ) {
						$wpAdminTable->data[$result['id']] = array( $wpAdminTable->dateTimeFormat( $result['pubdate'] ),
																	'<a href="admin.php?page=' . $_GET['page'] . '&amp;nonce=' . $this->nonce . '&amp;action=edititem&amp;id=' . urlencode( $result['id'] ) . '">' . rssFeederDisplayField( $result['title'] ) . '</a>',
																	rssFeederDisplayField( $result['description'] ),
																	'<small><strong>' . __( 'Content tag' ) . ':</strong> &lt;!--rss-feeder:template:' . $showFeedList . ':' . $result['id'] . '--&gt;</small>' );
						$wpAdminTable->dataActions[$result['id']] = array( '<a href="admin.php?page=' . $_GET['page'] . '&amp;nonce=' . $this->nonce . '&amp;action=edititem&amp;id=' . urlencode( $result['id'] ) . '">' . __( 'Edit' ) . '</a>' );
					}
					$wpAdminTable->bulkActions = array( __( 'Delete' ) => 'delete-selected-item' );
					echo '<div id="rss_feeder_item_table">';
					$wpAdminTable->output( true );
					echo '</div>';
					echo '<script type="text/javascript">
	/* <![CDATA[ */
	jQuery(document).ready(function(){
		jQuery("#doaction_custom-feeds").click(function(){
			var answer = confirm("' . __( 'Are you sure you want to delete the selected items?' ) . '");
			return answer;
		});
	})
	/* ]]> */
	</script>
	';
				}
	?>
		</div>
	</div><?php
				}
			} else {
				if ( !class_exists( 'IslTemplate' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-templates.php' );
				$template = new IslTemplate();
				$template->files = RSS_FEEDER_PATH . 'includes/template-admin.php';
				$template->elements = $form;
				$template->output( true );
			}
		}

		/**
		 * Import feeds menu
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param void
		 * @return null
		 */
		function importFeeds()
		{
			global $wpdb;
			$this->nonce = wp_create_nonce( 'rss-feeder' );
			$showList = true;
			$fieldOptionsArray = array( 'any' => __( 'Any' ),
										'title' => __( 'Title' ),
										'description' => __( 'Description' ),
										'content' => __( 'Content' ),
										'category' => __( 'Category' ) );
			$jsOptionsText = '';
			foreach ( $fieldOptionsArray as $field => $label ) {
				$jsOptionsText .= '"<option value=\"' . $field . '\">' . $label . '</option>"+' . "\r\n";
			}
			$sql = "SELECT t.name as name, tt.term_taxonomy_id as post_taxonomy_id FROM " . $wpdb->prefix . "terms t LEFT JOIN " . $wpdb->prefix . "term_taxonomy tt ON t.term_id=tt.term_id WHERE tt.taxonomy='category';";
			$results = $wpdb->get_results( $sql, ARRAY_A );
			if ( count( $results ) > 0 ) {
				foreach ( $results as $result ) {
					$postCategoriesArray[$result['name']] = $result['post_taxonomy_id'];
				}
			}
			if ( !class_exists( 'IslForm' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-forms.php' );
			$form = new IslForm();
			$form->session = 'rss-feeder';
			$form->setForm( array( 'action' => $this->cleanUrl( $_SERVER['REQUEST_URI'], array( 'page', 'redirect' ) ), 'method' => 'post' ) );
			$sql = "SELECT id, title FROM " . $wpdb->prefix . "rss_feeder_custom;";
			$results = $wpdb->get_results( $sql, ARRAY_A );
			$customFeedsArray[__( 'New custom feed...' )] = 'new';
			if ( count( $results ) > 0 ) {
				foreach ( $results as $result ) {
					$customFeedsArray[$result['title'] . ' (' . $result['id'] . ')'] = $result['id'];
				}
			}
			if ( isset( $_REQUEST['nonce'] ) && ( $_REQUEST['nonce'] == $this->nonce ) ) {
				if ( isset( $_REQUEST['action'] ) ) {
					$showList = false;
					switch ( $_REQUEST['action'] ) {
						case 'new':
							$form->title = __( 'Create new import feed' );
							$form->addField( 'hidden', array( 'name' => 'action',
															  'forcedvalue' => $_REQUEST['action'] ) );
							$form->addField( 'hidden', array( 'name' => 'formaction',
															  'forcedvalue' => 'save' ) );
							$form->addField( 'hidden', array( 'name' => 'nonce',
															  'forcedvalue' => $this->nonce ) );
							$form->addField( 'select', array( 'name' => 'rss_feeder[feed_id]',
															  'label' => __( 'Select custom feed' ),
															  'help' => array( 'content' => __( 'Select the custom feed you wish to import to, or create a new one.' ),
																			   'contentparameters' => array( 'style' => $this->helpStyle ) ),
															  'options' => $customFeedsArray,
															  'validate' => array( 'type' => 'string',
																				   'length' => 255 ) ) );
							$form->addField( 'text', array( 'name' => 'rss_feeder[url]',
															'label' => __( 'Feed URL' ),
															'help' => array( 'content' => __( 'The web address of the feed you wish to import.' ),
																			 'contentparameters' => array( 'style' => $this->helpStyle ) ),
															'html' => array( 'size' => 80 ),
															'validate' => array( 'type' => 'string',
																				 'required' => true,
																				 'length' => 255 ) ) );
							$form->addField( 'content', array( 'name' => 'plain',
															   'content' => '<tr><td colspan="2"><hr style="border:1px solid #AAAAAA;margin:0px;padding:0px;line-height:1px;"/></td></tr>' ) );
							$form->addField( 'checkbox', array( 'name' => 'rss_feeder[post_active]',
																'options' => array( __( 'Import into posts' ) => 1 ) ) );
							$form->addField( 'content', array( 'name' => 'container-open-posts-active',
															   'content' => '' ) );
							$form->addField( 'checkbox', array( 'name' => 'rss_feeder[post_publish]',
																'options' => array( __( 'Publish immediately' ) => 1 ) ) );
							$form->addField( 'text', array( 'name' => 'rss_feeder[post_excerpt]',
															'label' => __( 'Extracted excerpt length<br/><small>(leave as 0 to disable)</small>' ),
															'help' => array( 'content' => __( 'Excerpts are automatically created from the description tag when there is a content:encoded tag.<br/>Here you can force the creation of an excerpt from the description if no content:encoded tag exists.' ),
																			 'contentparameters' => array( 'style' => $this->helpStyle ) ),
															'html' => array( 'size' => 10 ),
															'validate' => array( 'type' => 'integer' ) ) );
							$form->addField( 'select', array( 'name' => 'rss_feeder[post_taxonomy_id]',
															  'label' => __( 'Post category' ),
															  'help' => array( 'content' => __( 'Select the category you wish to assign to the imported post.' ),
																			   'contentparameters' => array( 'style' => $this->helpStyle ) ),
															  'options' => $postCategoriesArray,
															  'validate' => array( 'type' => 'integer' ) ) );
							$form->addField( 'text', array( 'name' => 'rss_feeder[more]',
															'label' => __( 'Insert more tag<br/><small>(leave as 0 to disable)</small>' ),
															'help' => array( 'content' => __( 'Automatically adds the &lt;!--more--&gt; tag at approximately this position in the content, it actually positions it in the next space in the content after this position.' ),
																			 'contentparameters' => array( 'style' => $this->helpStyle ) ),
															'html' => array( 'size' => 10 ),
															'validate' => array( 'type' => 'integer' ) ) );
							$form->addField( 'content', array( 'name' => 'container-close-posts-active',
															   'content' => '' ) );

							$form->addField( 'content', array( 'name' => 'plain',
															   'content' => '<tr><td colspan="2"><hr style="border:1px solid #AAAAAA;margin:0px;padding:0px;line-height:1px;"/></td></tr>' ) );
							$form->addField( 'content', array( 'name' => 'plain',
															   'content' => '<tr valign="top" id="rss_feeder_search"><th scope="row" colspan="2"><button id="rss_feeder_add_search" class="button">' . __(  'Add search filter' ) . '</button></th></tr>' ) );
							$form->addField( 'content', array( 'name' => 'plain',
															   'content' => '<tr><td colspan="2"><hr style="border:1px solid #AAAAAA;margin:0px;padding:0px;line-height:1px;"/></td></tr>' ) );
							$form->addField( 'content', array( 'name' => 'plain',
															   'content' => '<tr valign="top" id="rss_feeder_replace"><th scope="row" colspan="2"><button id="rss_feeder_add_replace" class="button">' . __( 'Add replace filter' ) . '</button></th></tr>' ) );
							$form->addField( 'submit', array( 'name' => 'submit',
															  'forcedvalue' => __( 'Save' ),
															  'html' => array( 'class' => 'button-primary' ) ) );
							break;
						case 'setup':
							if ( isset( $_REQUEST['id'] ) ) $id = $_REQUEST['id'];
							elseif  ( isset( $_REQUEST['rss_feeder']['id'] ) ) $id = $_REQUEST['rss_feeder']['id'];
							$sql = "SELECT * FROM " . $wpdb->prefix . "rss_feeder_import WHERE id='" . $id . "';";
							$result = $wpdb->get_row( $sql, ARRAY_A );
							if ( count( $result ) > 0 ) {
								$form->title = __( 'Edit import feed' );
								$form->addField( 'hidden', array( 'name' => 'action',
																  'forcedvalue' => $_REQUEST['action'] ) );
								$form->addField( 'hidden', array( 'name' => 'formaction',
																  'forcedvalue' => 'save' ) );
								$form->addField( 'hidden', array( 'name' => 'nonce',
																  'forcedvalue' => $this->nonce ) );
								$form->addField( 'hidden', array( 'name' => 'rss_feeder[id]',
																  'forcedvalue' => rssFeederDisplayField( $result['id'] ) ) );
								$form->addField( 'select', array( 'name' => 'rss_feeder[feed_id]',
																  'label' => __( 'Select custom feed' ),
																  'help' => array( 'content' => __( 'Select the custom feed you wish to import to, or create a new one.' ),
																				   'contentparameters' => array( 'style' => $this->helpStyle ) ),
																  'value' => rssFeederDisplayField( $result['feed_id'] ),
																  'options' => $customFeedsArray,
																  'validate' => array( 'type' => 'string',
																					   'length' => 255 ) ) );
								$form->addField( 'text', array( 'name' => 'rss_feeder[url]',
																'label' => __( 'Feed URL' ),
																'help' => array( 'content' => __( 'The web address of the feed you wish to import.' ),
																				 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																'html' => array( 'size' => 80 ),
																'value' => rssFeederDisplayField( $result['url'] ),
																'validate' => array( 'type' => 'string',
																					 'required' => true,
																					 'length' => 255 ) ) );
								$form->addField( 'content', array( 'name' => 'plain',
																   'content' => '<tr><td colspan="2"><hr style="border:1px solid #AAAAAA;margin:0px;padding:0px;line-height:1px;"/></td></tr>' ) );
								$form->addField( 'checkbox', array( 'name' => 'rss_feeder[post_active]',
																	'value' => rssFeederDisplayField( $result['post_active'] ),
																	'options' => array( __( 'Import into posts' ) => 1 ) ) );
								$form->addField( 'content', array( 'name' => 'container-open-posts-active',
																   'content' => '' ) );
								$form->addField( 'checkbox', array( 'name' => 'rss_feeder[post_publish]',
																	'value' => rssFeederDisplayField( $result['post_publish'] ),
																	'options' => array( __( 'Publish immediately' ) => 1 ) ) );
								$form->addField( 'text', array( 'name' => 'rss_feeder[post_excerpt]',
																'label' => __( 'Extracted excerpt length<br/><small>(leave as 0 to disable)</small>' ),
																'value' => rssFeederDisplayField( $result['post_excerpt'] ),
																'help' => array( 'content' => __( 'Excerpts are automatically created from the description tag when there is a content:encoded tag.<br/>Here you can force the creation of an excerpt from the description if no content:encoded tag exists.' ),
																				 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																'html' => array( 'size' => 10 ),
																'validate' => array( 'type' => 'integer' ) ) );
								$form->addField( 'select', array( 'name' => 'rss_feeder[post_taxonomy_id]',
																  'label' => __( 'Post category' ),
																  'value' => rssFeederDisplayField( $result['post_taxonomy_id'] ),
																  'help' => array( 'content' => __( 'Select the category you wish to assign to the imported post.' ),
																				   'contentparameters' => array( 'style' => $this->helpStyle ) ),
																  'options' => $postCategoriesArray,
																  'validate' => array( 'type' => 'integer' ) ) );
								$form->addField( 'text', array( 'name' => 'rss_feeder[more]',
																'label' => __( 'Insert more tag<br/><small>(leave as 0 to disable)</small>' ),
																'value' => rssFeederDisplayField( $result['more'] ),
																'help' => array( 'content' => __( 'Automatically adds the &lt;!--more--&gt; tag at approximately this position in the content, it actually positions it in the next space in the content after this position.' ),
																				 'contentparameters' => array( 'style' => $this->helpStyle ) ),
																'html' => array( 'size' => 10 ),
																'validate' => array( 'type' => 'integer' ) ) );
								$form->addField( 'content', array( 'name' => 'container-close-posts-active',
																   'content' => '' ) );

								$form->addField( 'content', array( 'name' => 'plain',
																   'content' => '<tr><td colspan="2"><hr style="border:1px solid #AAAAAA;margin:0px;padding:0px;line-height:1px;"/></td></tr>' ) );
								if ( !empty( $result['expr_search'] ) ) {
									$form->addField( 'content', array( 'name' => 'plain',
																	   'content' => '<tr valign="top" id="rss_feeder_search_head"><th scope="row">' . __( 'Search Field' ) . '</th><td>' . __( 'Search Expression' ) . '</td></tr>' ) );
									$addSearch = 'true';
									$searchArray = maybe_unserialize( stripslashes( $result['expr_search'] ) );
									foreach ( $searchArray as $searchElement ) {
										$content = '<tr valign="top"><th scope="row"><select name="rss_feeder[search][field][]">';
										foreach ( $fieldOptionsArray as $value => $label ) {
											$content .= '<option value="' . $value . '"' . ( ( $value == $searchElement[0] ) ? ' selected="selected"' : '' ) . '>' . $label . '</option>';
										}
										$content .= '</select></th><td><input type="text" name="rss_feeder[search][expression][]" value="' . $searchElement[1] . '"/></td></tr>';
										$form->addField( 'content', array( 'name' => 'plain',
																		   'content' => $content ) );
									}
								} else
									$addSearch = 'false';
								$form->addField( 'content', array( 'name' => 'plain',
																   'content' => '<tr valign="top" id="rss_feeder_search"><th scope="row" colspan="2"><button id="rss_feeder_add_search" class="button">' . __( 'Add search filter' ) . '</button></th></tr>' ) );
								$form->addField( 'content', array( 'name' => 'plain',
																   'content' => '<tr><td colspan="2"><hr style="border:1px solid #AAAAAA;margin:0px;padding:0px;line-height:1px;"/></td></tr>' ) );
								if ( !empty( $result['expr_replace'] ) ) {
									$form->addField( 'content', array( 'name' => 'plain',
																	   'content' => '<tr valign="top" id="rss_feeder_replace_head"><th scope="row">' . __( 'Search Field' ) . '</th><td>' . __( 'Search Expression -&gt; Replace Expression' ) . '</td></tr>' ) );
									$addReplace = 'true';
									$replaceArray = maybe_unserialize( stripslashes( $result['expr_replace'] ) );
									foreach ( $replaceArray as $replaceElement ) {
										$content = '<tr valign="top"><th scope="row"><select name="rss_feeder[replace][field][]">';
										foreach ( $fieldOptionsArray as $value => $label ) {
											$content .= '<option value="' . $value . '"' . ( ( $value == $replaceElement[0] ) ? ' selected="selected"' : '' ) . '>' . $label . '</option>';
										}
										$content .= '</select></th><td><input type="text" name="rss_feeder[replace][search][]" value="' . $replaceElement[1] . '"/> -&gt; <input type="text" name="rss_feeder[replace][replace][]" value="' . $replaceElement[2] . '"/></td></tr>';
										$form->addField( 'content', array( 'name' => 'plain',
																		   'content' => $content ) );
									}
								} else
									$addReplace = 'false';
								$form->addField( 'content', array( 'name' => 'plain',
																   'content' => '<tr valign="top" id="rss_feeder_replace"><th scope="row" colspan="2"><button id="rss_feeder_add_replace" class="button">' . __( 'Add replace filter' ) . '</button></th></tr>' ) );
								$form->addField( 'submit', array( 'name' => 'submit',
																  'forcedvalue' => __( 'Update' ),
																  'html' => array( 'class' => 'button-primary' ) ) );
							}
							break;
						case 'import':
							$this->message = 'Feed failed to be imported.';
							if ( isset( $_REQUEST['id'] ) ) {
								if ( rssFeederImportRssFeed( $_REQUEST['id'] ) ) $this->message = 'Feed imported successfully.';
								$sql = "SELECT id, title FROM " . $wpdb->prefix . "rss_feeder_custom;";
								$results = $wpdb->get_results( $sql, ARRAY_A );
								$customFeedsArray[__( 'New custom feed...' )] = 'new';
								if ( count( $results ) > 0 ) {
									foreach ( $results as $result ) {
										$customFeedsArray[$result['title'] . ' (' . $result['id'] . ')'] = $result['id'];
									}
								}
							}
							$showList = true;
							break;
						case 'delete-selected':
							if ( isset( $_REQUEST['checked'] ) ) {
								foreach ( $_REQUEST['checked'] as $checked ) {
									$sql = "DELETE FROM " . $wpdb->prefix . "rss_feeder_import WHERE id = '" . $checked . "';";
									$wpdb->query( $sql );
								}
								$this->message = 'Feed deleted';
							}
							$showList = true;
							break;
					}
					if ( count( $form->fields ) > 0 ) {
						if ( isset( $form->valid ) && $form->valid ) {
							if ( isset( $_REQUEST['formaction'] ) ) {
								switch ( $_REQUEST['formaction'] ) {
									case 'save':
										if ($_SESSION[$form->session]['rss_feeder']['feed_id'] == 'new' ) {
											$rssFeederSql = "INSERT INTO " . $wpdb->prefix . "rss_feeder_custom " .
															"SET title='" . __( 'Unset import feed' ) . "';";
											if ( $wpdb->query( $rssFeederSql ) !== false ) {
												$feedId = mysql_insert_id();
												$rssFeederSql = "UPDATE " . $wpdb->prefix . "rss_feeder_custom " .
																"SET title='" . __( 'Unnamed import feed' ) . " " . $feedId . "'," .
																	"link='" . __( 'import-feed' ) . "-" . $feedId . "' " .
																"WHERE id='" . $feedId . "';";
												$wpdb->query( $rssFeederSql );
											}
											$customFeedsArray[__( 'Unnamed import feed ' ) . $feedId] = $feedId;
											unset( $rssFeederSql );
										} else {
											$feedId = $_SESSION[$form->session]['rss_feeder']['feed_id'];
										}
										if ( isset( $feedId ) ) {
											if ( isset( $_REQUEST['rss_feeder']['search'] ) ) {
												foreach ( $_REQUEST['rss_feeder']['search']['field'] as $key => $field ) {
													$expression = trim( $_REQUEST['rss_feeder']['search']['expression'][$key] );
													if ( !empty( $expression ) )
														$search[] = array( $field, rssFeederDatabaseField( $expression ) );
												}
											}
											if ( !is_array( $search ) ) $search = '';

											if ( isset( $_REQUEST['rss_feeder']['replace'] ) ) {
												foreach ( $_REQUEST['rss_feeder']['replace']['field'] as $key => $field ) {
													$expression = trim( $_REQUEST['rss_feeder']['replace']['search'][$key] );
													$expressionReplace = trim( $_REQUEST['rss_feeder']['replace']['replace'][$key] );
													if ( !empty( $expression ) )
														$replace[] = array( $field, rssFeederDatabaseField( $expression ), rssFeederDatabaseField( $expressionReplace ) );
												}
											}
											if ( !is_array( $replace ) ) $replace = '';

											if ( isset( $_SESSION[$form->session]['rss_feeder']['id'] ) ) {
												if ( !isset( $_REQUEST['rss_feeder']['post_active'] ) ) $_SESSION[$form->session]['rss_feeder']['post_active'] = 0;
												if ( !isset( $_REQUEST['rss_feeder']['post_publish'] ) ) $_SESSION[$form->session]['rss_feeder']['post_publish'] = 0;
												$sql = "SELECT id FROM " . $wpdb->prefix . "rss_feeder_import WHERE id = '" . $_SESSION[$form->session]['rss_feeder']['id'] . "';";
												if ( $id = $wpdb->get_var( $sql  )) {
													$rssFeederSql = "UPDATE " . $wpdb->prefix . "rss_feeder_import " .
																	"SET feed_id='" . rssFeederDatabaseField( $feedId ) . "'," .
																		"url='" . rssFeederDatabaseField( $_SESSION[$form->session]['rss_feeder']['url'] ) . "'," .
																		"post_active='" . rssFeederDatabaseField( $_SESSION[$form->session]['rss_feeder']['post_active'] ) . "'," .
																		"post_publish='" . rssFeederDatabaseField( $_SESSION[$form->session]['rss_feeder']['post_publish'] ) . "'," .
																		"post_excerpt='" . rssFeederDatabaseField( $_SESSION[$form->session]['rss_feeder']['post_excerpt'] ) . "'," .
																		"post_taxonomy_id='" . rssFeederDatabaseField( $_SESSION[$form->session]['rss_feeder']['post_taxonomy_id'] ) . "'," .
																		"more='" . rssFeederDatabaseField( $_SESSION[$form->session]['rss_feeder']['more'] ) . "'," .
																		"expr_search='" . maybe_serialize( $search ) . "'," .
																		"expr_replace='" . maybe_serialize( $replace ) . "' " .
																	"WHERE id='" . $id . "';";
													$this->message = 'Import feed updated.';
												}
											} else {
													$rssFeederSql = "INSERT INTO " . $wpdb->prefix . "rss_feeder_import " .
																	"SET feed_id='" . rssFeederDatabaseField( $feedId ) . "'," .
																		"url='" . rssFeederDatabaseField( $_SESSION[$form->session]['rss_feeder']['url'] ) . "'," .
																		"post_active='" . rssFeederDatabaseField( $_SESSION[$form->session]['rss_feeder']['post_active'] ) . "'," .
																		"post_publish='" . rssFeederDatabaseField( $_SESSION[$form->session]['rss_feeder']['post_publish'] ) . "'," .
																		"post_excerpt='" . rssFeederDatabaseField( $_SESSION[$form->session]['rss_feeder']['post_excerpt'] ) . "'," .
																		"post_taxonomy_id='" . rssFeederDatabaseField( $_SESSION[$form->session]['rss_feeder']['post_taxonomy_id'] ) . "'," .
																		"more='" . rssFeederDatabaseField( $_SESSION[$form->session]['rss_feeder']['more'] ) . "'," .
																		"expr_search='" . maybe_serialize( $search ) . "'," .
																		"expr_replace='" . maybe_serialize( $replace ) . "';";
													$this->message = 'Import feed added.';
											}
										}
										if ( isset( $rssFeederSql ) ) {
											$showList = true;
											if ( $wpdb->query( $rssFeederSql ) === false ) {
												$this->message = 'Database failed to post.';
											}
										}
										break;
								}
							}
						}
					} else {
						$showList = true;
					}
				}
			}
			if ( $showList ) {
	?><div class='wrap'>
		<h2><?php _e( 'Import Feeds' ); ?></h2>
		<?php if ( !empty( $this->message ) ) { ?><div id="message" class="updated fade"><p><strong><?php _e( $this->message ); ?></strong></p></div><?php } ?>
		<p>
			Imported feeds take feeds from external sites and allow you aggregate other feeds into your a custom feed.<br/>
			The search filter will only import items that match your search criteria.<br/>
			The replace filter allows you to substitute search terms in the original feed with your replaced text.
		</p>
		<hr/>
		<div><?php
				$form->clearFields();
				unset( $_REQUEST['rss_feeder'] );
				echo '<button id="rss_feeder_quick_add_new" class="button">' . __( 'New feed' ) . '</button>';
				echo '<div id="rss_feeder_quick_add">';
				echo '<button id="rss_feeder_quick_add_cancel" class="button">' . __( 'Cancel' ) . '</button>';
				$form->addField( 'hidden', array( 'name' => 'action',
												  'forcedvalue' => 'new' ) );
				$form->addField( 'hidden', array( 'name' => 'formaction',
												  'forcedvalue' => 'save' ) );
				$form->addField( 'hidden', array( 'name' => 'nonce',
												  'forcedvalue' => $this->nonce ) );
				$form->addField( 'select', array( 'name' => 'rss_feeder[feed_id]',
												  'label' => __( 'Select custom feed' ),
												  'help' => array( 'content' => __( 'Select the custom feed you wish to import to, or create a new one.' ),
																   'contentparameters' => array( 'style' => $this->helpStyle ) ),
												  'options' => $customFeedsArray,
												  'validate' => array( 'type' => 'string',
																	   'length' => 255 ) ) );
				$form->addField( 'text', array( 'name' => 'rss_feeder[url]',
												'label' => __( 'Feed URL' ),
												'help' => array( 'content' => __( 'The web address of the feed you wish to import.' ),
																 'contentparameters' => array( 'style' => $this->helpStyle ) ),
												'html' => array( 'size' => 80 ),
												'validate' => array( 'type' => 'string',
																	 'required' => true,
																	 'length' => 255 ) ) );
				$form->addField( 'content', array( 'name' => 'plain',
												   'content' => '<tr><td colspan="2"><hr style="border:1px solid #AAAAAA;margin:0px;padding:0px;line-height:1px;"/></td></tr>' ) );
				$form->addField( 'checkbox', array( 'name' => 'rss_feeder[post_active]',
													'options' => array( __( 'Import into posts' ) => 1 ) ) );
				$form->addField( 'content', array( 'name' => 'container-open-posts-active',
												   'content' => '' ) );
				$form->addField( 'checkbox', array( 'name' => 'rss_feeder[post_publish]',
													'options' => array( __( 'Publish immediately' ) => 1 ) ) );
				$form->addField( 'text', array( 'name' => 'rss_feeder[post_excerpt]',
												'label' => __( 'Extracted excerpt length<br/><small>(leave as 0 to disable)</small>' ),
												'help' => array( 'content' => __( 'Excerpts are automatically created from the description tag when there is a content:encoded tag.<br/>Here you can force the creation of an excerpt from the description if no content:encoded tag exists.' ),
																 'contentparameters' => array( 'style' => $this->helpStyle ) ),
												'html' => array( 'size' => 10 ),
												'validate' => array( 'type' => 'integer' ) ) );
				$form->addField( 'select', array( 'name' => 'rss_feeder[post_taxonomy_id]',
												  'label' => __( 'Post category' ),
												  'help' => array( 'content' => __( 'Select the category you wish to assign to the imported post.' ),
																   'contentparameters' => array( 'style' => $this->helpStyle ) ),
												  'options' => $postCategoriesArray,
												  'validate' => array( 'type' => 'integer' ) ) );
				$form->addField( 'text', array( 'name' => 'rss_feeder[more]',
												'label' => __( 'Insert more tag<br/><small>(leave as 0 to disable)</small>' ),
												'help' => array( 'content' => __( 'Automatically adds the &lt;!--more--&gt; tag at approximately this position in the content, it actually positions it in the next space in the content after this position.' ),
																 'contentparameters' => array( 'style' => $this->helpStyle ) ),
												'html' => array( 'size' => 10 ),
												'validate' => array( 'type' => 'integer' ) ) );
				$form->addField( 'content', array( 'name' => 'container-close-posts-active',
												   'content' => '' ) );

				$form->addField( 'content', array( 'name' => 'plain',
												   'content' => '<tr><td colspan="2"><hr style="border:1px solid #AAAAAA;margin:0px;padding:0px;line-height:1px;"/></td></tr>' ) );
				$form->addField( 'content', array( 'name' => 'plain',
												   'content' => '<tr valign="top" id="rss_feeder_search"><th scope="row" colspan="2"><button id="rss_feeder_add_search" class="button">' . __( 'Add search filter' ) . '</button></th></tr>' ) );
				$form->addField( 'content', array( 'name' => 'plain',
												   'content' => '<tr><td colspan="2"><hr style="border:1px solid #AAAAAA;margin:0px;padding:0px;line-height:1px;"/></td></tr>' ) );
				$form->addField( 'content', array( 'name' => 'plain',
												   'content' => '<tr valign="top" id="rss_feeder_replace"><th scope="row" colspan="2"><button id="rss_feeder_add_replace" class="button">' . __( 'Add replace filter' ) . '</button></th></tr>' ) );
				$form->addField( 'submit', array( 'name' => 'submit',
												  'forcedvalue' => __( 'Save' ),
												  'html' => array( 'class' => 'button-primary' ) ) );
				if ( !class_exists( 'IslTemplate' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-templates.php' );
				$template = new IslTemplate();
				$template->files = RSS_FEEDER_PATH . 'includes/template-admin.php';
				$template->elements = $form;
				$template->output( true );
				echo '</div>';
				echo '<script type="text/javascript">
	/* <![CDATA[ */
	jQuery(document).ready(function(){
		jQuery("#rss_feeder_quick_add").hide();
		jQuery("#rss_feeder_quick_add_new").click(function(){
			jQuery("#rss_feeder_quick_add_new").hide("slow");
			jQuery("#rss_feeder_table").hide("slow");
			jQuery("#rss_feeder_quick_add").show("slow");
		});
		jQuery("#rss_feeder_quick_add_cancel").click(function(){
			jQuery("#rss_feeder_quick_add").hide("slow");
			jQuery("#rss_feeder_table").show("slow");
			jQuery("#rss_feeder_quick_add_new").show("slow");
		});
		var add_search=false;
		var add_replace=false;
		jQuery("#rss_feeder_add_search").click(function(){
			if(!add_search){
				jQuery("#rss_feeder_search").before("<tr valign=\"top\" id=\"rss_feeder_search_head\">"+
											   "<th scope=\"row\">' . __( 'Search Field' ) . '</th>"+
											   "<td>' . __( 'Search Expression' ) . '</td></tr>");
				add_search=true;
			}
			jQuery("#rss_feeder_search").before("<tr valign=\"top\">"+
											   "<th scope=\"row\">"+
											   "<select name=\"rss_feeder[search][field][]\">"+
											   ' . $jsOptionsText . '
											   "</select>"+
											   "</th>"+
											   "<td><input type=\"text\" name=\"rss_feeder[search][expression][]\"/></td></tr>");
			return false;
		});
		jQuery("#rss_feeder_add_replace").click(function(){
			if(!add_replace){
				jQuery("#rss_feeder_replace").before("<tr valign=\"top\" id=\"rss_feeder_replace_head\">"+
											   "<th scope=\"row\">' . __( 'Search Field' ) . '</th>"+
											   "<td>' . __( 'Search Expression -&gt; Replace Expression' ) . '</td></tr>");
				add_replace=true;
			}
			jQuery("#rss_feeder_replace").before("<tr valign=\"top\">"+
													 "<th scope=\"row\">"+
													 "<select name=\"rss_feeder[replace][field][]\">"+
													 ' . $jsOptionsText . '
													 "</select>"+
													 "</th>"+
													 "<td>"+
													 "<input type=\"text\" name=\"rss_feeder[replace][search][]\"/> -&gt; "+
													 "<input type=\"text\" name=\"rss_feeder[replace][replace][]\"/>"+
													 "</td></tr>");
			return false;
		});
		jQuery("#rss_feeder_post_active").click(function(){
			if (jQuery("#rss_feeder_post_active").is(":checked")){
				jQuery("#container-open-posts-active").show();
			} else {
				jQuery("#container-open-posts-active").hide();
			}
		});
		if (jQuery("#rss_feeder_post_active").is(":checked")){
			jQuery("#container-open-posts-active").show();
		} else {
			jQuery("#container-open-posts-active").hide();
		}
	})
	/* ]]> */
	</script>
	';
				$sql = "SELECT * FROM " . $wpdb->prefix . "rss_feeder_import;";
				$results = $wpdb->get_results( $sql, ARRAY_A );
				if ( count( $results ) > 0 ) {
					if ( !class_exists( 'WpAdminTable' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-wp-admin-table.php' );
					$wpAdminTable = new WpAdminTable;
					$wpAdminTable->nonce = array( 'rss-feeder', 'nonce' );
					$wpAdminTable->name = 'import-feeds';
					$wpAdminTable->headings = array( __( 'ID' ),
													 __( 'Feed' ),
													 __( 'URL' ) );
					$options = get_option( 'rss_feeder' );
					$customFeedsArray = array_flip( $customFeedsArray );
					foreach ( $results as $result ) {
						$wpAdminTable->data[$result['id']] = array( $result['id'],
																	'<a href="admin.php?page=rssfeeder-custom&amp;nonce=' . $this->nonce . '&amp;action=setup&amp;redirect=rssfeeder-import&amp;id=' . urlencode( $result['feed_id'] ) . '">' . rssFeederDisplayField( $customFeedsArray[$result['feed_id']] ) . '</a>',
																	rssFeederDisplayField( $result['url'] ) );
						$wpAdminTable->dataActions[$result['id']] = array( '<a href="admin.php?page=' . $_GET['page'] . '&amp;nonce=' . $this->nonce . '&amp;action=setup&amp;id=' . urlencode( $result['id'] ) . '">' . __( 'Setup' ) . '</a>',
																		   '<a href="admin.php?page=' . $_GET['page'] . '&amp;nonce=' . $this->nonce . '&amp;action=import&amp;id=' . urlencode( $result['id'] ) . '">' . __( 'Import' ) . '</a>',
																		   '<a href="admin.php?page=custom-feeds&amp;nonce=' . $this->nonce . '&amp;action=items&amp;id=' . urlencode( $result['feed_id'] ) . '">' . __( 'Items' ) . '</a>'  );
					}
					$wpAdminTable->bulkActions = array( __( 'Delete' ) => 'delete-selected' );
					echo '<div id="rss_feeder_table">';
					$wpAdminTable->output( true );
					echo '</div>';
					echo '<script type="text/javascript">
	/* <![CDATA[ */
	jQuery(document).ready(function(){
		jQuery("#doaction_import-feeds").click(function(){
			var answer = confirm("' . __( 'Are you sure you want to delete the selected feeds?' ) . '");
			return answer;
		});
	})
	/* ]]> */
	</script>
	';
				}
	?>
		</div>
	</div><?php
			} else {
				if ( !class_exists( 'IslTemplate' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-templates.php' );
				$template = new IslTemplate();
				$template->files = RSS_FEEDER_PATH . 'includes/template-admin.php';
				$template->elements = $form;
				$template->output( true );
				echo '<script type="text/javascript">
	/* <![CDATA[ */
	jQuery(document).ready(function(){
		var add_search=' . $addSearch . ';
		var add_replace=' . $addReplace . ';
		jQuery("#rss_feeder_add_search").click(function(){
			if(!add_search){
				jQuery("#rss_feeder_search").after("<tr valign=\"top\" id=\"rss_feeder_search_head\">"+
											   "<th scope=\"row\">' . __( 'Field' ) . '</th>"+
											   "<td>' . __( 'Expression' ) . '</td></tr>");
				add_search=true;
			}
			jQuery("#rss_feeder_search").before("<tr valign=\"top\">"+
											   "<th scope=\"row\">"+
											   "<select name=\"rss_feeder[search][field][]\">"+
											   ' . $jsOptionsText . '
											   "</select>"+
											   "</th>"+
											   "<td><input type=\"text\" name=\"rss_feeder[search][expression][]\"/></td></tr>");
			return false;
		});
		jQuery("#rss_feeder_add_replace").click(function(){
			if(!add_replace){
				jQuery("#rss_feeder_replace").before("<tr valign=\"top\" id=\"rss_feeder_replace_head\">"+
											   "<th scope=\"row\">' . __( 'Field' ) . '</th>"+
											   "<td>' . __( 'Search &amp; Replace' ) . '</td></tr>");
				add_replace=true;
			}
			jQuery("#rss_feeder_replace").before("<tr valign=\"top\">"+
													 "<th scope=\"row\">"+
													 "<select name=\"rss_feeder[replace][field][]\">"+
													 ' . $jsOptionsText . '
													 "</select>"+
													 "</th>"+
													 "<td>"+
													 "<input type=\"text\" name=\"rss_feeder[replace][search][]\"/> -&gt; "+
													 "<input type=\"text\" name=\"rss_feeder[replace][replace][]\"/>"+
													 "</td></tr>");
			return false;
		});
		jQuery("#rss_feeder_post_active").click(function(){
			if (jQuery("#rss_feeder_post_active").is(":checked")){
				jQuery("#container-open-posts-active").show();
			} else {
				jQuery("#container-open-posts-active").hide();
			}
		});
		if (jQuery("#rss_feeder_post_active").is(":checked")){
			jQuery("#container-open-posts-active").show();
		} else {
			jQuery("#container-open-posts-active").hide();
		}
	})
	/* ]]> */
	</script>
	';
			}
		}

		/**
		 * Help page
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 */
		function help()
		{
?>
<div class="wrap">
	<h2>Help</h2>
	<h3>RSS Feeder</h3>
	<div>
		<p>Here you can define aspects that effect all your RSS feeds.</p>
		<h4>Usage</h4>
		<ol>
			<li>
				The permalink will effect where your feeds are accessed by the subscriber.<br/>
				The format of this must contain the tag %link%, so for example if you used the following format /feeds/%link% your feed would appear here:<br/>
				<code>http://www.myblog.com/feeds/myfeed</code>
			</li>
			<li>
				Google Analytics account field allows you to track your feed using your analytics account.<br/>
				You should enter you account number here, the format will be something like UA-123456-78.<br/>
				If you leave this blank then no tracking will occur.
			</li>
			<li>
				Include in Wordpress RSS allows you to control your default blog feed.<br/>
				Currently you can include your pages as a part of this feed, usually this only shows posts.
			</li>
			<li>
				Show Just Categories allows you to show only the selected categories within your feed.
			</li>
			<li>
				Remove Wordpress RSS allow you to remove the post/comments and/or the extras feed from your blog header.
			</li>
		</ol>
	</div>
	<div>&nbsp;</div>
	<hr/>
	<h3>External feeds</h3>
	<div>
		<p>This option allows you to reference external feeds, for example from your FeedBurner account.</p>
		<h4>Usage</h4>
		<ol>
			<li>Enter the title of the feed.</li>
			<li>Enter the web address of the feed. Subscribers will be taken directly to this address.</li>
			<li>Active in header essentially switches the feed on and off since the external feeds only appear as links in your blog header.</li>
		</ol>
	</div>
	<div>&nbsp;</div>
	<hr/>
	<h3>Custom feeds</h3>
	<div>
		<p>This option allows you to create additional feeds. Imported feeds will also appear here.</p>
		<h4>Main feed usage</h4>
		<ol>
			<li>Enter the title of the feed.</li>
			<li>Enter the permalink of your feed. This term will replace the %link% tag you defined in the RSS Feeder section. If you do not have permalinks switched on in your Wordpress admin then the links will appear in the format<br/>
			<code>http://www.myblog.com/?rssfeeder=NAME_OF_YOUR_FEED</code></li>
			<li>Enter the description of your feed. This appears as a summary of your feed.</li>
			<li>You also havethe option of adding categories to your feed. These do not have to relate to your blog, think of them more as tags.</li>
			<li>Active in header essentially switches the feed on and off since the external feeds only appear as links in your blog header.</li>
		</ol>
		<h4>Items usage</h4>
		<p>When you click on the items link on the table you will be able to administer your feed items.</p>
		<ol>
			<li>The publish time-date allows you to queue feed items for the future. It defaults to the current time and date.</li>
			<li>Enter the title of the item.</li>
			<li>The link is a web address that the item relates to. This is where the subscriber will be taken when they click on the item..</li>
			<li>Enter the description of your feed. This appears as a summary of your feed.</li>
			<li>You also have the option of entering an extended content for the item. Here you can use HTML tags to format the look of the content.</li>
			<li>You also have the option of adding categories to your feed. These do not have to relate to your blog, think of them more as tags.</li>
		</ol>
	</div>
	<div>&nbsp;</div>
	<hr/>
	<h3>Import feeds</h3>
	<div>
		<p>This option allows you to import external feeds directly into your blog. Imported feeds are a part of your blog rather than externally linked.</p>
		<h4>Usage</h4>
		<ol>
			<li>Select custom feed dropdown allows you to select an existing custom feed to import the items into, or create a new custom feed to hold the items.</li>
			<li>The feed URL is the location of the external RSS feed.</li>
			<li>Import into posts allows you convert the feed items into posts. You can either publish these immediately or have them appear as drafts. Extracted excerpt length allows you to also create an excerpt field for the post based on the content of the item. The post category allows you to assign the imported post to a category. You can also have a more tag automatically inserted in the content at approximately the character position you define, the more tag will actually be placed in the next available space after this position to ensure readability and HTML tag will not be broken.</li>
			<li>The search filter allows you to define only items that match your search term. The search term can be either a straight forward word or a regular expression. The regular expressions should conform to the PHP functions preg_match() format.</li>
			<li>The replace filter allows you to substitute terms in items. The search/replace terms can be either a straight forward word or a regular expression. The regular expressions should conform to the PHP functions preg_match() format.</li>
			<li>Once you have setup the feed to import you need to hit the 'import' link to get the items.</li>
			<li>The imported items appear in the custom feed section.</li>
			<li>The import feeds can also be scheduled using a cron job, see below for more information.</li>
		</ol>
		<h4>Setting up a scheduled import</h4>
		<p>
			As a part of the plugin there is a file called import.php. This file will run through all your set up import feeds and run them based on your criteria. This file can be scheduled if your server supports it. An command line example for a standard Linux server would be:<br/>
			<br/>
			<code>curl --silent --compressed http://www.myblog.com/wp-content/plugins/rss-feeder/import.php?id=YOUR_FEED_ID &gt; /dev/null 2&gt;&amp;1</code><br/>
			<br/>
			Where YOUR_FEED_ID is the id number of the import feed.<br/>
			You should check with your hosting provider how you can go about setting up scheduled tasks as this can vary greatly between servers.
		</p>
	</div>
</div>
<?php
		}

		/**
		 * Clean urls
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param string $url
		 * @param array $includeParameters
		 * @return string
		 */
		function cleanUrl( $url, $includeParameters )
		{
			if (isset($includeParameters)) {
				$query = '';
				list($urlFile, $urlQuery) = explode('?', $url);
				$url = $urlFile;
				if (is_array($includeParameters)) {
					$urlQuery = str_replace(array('&amp;', '&#038;'), '&', $urlQuery);
					$elements = explode('&', $urlQuery);
					foreach ($elements as $element) {
						list($field, $value) = explode('=', $element);
						$field = strtolower($field);
						if (in_array($field, $includeParameters)) {
							if (! empty($query))
								$query .= '&';
							else
								$query .= '?';
							$query .= $field.'='.$value;
						}
					}
				}
				$url .= $query;
			}
			$return = clean_url($url);
			return $return;
		}

		/**
		 * The content filter
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param string $content
		 * @return string
		 */
		function theContent( $content )
		{
			$pattern = '/<!--\s*rss-feeder:?(.+)?:(\d+):?(\d+)?\s*-->/Uis';
			preg_match_all( $pattern, $content, $matches, PREG_SET_ORDER );
			if ( count( $matches ) > 0 ) {
				foreach ( $matches as $match ) {
					$search[] = $match[0];
					if ( is_numeric( $match[2] ) ) {
						if ( is_numeric( $match[3] ) )
							$feed = rssfeeder_get_feed( $match[2], $match[3] );
						else
							$feed = rssfeeder_get_feed( $match[2] );
						if ( $feed ) {
							if ( !class_exists( 'IslTemplate' ) ) require_once( RSS_FEEDER_PATH . 'includes/class-templates.php' );
							$template = new IslTemplate();
							if ( !isset( $match[1] ) ) $match[1] = 'rss-feeder-template.php';
							$file = get_stylesheet_directory() . '/' . $match[1];
							if ( !file_exists( $file ) ) {
								if ( file_exists( $file . '.php' ) )
									$file = $file . '.php';
								elseif ( file_exists( RSS_FEEDER_PATH . 'templates/' . $match[1] ) )
									$file = RSS_FEEDER_PATH . 'templates/' . $match[1];
								elseif ( file_exists( RSS_FEEDER_PATH . 'templates/' . $match[1] . '.php' ) )
									$file = RSS_FEEDER_PATH . 'templates/' . $match[1] . '.php';
								else {
									if ( is_numeric( $match[3] ) )
										$file = RSS_FEEDER_PATH . 'templates/item.php';
									else
										$file = RSS_FEEDER_PATH . 'templates/list.php';
								}
							}
							$template->files = $file;
							$template->outputVariable = 'feed';
							$template->elements = $feed;
							$replace[] = $template->output();
						} else
							$replace[] = '';
					} else
						$replace[] = '';
				}
			}
			if ( isset( $search ) && isset( $replace ) ) $content = str_replace( $search, $replace, $content );
			return $content;
		}

		/**
		 * Initialise the widget
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param void
		 * @return null
		 */
		function widgetsInit()
		{
			if ( !$options = get_option( 'widget_rss_feeder' ) ) {
				$options = array();
			}

			$widgetOptions = array( 'classname' => 'widget_rss_feeder', 'description' => __( 'Adds your RSS Feeder custom feeds to your sidebar.' ) );
			$controlOptions = array( 'id_base' => 'rss-feeder', 'width' => '250' );
			$name = __( 'RSS Feeder' );

			$registered = false;
			foreach ( array_keys( $options ) as $o ) {
				if ( !isset( $options[$o]['title'] ) ) continue;
				$id = 'rss-feeder-' . $o;
				$registered = true;
				wp_register_sidebar_widget( $id, $name, array( &$this, 'wpRegisterSidebarWidget' ), $widgetOptions, array( 'number' => $o ) );
				wp_register_widget_control( $id, $name, array( &$this, 'wpRegisterWidgetControl' ), $controlOptions, array( 'number' => $o ) );
			}
			if ( !$registered ) {
				wp_register_sidebar_widget( 'rss-feeder-1', $name, array( &$this, 'wpRegisterSidebarWidget' ), $widgetOptions, array( 'number' => -1 ) );
				wp_register_widget_control( 'rss-feeder-1', $name, array( &$this, 'wpRegisterWidgetControl' ), $controlOptions, array( 'number' => -1 ) );
			}
		}

		/**
		 * Create the blog widget
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param string $args
		 * @param integer $widget_args
		 * @return string
		 */
		function wpRegisterSidebarWidget( $args, $widget_args = 1 )
		{
			extract( $args );
			if ( is_numeric( $widget_args ) ) {
			  $widget_args = array( 'number' => $widget_args );
			}
			$widget_args = wp_parse_args( $widget_args, array( 'number' => -1 ) );
			extract( $widget_args, EXTR_SKIP );
			$optionsAll = get_option( 'widget_rss_feeder' );
			if ( !isset( $optionsAll[$number] ) ) {
			  return;
			}
			$options = $optionsAll[$number];
			if ( empty( $options['items'] ) )
				$feed = rssfeeder_get_feed( $options['feedid'] );
			else
				$feed = rssfeeder_get_feed( $options['feedid'], null, $options['items'] );
			if ( $feed ) {
				if ( empty( $options['title'] ) ) {
					$title = htmlspecialchars( stripslashes( $feed->title ) );
				} else {
					$title = htmlspecialchars( stripslashes( $options['title'] ) );
				}
				$summary = (int)$options['summary'];
				$icon = includes_url( 'images/rss.png' );
				$title = '<a class="rsswidget" href="' . $this->getFeedPermalink( $feed->link ) . '" title="' . esc_attr( __( 'Syndicate this content' ) ) . '"><img style="background:orange;color:white;border:none;" width="14" height="14" src="' . $icon . '" alt="RSS"/></a> <a class="rsswidget" href="' . $this->getFeedPermalink( $feed->link ) . '" title="' . wp_html_excerpt( $feed->description, $summary ) . '">' . $title . '</a>';
				echo $before_widget . $before_title . $title . $after_title;
?>
<ul>
<?php
				foreach ( $feed->items as $item ) {
					?>
	<li>
		<?php echo empty( $item->link ) ? '' : '<a class="rsswidget" title="' . wp_html_excerpt( $item->description, $summary ) . ' [&hellip;]" href="' . $item->link . '">'; ?><?php echo $item->title; ?><?php echo empty( $item->link ) ? '' : '</a>'; ?>
		<?php if ( $summary > 0 ) { ?><div class="rssSummary"><?php echo wp_html_excerpt( $item->description, $summary ); ?> [&hellip;]</div><?php } ?>
	</li>
					<?php
				}
?>
</ul>
<?php
				echo $after_widget;
			}
		}

		/**
		 * Create the blog widget
		 *
		 * @author Steven Raynham
		 * @since 0.5
		 *
		 * @param integer $widget_args
		 * @return stdout
		 */
		function wpRegisterWidgetControl( $widget_args = 1 )
		{
			global $wp_registered_widgets, $wpdb;
			static $updated = false;
			if ( is_numeric( $widget_args ) ) {
				$widget_args = array( 'number' => $widget_args );
			}
			$widget_args = wp_parse_args( $widget_args, array( 'number' => -1 ) );
			extract( $widget_args, EXTR_SKIP );
			$optionsAll = get_option( 'widget_rss_feeder');
			if ( !is_array( $optionsAll ) ) {
				$optionsAll = array();
			}
			if ( !$updated && !empty( $_POST['sidebar'] ) ) {
				$sidebar = (string)$_POST['sidebar'];
				$sidebarsWidgets = wp_get_sidebars_widgets();
				if ( isset( $sidebarsWidgets[$sidebar] ) ) {
					$thisSidebar =& $sidebarsWidgets[$sidebar];
				} else {
					$thisSidebar = array();
				}

				foreach ( $thisSidebar as $_widgetId) {
					if ( 'widget_rss_feeder' == $wp_registered_widgets[$_widgetId]['callback'] && isset( $wp_registered_widgets[$_widgetId]['params'][0]['number'] ) ) {
						$widgetNumber = $wp_registered_widgets[$_widgetId]['params'][0]['number'];
						if ( !in_array( 'rss-feeder-' . $widgetNumber, $_POST['widget-id'] ) )
							unset( $optionsAll[$widgetNumber] );
					}
				}
				foreach ( (array)$_POST['widget_rss_feeder'] as $widgetNumber => $posted ) {
					if ( !isset( $posted['title'] ) && isset( $optionsAll[$widgetNumber] ) ) {
						continue;
					}
					$options = array();
					$options['title'] = $posted['title'];
					$options['feedid'] = $posted['feedid'];
					$options['summary'] = $posted['summary'];
					$options['items'] = $posted['items'];
					$optionsAll[$widgetNumber] = $options;
				}
				update_option( 'widget_rss_feeder', $optionsAll );
				$updated = true;
			}

			if ( -1 == $number ) {
				$number = '%i%';
				$values = $this->defaultWidgetOptions;
			} else {
				$values = $optionsAll[$number];
			}

			$sql = "SELECT id, title FROM " . $wpdb->prefix . "rss_feeder_custom;";
			$feedResults = $wpdb->get_results( $sql, ARRAY_A );
			if ( count( $feedResults ) > 0 ) {
			?>
			<p>
				<label for="widget_rss_feeder-<?php echo $number;?>-title">Title</label><br/>
				<input id="widget_rss_feeder-<?php echo $number;?>-title" name="widget_rss_feeder[<?php echo $number;?>][title]" type="text" class="widefat" value="<?php echo stripslashes( htmlentities( $values['title'] ) ); ?>" /><br/>
				<small>(leave blank to use the custom feed title)</small><br/>
				<label for="widget-rss-feeder-<?php echo $number;?>-feedid">Select custom feed</label><br/>
				<select id="widget-rss-feeder-<?php echo $number;?>-feedid" name="widget_rss_feeder[<?php echo $number;?>][feedid]">
				<?php foreach ( $feedResults as $feedResult ) {
					$feedTitle = rssFeederDisplayField( $feedResult['title'] );
					if ( strlen( $feedTitle ) > 26 ) $feedTitle = substr( $feedTitle, 0, 26 ) . '...';
					?>
					<option value="<?php echo $feedResult['id']; ?>"<?php echo ( $feedResult['id'] == $values['feedid'] ) ? ' selected="selected"' : ''; ?>><?php echo $feedResult['id']; ?> - <?php echo $feedTitle; ?></option>
				<?php } ?>
				</select><br/>
				<label for="widget_rss_feeder-<?php echo $number;?>-summary">Summary length</label><br/>
				<input id="widget_rss_feeder-<?php echo $number;?>-summary" name="widget_rss_feeder[<?php echo $number;?>][summary]" type="text" class="widefat" value="<?php echo stripslashes( htmlentities( $values['summary'] ) ); ?>" /><br/>
				<small>(leave blank for no summary)</small><br/>
				<label for="widget_rss_feeder-<?php echo $number;?>-items">Number of items</label><br/>
				<input id="widget_rss_feeder-<?php echo $number;?>-items" name="widget_rss_feeder[<?php echo $number;?>][items]" type="text" class="widefat" value="<?php echo stripslashes( htmlentities( $values['items'] ) ); ?>" /><br/>
				<small>(leave blank for all items)</small>
			</p>
			<p>&nbsp;</p>
			<?php
			} else {
			?>
			<p>You have no custom feeds setup.</p>
			<?php
			}
		}
	}
	new RssFeeder();
} else {
	wp_die( __( 'RSS Feeder plugin conflicts with another plugin. Please contact the developer with a full list of your plugins.' ), 'Plugin error' );
}

/**
 * Activate the plugin
 *
 * @author Steven Raynham
 * @since 0.5
 *
 * @param void
 * @return null
 */
if ( !function_exists( 'rssFeederActivate' ) ) {
	function rssFeederActivate()
	{
		global $wpdb;
		if ( $wpdb->get_var( "SHOW TABLES LIKE '" . $wpdb->prefix . "rss_feeder_external'" ) != $wpdb->prefix . "rss_feeder_external" ) {
			$sql = "CREATE TABLE " . $wpdb->prefix . "rss_feeder_external (" .
				   "id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT," .
				   "active BOOLEAN NOT NULL DEFAULT 0," .
				   "title VARCHAR(255) NOT NULL," .
				   "url VARCHAR(255) NOT NULL," .
				   "PRIMARY KEY (id));";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
		if ( $wpdb->get_var( "SHOW TABLES LIKE '" . $wpdb->prefix . "rss_feeder_custom'" ) != $wpdb->prefix . "rss_feeder_custom" ) {
			$sql = "CREATE TABLE " . $wpdb->prefix . "rss_feeder_custom (" .
				   "id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT," .
				   "active BOOLEAN NOT NULL DEFAULT 0," .
				   "title VARCHAR(255) NOT NULL," .
				   "link VARCHAR(255) NOT NULL," .
				   "description LONGTEXT NOT NULL," .
				   "categories LONGTEXT NOT NULL," .
				   "PRIMARY KEY (id));";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
		if ( $wpdb->get_var( "SHOW TABLES LIKE '" . $wpdb->prefix . "rss_feeder_custom_items'" ) != $wpdb->prefix . "rss_feeder_custom_items" ) {
			$sql = "CREATE TABLE " . $wpdb->prefix . "rss_feeder_custom_items (" .
				   "id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT," .
				   "feed_id BIGINT(20) UNSIGNED NOT NULL," .
				   "title VARCHAR(255) NOT NULL," .
				   "link VARCHAR(255) NOT NULL," .
				   "description LONGTEXT NOT NULL," .
				   "content_encoded LONGTEXT NOT NULL," .
				   "pubdate DATETIME NOT NULL," .
				   "guid VARCHAR(255) NOT NULL," .
				   "categories LONGTEXT NOT NULL," .
				   "PRIMARY KEY (id));";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
		if ( $wpdb->get_var( "SHOW TABLES LIKE '" . $wpdb->prefix . "rss_feeder_import'" ) != $wpdb->prefix . "rss_feeder_import" ) {
			$sql = "CREATE TABLE " . $wpdb->prefix . "rss_feeder_import (" .
				   "id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT," .
				   "feed_id BIGINT(20) UNSIGNED NOT NULL," .
				   "url VARCHAR(255) NOT NULL," .
				   "post_active BOOLEAN NOT NULL DEFAULT 0," .
				   "post_publish BOOLEAN NOT NULL DEFAULT 0," .
				   "post_excerpt BIGINT(20) UNSIGNED NOT NULL," .
				   "post_taxonomy_id BIGINT(20) UNSIGNED NOT NULL," .
				   "more BIGINT(20) UNSIGNED NOT NULL," .
				   "expr_search LONGTEXT NOT NULL," .
				   "expr_replace LONGTEXT NOT NULL," .
				   "PRIMARY KEY (id));";
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		}
		$options = array( 'permalink' => 'feeds/%link%' );
		add_option( 'rss_feeder', $options );
	}
	register_activation_hook( __FILE__ , 'rssFeederActivate' );
} else {
	wp_die( __( 'RSS Feeder plugin conflicts with another plugin. Please contact the developer with a full list of your plugins.' ), 'Plugin error' );
}
