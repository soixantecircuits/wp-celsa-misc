<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

class BxNews
{
	var $feedUrl;
	var $rssElements;

	function BxNews( $feedUrl, $dashboard = true )
	{
		$this->feedUrl = $feedUrl;
		if ( $dashboard ) add_action( 'wp_dashboard_setup', array( &$this, 'wpDashboardSetup' ) );
	}

	function wpDashboardSetup()
	{
		if ( $rssText = @file_get_contents( $this->feedUrl ) ) {
			$this->rssElements = $this->parseRss( $rssText );
			wp_add_dashboard_widget( 'wpAddDashboardWidget', __( $this->rssElements['title'] ), array( &$this, 'wpAddDashboardWidget' ) );
		}
	}

	function wpAddDashboardWidget()
	{
		echo '<p>' . $this->rssElements['description'] . '</p>' .
			 '<ul>';
		foreach ( $this->rssElements['item'] as $guid => $item ) {
			echo '<li><a href="' . $item['link'] . '">' . $item['title'] . '</a><br/>' .
				 $item['description'] . '</li>';
		}
		echo '</ul>';
	}

	function getFeed( $url = '', $excludeUrls = array(), $echo = true )
	{
		if ( empty( $url ) ) $url = $this->feedUrl;
		if ( $rssText = file_get_contents( $url ) ) {
			$this->rssElements = $this->parseRss( $rssText );
			$return = '<div id="bx-news"><h4><a href="' . $this->rssElements['link'] . '" target="_blank">' . $this->rssElements['title'] . '</a><br/><small>' . $this->rssElements['description'] . '</small></h4>';
			$return .= '<p><small>';
			foreach ( $this->rssElements['item'] as $guid => $item ) {
				if ( !in_array( $item['link'], $excludeUrls ) ) {
					$return .= '<a href="' . $item['link'] . '">' . $item['title'] . '</a><br/>' .
							   $item['description'] . '<br/>';
				}
			}
			$return .= '</small></p></div>';
			if ( $echo ) echo $return; else return $return;
		}
	}

	function parseRss( $rssText )
	{
		if ( isset( $rssText ) ) {
			list( $rssHead, $rssItems ) = explode( '<item>', $rssText, 2 );
			preg_match( '/<title(.*)?>(.+)<\/title>/Uis', $rssHead, $matches );
			if ( count( $matches ) > 0 ) $return['title'] = $this->removeCDATA( end( $matches ) );
			preg_match( '/<link(.*)?>(.+)<\/link>/Uis', $rssHead, $matches );
			if ( count( $matches ) > 0 ) $return['link'] = $this->removeCDATA( end( $matches ) );
			preg_match( '/<description(.*)?>(.+)<\/description>/Uis', $rssHead, $matches );
			if ( count( $matches ) > 0 ) $return['description'] = $this->removeCDATA( end( $matches ) );
			preg_match_all( '/<category(.*)?>(.+)<\/category>/Uis', $rssHead, $categoryMatches );
			if ( count( $categoryMatches ) > 0 ) {
				foreach ( end( $categoryMatches ) as $categoryMatch ) {
					$return['category'][] = $this->removeCDATA( $categoryMatch );
				}
			}

			$rssItems = '<item>' . $rssItems;
			preg_match_all( '/<item(.*)?>(.+)<\/item>/Uis', $rssItems, $matches );
			if ( count( $matches ) > 0 ) {
				foreach ( end( $matches ) as $key => $match ) {
					preg_match( '/<guid(.*)?>(.+)<\/guid>/Uis', $match, $matches );
					if ( count( $matches ) > 0 )
						$guid = $this->removeCDATA( end( $matches ) );
					else
						$guid = $key;
					preg_match( '/<title(.*)?>(.+)<\/title>/Uis', $match, $matches );
					if ( count( $matches ) > 0 ) $return['item'][$guid]['title'] = $this->removeCDATA( end( $matches ) );
					preg_match( '/<link(.*)?>(.+)<\/link>/Uis', $match, $matches );
					if ( count( $matches ) > 0 ) $return['item'][$guid]['link'] = $this->removeCDATA( end( $matches ) );
					preg_match( '/<description(.*)?>(.+)<\/description>/Uis', $match, $matches );
					if ( count( $matches ) > 0 ) $return['item'][$guid]['description'] = $this->removeCDATA( end( $matches ) );
					preg_match( '/<content:encoded(.*)?>(.+)<\/content:encoded>/Uis', $match, $matches );
					if ( count( $matches ) > 0 ) $return['item'][$guid]['content_encoded'] = $this->removeCDATA( end( $matches ) );
					preg_match( '/<pubDate(.*)?>(.+)<\/pubDate>/Uis', $match, $matches );
					if ( count( $matches ) > 0 ) $return['item'][$guid]['pubdate'] = $this->removeCDATA( end( $matches ) );
					preg_match_all( '/<category(.*)?>(.+)<\/category>/Uis', $match, $categoryMatches );
					if ( count( $categoryMatches ) > 0 ) {
						foreach ( end( $categoryMatches ) as $categoryMatch ) {
							$return['item'][$guid]['category'][] = $this->removeCDATA( $categoryMatch );
						}
					}
				}
			}
		} else {
			$return = array();
		}
		return $return;
	}

	function removeCDATA( $string )
	{
		$search = array( '<![CDATA[', ']]>' );
		$string = str_replace( $search, '', $string );
		return $string;
	}

}
