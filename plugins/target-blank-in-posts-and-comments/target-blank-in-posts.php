<?php

/*
Plugin Name: Target Blank In Posts And Comments
Plugin URI: http://www.inverudio.com/programs/WordPressBlog/NewTabWindowTargetBlankPlugin.php
Description: Keep your visitors. Inserts target="_blank" into post and comment content URLs and external links will open in new tabs. 
Author: Lazar Kovacevic
Version: 3.2
Author URI: http://www.inverudio.com/
*/

/*	Copyright 2009 lakinekaki

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

function wp_getdomain( $url) {
	if(stristr($url,'http')!=$url)$url = 'http://'.$url;
	if(substr_count($url,'/')<3)$url .= '/';	
	$domain = substr($url,strpos($url,'//')+2,(strpos($url,'/',10)-strpos($url,'//')-2));
	$domain_elements = explode('.',$domain);
	array_pop($domain_elements); //the last element is never the value you want
	$domainname = array_pop($domain_elements);
	if($domainname == "co") $domainname = array_pop($domain_elements);
	$domain = strtolower(stristr($domain,$domainname));
	return $domain;
}
global $wptb_my_domain;
$wptb_my_domain = wp_getdomain(get_option('siteurl'));

function wptb_get_domain_name_from_uri($uri){
	preg_match("/^(http:\/\/)?([^\/]+)/i", $uri, $matches);
	$host = $matches[2];
	preg_match("/[^\.\/]+\.[^\.\/]+$/", $host, $matches);
	return $matches[0];	   
}

function wptb_has_no_target_blank($text)
{
	if ( preg_match("/target=[\"\'].*?blank.*?[\"\']/i", $text ) )
		return false;
	else
		return true;
}

function wptb_inarray($needle, $array, $searchKey = false)
{
   if ($searchKey) {
       foreach ($array as $key => $value)
           if (stristr($key, $needle)) {return $key;}
       }
   else {
       foreach ($array as $value)
           if (stristr($value, $needle)) {return $value;}
       }
   return '';
}

function wptb_parse_target_blank($matches)
{global $wptb_my_domain;
	//add in next line's array sites that you think do not deserve credit because they don't give it to other sites.
	if ( 	!wptb_inarray(wptb_get_domain_name_from_uri($matches[3]), array($wptb_my_domain)) &&
		  wptb_has_no_target_blank( $matches[1] ) &&
		  wptb_has_no_target_blank( $matches[4] ) )
	{
		return '<a target="_blank" href="' . $matches[2] . '//' . $matches[3] . '" ' . $matches[1] . $matches[4] . '>' . $matches[5] . '</a>';
	}
	else
	{
		// Do nothing
		return '<a href="' . $matches[2] . '//' . $matches[3] . '" ' . $matches[1] . $matches[4] . '>' . $matches[5] . '</a>';
	}
}
	

function wptb_target_blank($text) 
{
	$pattern = '/<a (.*?)href=[\"\'](.*?)\/\/(.*?)[\"\'](.*?)>(.*?)<\/a>/i';
	$text = preg_replace_callback($pattern,'wptb_parse_target_blank',$text);
	return $text;
}

add_filter('the_content', 'wptb_target_blank', 999);
add_filter('the_excerpt', 'wptb_target_blank', 999);

// delete this one if you don't want it run on comments
add_filter('comment_text', 'wptb_target_blank', 999);
add_filter('get_comment_author_link', 'wptb_target_blank', 999);


?>
