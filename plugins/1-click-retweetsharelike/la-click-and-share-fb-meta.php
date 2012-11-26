<?php

function lacands_fb_meta() {
    global $posts;
    //Site name
    $og_site_name = get_bloginfo('name');
    //Post or Page
    if ( is_single() || is_page() ) {
		//Post data
        $post_data = get_post( $posts[0]->ID, ARRAY_A );
        //Title
        $og_title = lacands_prepare_text($post_data['post_title']);
        //Link
        $og_link = get_permalink($posts[0]->ID);
        //Image Link
        $og_link_image = lacands_thumbnail_link($posts[0]->ID, $post_data['post_content']);
        //Content
        if(!empty($post_data['post_excerpt'])) {
            $og_desc = $post_data['post_excerpt'];
        } else {
            $og_desc = $post_data['post_content'];
        }
		$og_desc = lacands_prepare_text($og_desc);
        //Type
        $og_type = 'article';
    } else {
        //Title
		$og_title = lacands_prepare_text($og_site_name);
        //Link
        $og_link = get_bloginfo('url');
		//Image Link
		$og_link_image = '';
        //Desc
		$og_desc = get_bloginfo('description');
		$og_desc = lacands_prepare_text($og_desc);
		//Type
        $og_type = "blog";
    }
	//Locale
	$og_locale = get_option('lacands-html-widget-fb-like-lang');
	//FB App id
	$og_fb_app_id = get_option('lacands-html-fb-app-id');
	//Show tags
	$lacands_opt_fb_metatags = get_option('lacands-html-fb-metatags', 1);
	$lacands_opt_googleplus_metatags = get_option('lacands-html-googleplus-metatags', 1);
	if($lacands_opt_fb_metatags) {
		lacands_build_meta_facebook($og_site_name, $og_title, $og_link, $og_link_image, $og_desc, $og_type, $og_locale, $og_fb_app_id);
	}
	if($lacands_opt_googleplus_metatags) {
		lacands_build_meta_googleplus($og_title, $og_link_image, $og_desc, $og_type);
	}
	return;
}

function lacands_build_meta_facebook($og_site_name, $og_title, $og_link, $og_link_image, $og_desc, $og_type, $og_locale, $og_fb_app_id) {
	if($og_site_name) {
		$opengraph_meta  = "\n<meta property=\"og:site_name\" content=\"" . $og_site_name . "\" />";	
	}
	if($og_title) {
		$opengraph_meta .= "\n<meta property=\"og:title\" content=\"" . $og_title . "\" />";	
	}
	if($og_link) {
		$opengraph_meta .= "\n<meta property=\"og:url\" content=\"" . $og_link . "\" />";	
	}
	if($og_link_image) {
		$opengraph_meta .= "\n<meta property=\"og:image\" content=\"" . $og_link_image . "\" />";	
	}
	if($og_desc) {
		$opengraph_meta .= "\n<meta property=\"og:description\" content=\"" . $og_desc . "\" />";	
	}
	if($og_type) {
		$opengraph_meta .= "\n<meta property=\"og:type\" content=\"". $og_type ."\" />";	
	}
	if($og_locale) {
		$opengraph_meta .= "\n<meta property=\"og:locale\" content=\"" . strtolower($og_locale) . "\" />";	
	}
	if($og_fb_app_id) {
		$opengraph_meta .= "\n<meta property=\"fb:app_id\" content=\"" . trim($og_fb_app_id) . "\" />";
	}
	echo "\n<!-- Facebook Open Graph metatags added by WordPress plugin. Get it at: http://www.linksalpha.com/widgets/buttons -->" . $opengraph_meta . "\n<!-- End Facebook Open Graph metatags-->\n";
}

function lacands_build_meta_googleplus($og_title, $og_link_image, $og_desc, $og_type) {
	if($og_title) {
		$opengraph_meta  = "\n<meta itemprop=\"name\"  content=\"" . $og_title . "\" />";	
	}
	if($og_link_image) {
		$opengraph_meta .= "\n<meta itemprop=\"image\" content=\"" . $og_link_image . "\" />";	
	}
	if($og_desc) {
		$opengraph_meta .= "\n<meta itemprop=\"description\" content=\"" . $og_desc . "\" />";	
	}
	echo "\n<!-- Google Plus metatags added by WordPress plugin. Get it at: http://www.linksalpha.com/widgets/buttons -->" . $opengraph_meta . "\n<!-- End Google Plus metatags-->\n";
}

function lacands_html_schema($attr) {
	$lacands_opt_fb_metatags = get_option('lacands-html-fb-metatags', 1);
	$lacands_opt_googleplus_metatags = get_option('lacands-html-googleplus-metatags', 1);
	if($lacands_opt_fb_metatags) {
		$attr .= " xmlns:og=\"http://opengraphprotocol.org/schema/\"";
		$attr .= " xmlns:fb=\"http://www.facebook.com/2008/fbml\"";
		//$attr .= " xmlns:fb=\"http://ogp.me/ns/fb#\">";
	}
	if($lacands_opt_googleplus_metatags) {
		$lacands_opt_googleplus_page_type = get_option('lacands-html-googleplus-page-type');
		if(!$lacands_opt_googleplus_page_type) {
			$lacands_opt_googleplus_page_type = 'Article';
		}
		$attr .= " itemscope itemtype=\"http://schema.org/".$lacands_opt_googleplus_page_type."\"";
	}
	return $attr;
}

function lacands_prepare_text($text) {
	$text = stripslashes($text);
	$text = strip_tags($text);
	$text = preg_replace("/\[.*?\]/", '', $text);
	$text = preg_replace('/([\n \t\r]+)/', ' ', $text); 
	$text = preg_replace('/( +)/', ' ', $text);
	$text = preg_replace('/\s\s+/', ' ', $text);
	$text = lacands_prepare_string($text, 310);
	$text = lacands_smart_truncate($text, 300);
	$text = trim($text);
	$text = htmlspecialchars($text);
	return $text;
}

function lacands_smart_truncate($string, $required_length) {
  $parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
  $parts_count = count($parts);
  $length = 0;
  $last_part = 0;
  for (; $last_part < $parts_count; ++$last_part) {
    $length += strlen($parts[$last_part]);
    if ($length > $required_length) {break;}
  }
  return implode(array_slice($parts, 0, $last_part));
}

function lacands_prepare_string($string, $string_length) {
	$final_string='';
	$utf8marker=chr(128); 
    $count=0; 
    while(isset($string{$count})){ 
		if($string{$count}>=$utf8marker) { 
			$parsechar=substr($string,$count,2);
			$count+=2; 
		} else { 
			$parsechar=$string{$count}; 
			$count++; 
		}
		if($count > $string_length) {
			return $final_string;
		}
		$final_string=$final_string.$parsechar;
    }
	return $final_string;
}

function lacands_thumbnail_link($post_id, $post_content) {
    if(function_exists('get_post_thumbnail_id') and function_exists('wp_get_attachment_image_src')) {
        $src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'medium');
        if($src) {
            $src = $src[0];
            return $src;
        }
    }
	if(!$post_content) {
		return False;
	}
    if(class_exists("DOMDocument") and function_exists('simplexml_import_dom')) {
		libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        if(!($doc->loadHTML($post_content))){
			return False;
		}
		try {
			$xml = @simplexml_import_dom($doc);
			if($xml) {
				$images = $xml->xpath('//img');
				if(!empty($images)) {
					return $images[0]['src'];
				}
			} else {
				return False;	
			}
		} catch (Exception $e) {
			return False;
		}
    }
    return False;
}
?>