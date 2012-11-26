<?php
/**
 * Format database field for web
 *
 * @author Steven Raynham
 * @since 0.5
 *
 * @param string $string
 * @return string
 */
if ( !function_exists( 'rssFeederDisplayField' ) ) {
	function rssFeederDisplayField( $string )
	{
		$string = stripslashes( $string );
		//$string = htmlentities( $string );
		$string = trim( $string );
		$string = @iconv( 'UTF-8', 'UTF-8//IGNORE', $string );
		return $string;
	}
} else wp_die( __( 'RSS Feeder plugin conflicts with another plugin. Please contact the developer with a full list of your plugins.' ), 'Plugin error' );

/**
 * Import custom feed
 *
 * @author Steven Raynham
 * @since 0.5
 *
 * @param integer $id
 * @return bool
 */
if ( !function_exists( 'rssFeederImportRssFeed' ) ) {
	function rssFeederImportRssFeed( $id )
	{
		global $wpdb;
		$sql = "SELECT * FROM " . $wpdb->prefix . "rss_feeder_import WHERE id='" . $id . "';";
		$result = $wpdb->get_row( $sql, ARRAY_A );
		if ( count( $result ) > 0 ) {
			if ( !empty( $result['expr_search'] ) ) {
				$searchArray = maybe_unserialize( stripslashes( $result['expr_search'] ) );
				foreach ( $searchArray as $searchElement ) {
					if ( @preg_match( $searchElement[1], '' ) === false ) $searchElement[1] = '/' . $searchElement[1] . '/Uis';
					if ( $searchElement[0] == 'any' ) {
						$search['title'][] = $searchElement[1];
						$search['description'][] = $searchElement[1];
						$search['content_encoded'][] = $searchElement[1];
						$search['category'][] = $searchElement[1];
					} else
						$search[$searchElement[0]][] = $searchElement[1];
				}
			}
			if ( !empty( $result['expr_replace'] ) ) {
				$replaceArray = maybe_unserialize( stripslashes( $result['expr_replace'] ) );
				foreach ( $replaceArray as $replaceElement ) {
					if ( @preg_match( $replaceElement[1], '' ) === false ) $replaceElement[1] = '/' . $replaceElement[1] . '/Uis';
					if ( $replaceElement[0] == 'any' ) {
						$replace['title'][] = array( $replaceElement[1], $replaceElement[2] );
						$replace['description'][] = array( $replaceElement[1], $replaceElement[2] );
						$replace['content_encoded'][] = array( $replaceElement[1], $replaceElement[2] );
						$replace['category'][] = array( $replaceElement[1], $replaceElement[2] );
					} else
						$replace[$replaceElement[0]][] = array( $replaceElement[1], $replaceElement[2] );
				}
			}
			$feedId = $result['feed_id'];
			if ( $rssElements = rssFeederParseRss( $result['url'] ) ) {
				if ( isset( $rssElements['title'] ) ) $sqlFields['title'] = $rssElements['title'];
				if ( isset( $rssElements['description'] ) ) $sqlFields['description'] = $rssElements['description'];
				if ( isset( $rssElements['category'] ) ) {
					$categoryText = '';
					foreach ( $rssElements['category'] as $category ) {
						if ( !empty( $categoryText ) ) $categoryText .= ',';
						$categoryText .= $category;
					}
					$sqlFields['categories'] = $categoryText;
				}
				$sqlValues = '';
				foreach ( $sqlFields as $sqlField => $sqlValue ) {
					if ( !empty( $sqlValues ) ) $sqlValues .= ',';
					$sqlValues .= $sqlField . "='" . rssFeederDatabaseField( $sqlValue ) . "'";
				}
				$sql = "UPDATE " . $wpdb->prefix . "rss_feeder_custom " .
					   "SET " . $sqlValues . " " .
					   "WHERE id='" . $feedId . "' " .
					   "AND title LIKE '" . __( 'Unnamed import feed' ) . "%' " .
					   "AND description='' " .
					   "AND categories='';";
				if ( $wpdb->query( $sql ) !== false ) {
					if ( isset( $rssElements['item'] ) ) {
						foreach ( $rssElements['item'] as $guid => $item ) {
							unset( $sqlFields );
							if ( isset( $item['title'] ) ) $sqlFields['title'] = $item['title'];
							if ( isset( $search['title'] ) ) {
								$continue = true;
								foreach ( $search['title'] as $pattern ) {
									$continue = $continue && preg_match( $pattern, $sqlFields['title'] );
								}
								if ( !$continue ) continue;
							}
							if ( isset( $replace['title'] ) ) {
								foreach ( $replace['title'] as $replaceArray ) {
									$sqlFields['title'] = preg_replace( $replaceArray[0], $replaceArray[1], $sqlFields['title'] );
								}
							}
							if ( isset( $item['link'] ) ) $sqlFields['link'] = $item['link'];
							if ( isset( $item['description'] ) ) $sqlFields['description'] = $item['description'];
							if ( isset( $search['description'] ) ) {
								$continue = true;
								foreach ( $search['description'] as $pattern ) {
									$continue = $continue && preg_match( $pattern, $sqlFields['description'] );
								}
								if ( !$continue ) continue;
							}
							if ( isset( $replace['description'] ) ) {
								foreach ( $replace['description'] as $replaceArray ) {
									$sqlFields['description'] = preg_replace( $replaceArray[0], $replaceArray[1], $sqlFields['description'] );
								}
							}
							if ( isset( $item['content_encoded'] ) ) $sqlFields['content_encoded'] = $item['content_encoded'];
							if ( isset( $search['content_encoded'] ) ) {
								$continue = true;
								foreach ( $search['content_encoded'] as $pattern ) {
									$continue = $continue && preg_match( $pattern, $sqlFields['content_encoded'] );
								}
								if ( !$continue ) continue;
							}
							if ( isset( $replace['content_encoded'] ) ) {
								foreach ( $replace['content_encoded'] as $replaceArray ) {
									$sqlFields['content_encoded'] = preg_replace( $replaceArray[0], $replaceArray[1], $sqlFields['content_encoded'] );
								}
							}
							if ( isset( $item['pubdate'] ) ) $sqlFields['pubdate'] = date( 'Y-m-d H:i:s', strtotime( $item['pubdate'] ) );
							if ( isset( $item['category'] ) ) {
								$categoryText = '';
								foreach ( $item['category'] as $category ) {
									if ( !empty( $categoryText ) ) $categoryText .= ',';
									$categoryText .= $category;
								}
								$sqlFields['categories'] = $categoryText;
							}
							if ( isset( $search['category'] ) ) {
								$continue = true;
								foreach ( $search['category'] as $pattern ) {
									$continue = $continue && preg_match( $pattern, $sqlFields['categories'] );
								}
								if ( !$continue ) continue;
							}
							if ( isset( $replace['category'] ) ) {
								foreach ( $replace['category'] as $replaceArray ) {
									$sqlFields['categories'] = preg_replace( $replaceArray[0], $replaceArray[1], $sqlFields['categories'] );
								}
							}
							$sqlValues = '';
							foreach ( $sqlFields as $sqlField => $sqlValue ) {
								if ( !empty( $sqlValues ) ) $sqlValues .= ',';
								$sqlValues .= $sqlField . "='" . rssFeederDatabaseField( $sqlValue ) . "'";
							}
							$sql = "SELECT id FROM " . $wpdb->prefix . "rss_feeder_custom_items " .
								   "WHERE feed_id='" . $feedId . "' " .
									 "AND guid='" . $feedId . '-' . rssFeederDatabaseField( $guid ) . "';";
							if ( $itemId = $wpdb->get_var( $sql ) ) {
								$sql = "UPDATE " . $wpdb->prefix . "rss_feeder_custom_items " .
									   "SET " . $sqlValues . " " .
									   "WHERE id='" . $itemId . "';";
							} else {
								$sql = "INSERT INTO " . $wpdb->prefix . "rss_feeder_custom_items " .
									   "SET feed_id='" . $feedId . "'," .
										   "guid='" . $feedId . '-' . rssFeederDatabaseField( $guid ) . "'," .
										   $sqlValues . ";";
							}
							$wpdb->query( $sql );
						}
					}
					if ( $result['post_active'] == 1 ) {
						$sql = "SELECT * FROM " . $wpdb->prefix . "rss_feeder_custom_items WHERE feed_id='" . $feedId . "';";
						$feedResults = $wpdb->get_results( $sql, ARRAY_A );
						if ( count( $feedResults ) > 0 ) {
							foreach ( $feedResults as $feedResult ) {
								$sql = "SELECT post_id FROM " . $wpdb->prefix . "postmeta WHERE meta_key='_rss_feeder' AND meta_value='" . $feedResult['feed_id'] . '-' . $feedResult['id'] . "';";
								$postArray['post_title'] = $feedResult['title'];
								if ( empty( $feedResult['content_encoded'] ) ) {
									if ( $result['post_excerpt'] > 0 )
										$postArray['post_excerpt'] = wp_html_excerpt( $feedResult['description'], $result['post_excerpt'] ) . ' [&hellip;]';
									else
										$postArray['post_excerpt'] = '';
									$postArray['post_content'] = ( $result['more'] > 0 ) ? rssFeederInsertMore( $feedResult['description'], $result['more'] ) : $feedResult['description'];
								} else {
									$postArray['post_excerpt'] = $feedResult['description'];
									$postArray['post_content'] = ( $result['more'] > 0 ) ? rssFeederInsertMore( $feedResult['content_encoded'], $result['more'] ) : $feedResult['content_encoded'];
								}
								if ( $result['post_publish'] == 1 )
									$postArray['post_status'] = 'publish';
								else
									$postArray['post_status'] = 'pending';
								$postArray['post_type'] = 'post';
								$postArray['post_category'] = array( $result['post_taxonomy_id'] );
								if ( $postId = $wpdb->get_var( $sql ) ) {
									$postArray['ID'] = $postId;
									$postArray['post_modified'] = $feedResult['pubdate'];
									wp_update_post( $postArray );
								} else {
									$postArray['post_date'] = $feedResult['pubdate'];
									$postId = wp_insert_post( $postArray );
								}
								update_post_meta( $postId, '_rss_feeder', $feedResult['feed_id'] . '-' . $feedResult['id'], $feedResult['feed_id'] . '-' . $feedResult['id'] );

							}
						}
					}
				}
				$return = true;
			} else
				$return = false;
		} else
			$return = false;
		return $return;
	}
} else wp_die( __( 'RSS Feeder plugin conflicts with another plugin. Please contact the developer with a full list of your plugins.' ), 'Plugin error' );

if ( !function_exists( 'rssFeederInsertMore' ) ) {
	function rssFeederInsertMore( $text = '', $position = null )
	{
		if ( isset( $position )  ) {
			if ( ( $newPosition = @strpos( $text, ' ', (int)$position ) ) !== false ) {
				$text = substr_replace( $text, '<!--more-->', $newPosition + 1, $newPosition + 1 );
			}
		}
		return $text;
	}
}

/**
 * Format for database
 *
 * @author Steven Raynham
 * @since 0.5
 *
 * @param string $string
 * @return string
 */
if ( !function_exists( 'rssFeederDatabaseField' ) ) {
	function rssFeederDatabaseField( $string )
	{
//		$string = @iconv( 'UTF-8', 'UTF-8//IGNORE', $string );
		$string = trim( $string );
		$string = html_entity_decode( $string );
		$string = mysql_real_escape_string( $string );
		return $string;
	}
} else wp_die( __( 'RSS Feeder plugin conflicts with another plugin. Please contact the developer with a full list of your plugins.' ), 'Plugin error' );

/**
 * Extract RSS elements from feed
 *
 * @author Steven Raynham
 * @since 0.5
 *
 * @param string $rssText
 * @return array
 */
if ( !function_exists( 'rssFeederParseRss' ) ) {
	function rssFeederParseRss( $url )
	{
		$feed = fetch_feed( $url );
		if ( !is_wp_error( $feed ) ) {
			$return['title'] = $feed->get_title();
			$return['link'] = $feed->get_permalink();
			$return['description'] = $feed->get_description();
			if ( is_array( $feed->get_categories() ) ) {
				foreach ( $feed->get_categories() as $category ) {
					$return['category'][] = $category;
				}
			}
			$itemCount = $feed->get_item_quantity();
			for ( $x = 0; $x < $itemCount; $x++ ) {
				$item = $feed->get_item( $x );
				$guid = $item->get_id();
				$return['item'][$guid]['title'] = $item->get_title();
				$return['item'][$guid]['link'] = $item->get_permalink();
				$return['item'][$guid]['description'] = $item->get_description();
				$return['item'][$guid]['content_encoded'] = $item->get_content();
				if ( is_array( $item->get_categories() ) ) {
					foreach ( $item->get_categories() as $category ) {
						$return['item'][$guid]['category'][] = $category;
					}
				}
				$return['item'][$guid]['pubdate'] = $item->get_date();
			}
		} else
			$return = false;

/*
		if ( isset( $rssText ) ) {
			list( $rssHead, $rssItems ) = explode( '<item>', $rssText, 2 );
			preg_match( '/<title(.*)?>(.+)<\/title>/Uis', $rssHead, $matches );
			if ( count( $matches ) > 0 ) $return['title'] = rssFeederRemoveCDATA( end( $matches ) );
			preg_match( '/<link(.*)?>(.+)<\/link>/Uis', $rssHead, $matches );
			if ( count( $matches ) > 0 ) $return['link'] = rssFeederRemoveCDATA( end( $matches ) );
			preg_match( '/<description(.*)?>(.+)<\/description>/Uis', $rssHead, $matches );
			if ( count( $matches ) > 0 ) $return['description'] = rssFeederRemoveCDATA( end( $matches ) );
			preg_match_all( '/<category(.*)?>(.+)<\/category>/Uis', $rssHead, $categoryMatches );
			if ( count( $categoryMatches ) > 0 ) {
				foreach ( end( $categoryMatches ) as $categoryMatch ) {
					$return['category'][] = rssFeederRemoveCDATA( $categoryMatch );
				}
			}

			$rssItems = '<item>' . $rssItems;
			preg_match_all( '/<item(.*)?>(.+)<\/item>/Uis', $rssItems, $matches );
			if ( count( $matches ) > 0 ) {
				foreach ( end( $matches ) as $key => $match ) {
					preg_match( '/<guid(.*)?>(.+)<\/guid>/Uis', $match, $matches );
					if ( count( $matches ) > 0 )
						$guid = rssFeederRemoveCDATA( end( $matches ) );
					else
						$guid = $key;
					preg_match( '/<title(.*)?>(.+)<\/title>/Uis', $match, $matches );
					if ( count( $matches ) > 0 ) $return['item'][$guid]['title'] = rssFeederRemoveCDATA( end( $matches ) );
					preg_match( '/<link(.*)?>(.+)<\/link>/Uis', $match, $matches );
					if ( count( $matches ) > 0 ) $return['item'][$guid]['link'] = rssFeederRemoveCDATA( end( $matches ) );
					preg_match( '/<description(.*)?>(.+)<\/description>/Uis', $match, $matches );
					if ( count( $matches ) > 0 ) $return['item'][$guid]['description'] = rssFeederRemoveCDATA( end( $matches ) );
					preg_match( '/<content:encoded(.*)?>(.+)<\/content:encoded>/Uis', $match, $matches );
					if ( count( $matches ) > 0 ) $return['item'][$guid]['content_encoded'] = rssFeederRemoveCDATA( end( $matches ) );
					preg_match( '/<pubDate(.*)?>(.+)<\/pubDate>/Uis', $match, $matches );
					if ( count( $matches ) > 0 ) $return['item'][$guid]['pubdate'] = rssFeederRemoveCDATA( end( $matches ) );
					preg_match_all( '/<category(.*)?>(.+)<\/category>/Uis', $match, $categoryMatches );
					if ( count( $categoryMatches ) > 0 ) {
						foreach ( end( $categoryMatches ) as $categoryMatch ) {
							$return['item'][$guid]['category'][] = rssFeederRemoveCDATA( $categoryMatch );
						}
					}
				}
			}
		} else {
			$return = array();
		}
*/
		return $return;
	}
} else wp_die( __( 'RSS Feeder plugin conflicts with another plugin. Please contact the developer with a full list of your plugins.' ), 'Plugin error' );

/**
 * Clean up RSS feed
 *
 * @author Steven Raynham
 * @since 0.5
 *
 * @param string $string
 * @return string
 */
if ( !function_exists( 'rssFeederRemoveCDDATA' ) ) {
	function rssFeederRemoveCDATA( $string )
	{
		$search = array( '<![CDATA[', ']]>' );
		$string = str_replace( $search, '', $string );
		return $string;
	}
} else wp_die( __( 'RSS Feeder plugin conflicts with another plugin. Please contact the developer with a full list of your plugins.' ), 'Plugin error' );

/**
 * Get custom feed
 *
 * @author Steven Raynham
 * @since 0.5
 *
 * @param integer $feedId
 * @param integer $itemId
 * @param integer $limit
 * @return object
 */
if ( !function_exists( 'rssfeeder_get_feed' ) ) {
	function rssfeeder_get_feed( $feedId = null, $itemId = null, $limit = null )
	{
		global $wpdb;
		if ( isset( $feedId ) ) {
			$sql = "SELECT * FROM " . $wpdb->prefix . "rss_feeder_custom WHERE id='" . $feedId . "';";
			$feedResult = $wpdb->get_row( $sql );
			if ( count( $feedResult ) > 0 ) {
				if ( isset( $itemId ) )
					$sql = "SELECT * FROM " . $wpdb->prefix . "rss_feeder_custom_items WHERE feed_id='" . $feedId . "' AND id='" . $itemId . "';";
				else {
					$sql = "SELECT * FROM " . $wpdb->prefix . "rss_feeder_custom_items WHERE feed_id='" . $feedId . "'";
					if ( isset( $limit ) && is_numeric( $limit ) ) $sql .= " LIMIT 0," . $limit . ";"; else $sql .= ";";
				}
				$itemResults = $wpdb->get_results( $sql );
				if ( count( $itemResults ) > 0 ) {
					$return = $feedResult;
					$return->items = $itemResults;
				} else
					$return = false;
			} else
				$return = false;
		} else
			$return = false;
		return $return;
	}
} else wp_die( __( 'RSS Feeder plugin conflicts with another plugin. Please contact the developer with a full list of your plugins.' ), 'Plugin error' );
