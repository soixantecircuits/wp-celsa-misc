<?php

include("settings.php");

#WIDGET : CARROUSEL 
if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'home_slideshow',
'before_widget'=>'<div class="home_slideshow">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}

if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'home_twittpromo',
'before_widget'=>'<div class="home_twittpromo">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}

if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'home_twittanciens',
'before_widget'=>'<div class="home_twittanciens">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}

if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'home_RSS',
'before_widget'=>'<div class="home_RSS">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}

if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'annuaire_esp1',
'before_widget'=>'<div class="annuaire_esp1">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}

if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'annuaire_esp2',
'before_widget'=>'<div class="annuaire_esp2">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}

if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'annuaire_esp3',
'before_widget'=>'<div class="annuaire_esp3">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}

if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'blog_pres',
'before_widget'=>'<div class="blog_pres">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}

if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'blog_esp1',
'before_widget'=>'<div class="blog_esp1">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}

if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'blog_esp2',
'before_widget'=>'<div class="blog_esp1">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}

if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'blog_esp3',
'before_widget'=>'<div class="blog_esp1">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}

if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'blog_esp4',
'before_widget'=>'<div class="blog_esp1">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}

if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'article_esp1',
'before_widget'=>'<div class="article_esp1">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}

if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'article_esp2',
'before_widget'=>'<div class="article_esp2">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}

if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'article_esp3',
'before_widget'=>'<div class="article_esp3">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}


if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'conference_pres',
'before_widget'=>'<div class="conference_pres">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}

if (function_exists("register_sidebar")) {
register_sidebar(array(
'name'=>'videos_pres',
'before_widget'=>'<div class="videos_pres">',
'after_widget'=>'</div>',
'before_title'=>'<h2>',
'after_title'=>'</h2>',
));
}

# WIDGET: Left Sidebar
if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Left Sidebar',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
		'before_widget' => '',
        'after_widget' => '',
    ));
	
# WIDGET: Right Sidebar
if ( function_exists('register_sidebar') )
    register_sidebar(array(
		'name' => 'Right Sidebar',
        'before_title' => '<h2>',
        'after_title' => '</h2>',
		'before_widget' => '',
        'after_widget' => '',
    ));
    
if ( function_exists ('register_sidebar')) { 
    register_sidebar ('custom'); 
}

# Displays a list of pages
function dp_list_pages() {
	global $wpdb;
	$querystr = "SELECT $wpdb->posts.ID, $wpdb->posts.post_title FROM $wpdb->posts WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = 'page' ORDER BY $wpdb->posts.post_title ASC";
	$pageposts = $wpdb->get_results($querystr, OBJECT);
	if ($pageposts) {
		foreach ($pageposts as $post) {
			?><li><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></li><?php 
		}
	}
}

# Displays a list of categories
function dp_list_categories($exclude='') {
	if (strlen($exclude)>0) $exclude = '&exclude=' . $exclude;
	$categories = get_categories('hide_empty=1'.$exclude);
	$first = true; $count = 0;
	foreach ($categories as $category) {
		$count++; if ($count>6) break;
		if ($category->parent<1) {
			if ($first) { $first = false; $f = ' class="f"'; } else { $f = ''; }
			?><li<?php echo $f; ?>>
			<a href="<?php echo get_category_link($category->cat_ID); ?>"><?php echo $category->name ?><?php echo $raquo; ?></a></li>
			<?php
		}
	}
}

# Displays a list of recent posts
function dp_recent_posts($num, $pre='<li>', $suf='</li>', $excerpt=false) {
	global $wpdb;
	$querystr = "SELECT $wpdb->posts.post_title, $wpdb->posts.ID, $wpdb->posts.post_content FROM $wpdb->posts WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = 'post' ORDER BY $wpdb->posts.post_date DESC LIMIT $num";
	$myposts = $wpdb->get_results($querystr, OBJECT);
	foreach($myposts as $post) {
		echo $pre;
		?><a class="title" href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title ?></a><?php
		if ($excerpt) {
			dp_attachment_image($post->ID, 'medium', 'alt="'.$post->post_title.'"');
			?><p><?php echo dp_clean($post->post_content, 85); ?>... <a href="<?php echo get_permalink($post->ID); ?>">Read More</a></p><?php
		}
		echo $suf;
	}
}

# Displays a list of popular posts
function dp_popular_posts($num, $pre='<li>', $suf='</li>', $excerpt=false) {
	global $wpdb;
	$querystr = "SELECT $wpdb->posts.post_title, $wpdb->posts.ID, $wpdb->posts.post_content FROM $wpdb->posts WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = 'post' ORDER BY $wpdb->posts.comment_count DESC LIMIT $num";
	$myposts = $wpdb->get_results($querystr, OBJECT);
	foreach($myposts as $post) {
		echo $pre;
		?><a class="title" href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title ?></a><?php
		if ($excerpt) {
			dp_attachment_image($post->ID, 'medium', 'alt="'.$post->post_title.'"');
			?><p><?php echo dp_clean($post->post_content, 85); ?>... <a href="<?php echo get_permalink($post->ID); ?>">Read More</a></p><?php
		}
		echo $suf;
	}
}

# Displays a list of recent categories
function dp_recent_comments($num, $pre='<li>', $suf='</li>') {
	global $wpdb, $post;
	$querystr = "SELECT $wpdb->comments.comment_ID, $wpdb->comments.comment_post_ID, $wpdb->comments.comment_author, $wpdb->comments.comment_content, $wpdb->comments.comment_author_email FROM $wpdb->comments WHERE $wpdb->comments.comment_approved=1 ORDER BY $wpdb->comments.comment_date DESC LIMIT $num";
	$recentcomments = $wpdb->get_results($querystr, OBJECT);
	foreach ($recentcomments as $rc) {
		$post = get_post($rc->comment_post_ID);
		echo $pre;
		?><a href="<?php the_permalink() ?>#comment-<?php echo $rc->comment_ID ?>"><?php echo $rc->comment_author; ?></a> on <a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a><?php
		echo $suf;
	}
}


# Displays post image attachment (sizes: thumbnail, medium, full)
function dp_attachment_image($postid=0, $size='thumbnail', $attributes='') {
	if ($postid<1) $postid = get_the_ID();
	if ($images = get_children(array(
		'post_parent' => $postid,
		'post_type' => 'attachment',
		'numberposts' => 1,
		'post_mime_type' => 'image',)))
		foreach($images as $image) {    
			$attachment=wp_get_attachment_image_src($image->ID, $size);
			echo '<div class="push-blog" style="background-image:url('.$attachment[0].'); background-position:center center; background-repeat:no-repeat;"></div>';
		}
}


# Displays post image PUSHblog (sizes: thumbnail, medium, full)
function dp_attachment_image_push($postid=0, $size='full', $attributes='') {
	if ($postid<1) $postid = get_the_ID();
	if ($images = get_children(array(
		'post_parent' => $postid,
		'post_type' => 'attachment',
		'numberposts' => 1,
		'post_mime_type' => 'image',)))
		foreach($images as $image) {
			$attachment=wp_get_attachment_image_src($image->ID, $size);
			?><div class="push-blog" style="background-image:sdfsdf"><img src"<?php echo $attachment[0]; ?>" /></div><?php
		}
}

# Removes tags and trailing dots from excerpt
function dp_clean($excerpt, $substr=0) {
	$string = strip_tags(str_replace('[...]', '...', $excerpt));
	if ($substr>0) {
		$string = substr($string, 0, $substr);
	}
	return $string;
}

# Displays the comment authors gravatar if available
function dp_gravatar($size=50, $attributes='', $author_email='') {
	global $comment, $settings;
	if (dp_settings('gravatar')=='enabled') {
		if (empty($author_email)) {
			ob_start();
			comment_author_email();
			$author_email = ob_get_clean();
		}
		$gravatar_url = 'http://www.gravatar.com/avatar/' . md5(strtolower($author_email)) . '?s=' . $size . '&amp;d=' . dp_settings('gravatar_fallback');
		?><img src="<?php echo $gravatar_url; ?>" <?php echo $attributes ?>/><?php
	}
}

# Retrieves the setting's value depending on 'key'.
function dp_settings($key) {
	global $settings;
	return $settings[$key];
}

function excerpt_read_more_link($output) {
 global $post;
 return $output . '<a href="'. get_permalink($post->ID) . '"> En savoir plus &rarr;</a>';
}
add_filter('the_excerpt', 'excerpt_read_more_link');

#6 posts par page pour l'Agenda, pas plus.


?>
