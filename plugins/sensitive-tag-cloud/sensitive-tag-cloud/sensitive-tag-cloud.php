<?php
//-----------------------------------------------------------------------------
/*
Plugin Name: Sensitive Tag Cloud
Version: 1.4.1
Plugin URI: http://www.rene-ade.de/inhalte/wordpress-plugin-sensitivetagcloud.html
Description: This wordpress plugin provides a highly configurable tagcloud that shows tags depending of the current context.
Author: Ren&eacute; Ade
Author URI: http://www.rene-ade.de
Min WP Version: 2.3
*/
//-----------------------------------------------------------------------------
?>
<?php

//-----------------------------------------------------------------------------

if( !function_exists('stc_plugin_basename') ) {
  function stc_plugin_basename() {
    return plugin_basename(__FILE__);
  }
}

//-----------------------------------------------------------------------------

// wordpress mu only: get term children (not included in wordpress mu 1.3)
if( !function_exists('get_term_children') ) {
  function get_term_children( $term, $taxonomy ) {
   if ( ! is_taxonomy($taxonomy) )
    return new WP_Error('invalid_taxonomy', __('Invalid Taxonomy'));
  
   $terms = _get_term_hierarchy($taxonomy);
  
   if ( ! isset($terms[$term]) )
    return array();
  
   $children = $terms[$term];
  
   foreach ( $terms[$term] as $child ) {
    if ( isset($terms[$child]) )
      $children = array_merge($children, get_term_children($child, $taxonomy));
   }
  
   return $children;
  }
}

//-----------------------------------------------------------------------------

// check display conditions
function stc_widget_display_allowed( $options=null ) {

  // options
  if( !$options )
    $options = get_option( 'stc_widget' ); // get options

  // check if conditions are active
  if( $options['display'][null] ) // conditions inactive
    return true;
    
  // search for matching conditions
  foreach( $options['display'] as $condition=>$active ) { // get all display conditions
    if( $condition && $active ) { // is condition valid and active
      if( $condition() ) // check condition
        return true; // condition matching: display
    }
  }
  
  // no condition matching
  return false;
}

//-----------------------------------------------------------------------------

// get posts
function stc_get_posts( $queryvars ) {

  // options
  $options = get_option( 'stc_widget' ); // get options

  // get posts
  global $stc_filter_query_onlyminimum_active; // query performance optimization
  $query =& new WP_Query(); // a new query object
  $stc_filter_query_onlyminimum_active_reset = 
    $stc_filter_query_onlyminimum_active; // get last state
  if( $options['activateperformancehacks'] ) // check option
    $stc_filter_query_onlyminimum_active = true; // get only the ids, dont load all post fields    
  $posts = $query->query( $queryvars ); // query posts
  $stc_filter_query_onlyminimum_active =  
    $stc_filter_query_onlyminimum_active_reset; // reset to last state

  // get only real posts
  $posts_tmp = array();
  foreach( $posts as $post ) {
    if( $post->post_type=='post' ) // check post type
      $posts_tmp[] = $post;
  }  
  $posts = $posts_tmp;
    
  // return posts
  return $posts;
}

//-----------------------------------------------------------------------------

// usort function to sort by count
function stc_sort( $tag_a, $tag_b ) {
  if( $tag_a->count>$tag_b->count )
    return +1;
  else if( $tag_a->count<$tag_b->count )
    return -1;
  else
    return 0;
}

//-----------------------------------------------------------------------------

// the tagcloud widget
function stc_widget( $args=null ) {

  // check display conditions
  if( !stc_widget_display_allowed() )
    return; // cancle

  // comment // if you dont like this comment, you may remove it :-(
  echo '<!-- ';
  echo 'WordPress Plugin SensitiveTagCloud by Rene Ade';
  echo ' - ';
  echo 'http://www.rene-ade.de/inhalte/wordpress-plugin-sensitivetagcloud.html';
  echo ' -->';

  // args
  $sidebaroutput = true;
  if( !$args ) {
    $args = array();
    $sidebaroutput = false;
  }
  extract( $args ); // extract args
 
  // options
  $options = get_option( 'stc_widget' ); // get options
  
  // query vars
  $queryvars = null;
  $searchtags = null;
  if( $options['relatedposttags'] && (is_single()||is_page()) ) {
    global $post;
    $posttags = wp_get_post_tags( $post->ID );
    $posttags_slugs = array();
    foreach( $posttags as $posttag ) {
      $posttags_slugs[] = $posttag->slug;
    }
    $queryvars = array( 'tag_slug__in'=>$posttags_slugs );
    $searchtags = $queryvars['tag_slug__in'];         
  }
  else {
    global $wp_the_query; // current query
    $queryvars = $wp_the_query->query_vars; // current query vars
    $searchtags = array();
    if( !empty($queryvars['tag_slug__and']) )
      $searchtags = array_merge( $searchtags, $queryvars['tag_slug__and'] );
    if( strlen($queryvars['tag'])>0 )
      $searchtags = array_merge( $searchtags, explode(' ',$queryvars['tag']) );
  }
  $queryvars['nopaging'] = true; // get all posts  
  
  // searchtags
  $searchtags = array_unique( $searchtags );
  
  // get current posts to get tags
  $posts = stc_get_posts( $queryvars );

  // get tags
  $tags = array();
  if( empty($posts) ) { // if there are no posts
    if( is_home() || is_page() ) // only all tags if is a page
      $tags = get_tags( $args ); // get all tags 
  }
  else { // there are posts
    $posttags = array(); 
    // get tags of posts
    if( $options['activateperformancehacks'] ) {
      $postids = array();
      foreach( $posts as $post ) {  // go through posts    
        $postids[] = $post->ID;
      }      
      $posttags = wp_get_object_terms( $postids, 'post_tag', $args );
    }
    else {
      foreach( $posts as $post ) {  // go through posts
        $currentposttags = wp_get_post_tags( $post->ID, $args ); // get tags of the current post
        foreach( $currentposttags as $posttag ) {
          $posttags[] = $posttag;
        }
      }
    }
    foreach( $posttags as $posttag ) { // go through tags of the current post
      if( !array_key_exists($posttag->name,$tags)  ) { // is tag missing in list
        $tags[ $posttag->name ] = $posttag; // add tag
        $tags[ $posttag->name ]->count = 1; // this is the first occurrence
      }
      else { // tag is already in list
        $tags[ $posttag->name ]->count += 1; // increment occurrence counter
      }
    }    
  }
  
  // exclude search tags
  if( $options['excludesearchtags'] && !empty($searchtags) ) {
    $options['excludetags'] = 
      array_merge( $options['excludetags'], $searchtags );
  }
  
  // exclude tags
  if( !empty($options['excludetags']) ) {
    $tags_tmp = array();
    foreach( $tags as $tag=>$value ) {
      if( !in_array($tag,$options['excludetags']) ) // only if not excluded
        $tags_tmp[ $tag ] = $value; // readd      
    }
    $tags = $tags_tmp;
  }
  
  // check if there are tags to display
  if( empty($tags) ) // no tags
    return; // dont display cloud

  // check min count
  $min = 1;
  if( is_home() ) {
    $min = $options['min']['home'];
  }
  else if( is_page() ) {
    $min = $options['min']['page'];
  }    
  else if( is_archive() ) {
    $min = $options['min']['archive'];
  }
  if( $min>1 ) {
  	$tags_tmp = array();
    foreach( $tags as $tag=>$value ) {
      if( $tags[$tag]->count >= $min )	
        $tags_tmp[ $tag ] = $value; // readd   
    }
    $tags = $tags_tmp;
  }
    
  // limits 
  $limit = 0;
  if( is_home() ) {
    $limit = $options['limit']['home'];
  }
  else if( is_single() ) {
    $limit = $options['limit']['post'];
  }
  else if( is_page() ) {
    $limit = $options['limit']['page'];
  }
  else if( is_archive() ) {
    $limit = $options['limit']['archive'];
  }
  // limit tags
  $options['args']['number'] = $limit;  
  if( $limit>0 && count($tags)>$limit ) {
    // order by count
    usort( $tags, 'stc_sort' );
    $tags = array_reverse( $tags );
    // limit 
    $tags = array_chunk( $tags, $limit );    
    $tags = $tags[0];
  }
  
  // generate cloud
  global $stc_filter_tag_link_active; // restricted links flag
  $args_cloud = array_merge( $args, $options['args'] ); // cloud args
  $stc_filter_tag_link_active_reset = 
    $stc_filter_tag_link_active; // get last state
  if( $options['restrictlinks']['cat'] || $options['restrictlinks']['tag'] ) // check if restrict links
    $stc_filter_tag_link_active = true; // restricted links
  global $wp_version;
  if( version_compare($wp_version,'2.7-A','>=') ) {
    foreach( $tags as $key=>$tag )
      $tags[$key]->link = get_tag_link( $tag->term_id );
  }
  $cloud = wp_generate_tag_cloud( $tags, $args_cloud ); // generate cloud
  $stc_filter_tag_link_active =  
    $stc_filter_tag_link_active_reset; // reset to last state
  if( is_wp_error($cloud) ) // error generating cloud
    return; // cancle
  $cloud = apply_filters( 'wp_tag_cloud', $cloud, $args ); // apply cloud filter
   
  // replace placeholder
  $title = $options['title'];
  $title = str_replace( '%tags%', implode(', ',$searchtags), $title );
   
  // output
  if( $sidebaroutput ) {
    echo $before_widget;
    echo $before_title . $title . $after_title;
    echo $cloud;
    echo $after_widget;
  }
  else
    echo $cloud;
      
  // tagcloud completed
  return;
}

//-----------------------------------------------------------------------------

// widget configuration
function stc_widget_control() {
  echo '<a href="themes.php?page=sensitivetagcloud" target="_blank">';
    echo 'Open Configuration Menu';
  echo '</a>';
}

function stc_admin_output() {

  // options
  $options = $newoptions = get_option('stc_widget'); // get options

  // define args
  $argkeys = array( 
    'smallest'=>0, // number
    'largest'=>0, // number
    'unit'=>array('pt'), // options
    'format'=>array('flat','list'), // options
    'orderby'=>array('name','count'), // options
    'order'=>array('ASC','DESC') // options
  );
  $argdescrs = array( 
    'smallest'=>'Smalles size',
    'largest'=>'Largest size',
    'unit'=>'Size unit',
    'format'=>'Format',
    'orderby'=>'Order by',
    'order'=>'Order'
  );
  // define display conditions
  $displayconditions = array( 
    'is_home'     => 'Show on home page (all tags)',
    'is_page'     => 'Show on pages (all tags)', 
    'is_single'   => 'Show on post pages (tags of post, related tags)',
    'is_search'   => 'Show on search page (tags of posts)',
    'is_archive'  => 'Show in all archives (tags of posts, ignore archive type)',     
    'is_date'     => 'Show in date archives (tags of posts)',
    'is_author'   => 'Show in author archives (tags of posts)',
    'is_tag'      => 'Show in tag archives (tags of posts)',
    'is_category' => 'Show in categories archives (tags of posts)'
  );
  
  // set new options
  if( $_POST['stc-widget-submit'] ) {
    // texts
    $newoptions['title'] = strip_tags( stripslashes($_POST['stc-widget-title']) ); // the title
    // tag arrays
    $newoptions['excludetags'] = explode( ',', str_replace(' ','',strip_tags(stripslashes($_POST['stc-widget-excludetags']))) ); // exclude tags
    // display conditions
    $newoptions['display'][null] = isset( $_POST['stc-widget-display'] );
    foreach( $displayconditions as $key=>$displaycondition ) {
      $newoptions['display'][ $key ] = isset( $_POST['stc-widget-display-'.$key] );
    }
    // checkboxes
    $newoptions['restrictlinks'] = array( // restrict links
      'tag' => isset($_POST['stc-widget-restrictlinks-tag']), 
      'cat' => isset($_POST['stc-widget-restrictlinks-cat']),
      'cat-onlysubcats' => isset($_POST['stc-widget-restrictlinks-cat-onlysubcats'])
    );
    $newoptions['activateperformancehacks']    = isset( $_POST['stc-widget-activateperformancehacks'] ); // performance optimization      
    $newoptions['excludesearchtags']           = isset( $_POST['stc-widget-excludesearchtags'] ); // exclude search tags
    $newoptions['relatedposttags']             = isset( $_POST['stc-widget-relatedposttags'] ); // exclude search tags    
    // display args
    foreach( $argkeys as $argkey=>$type ) {
      if( is_string($type) ) // string field
        $newoptions['args'][$argkey] = $_POST['stc-widget-args-'.$argkey];
      if( is_int($type) ) // int field
        $newoptions['args'][$argkey] = is_numeric($_POST['stc-widget-args-'.$argkey]) ?
                                         (int)$_POST['stc-widget-args-'.$argkey] : $type;
      if( is_array($type) ) // options
        $newoptions['args'][$argkey] = in_array($_POST['stc-widget-args-'.$argkey],$type) ? 
                                         $_POST['stc-widget-args-'.$argkey] : $type[0];
    }
    // min
    $newoptions['min']['home'] = (int)$_POST['stc-widget-min-home'];
    $newoptions['min']['page'] = (int)$_POST['stc-widget-min-page'];
    $newoptions['min']['archive'] = (int)$_POST['stc-widget-min-archive'];
    // limit
    $newoptions['limit']['home'] = (int)$_POST['stc-widget-limit-home'];
    $newoptions['limit']['post'] = (int)$_POST['stc-widget-limit-post'];
    $newoptions['limit']['page'] = (int)$_POST['stc-widget-limit-page'];
    $newoptions['limit']['archive'] = (int)$_POST['stc-widget-limit-archive'];
  }
  
  // update options if needed
  if( $options != $newoptions ) {
    $options = $newoptions;
    update_option('stc_widget', $options);
  }
  
  // display form
  echo '<p>'.'<h3>'.'Title (Sidebar only)'.'</h3>';
    echo '<input type="text" style="width:300px" id="stc-widget-title" name="stc-widget-title" value="'.attribute_escape($options['title']).'" />'.'<br />';
    echo 'Available placeholders: %tags% will get replaced to a comma seperated list of the current query tags'.'<br>';
  echo '</p>';
  echo '<p>'.'<h3>'.'Display'.'</h3>';
    $displayalways = $options['display'][null] ? 'checked="checked"' : '';  
    echo '<input type="checkbox" class="checkbox" id="stc-widget-display" name="stc-widget-display" '.$displayalways.' />'.'Show always (ignore conditions)'.'<br />';  
    foreach( $displayconditions as $key=>$displaycondition ) {
      $checked = $options['display'][ $key ] ? 'checked="checked"' : '';
      echo '<input type="checkbox" class="checkbox" id="stc-widget-display-'.$key.'" name="stc-widget-display-'.$key.'" '.$checked.' />'.$displaycondition.'<br />';    
    }
  echo '</p>';  
  echo '<p>'.'<h3>'.'Links'.'</h3>';
    $restrictlinks_tag = $options['restrictlinks']['tag'] ? 'checked="checked"' : ''; 
    $restrictlinks_cat = $options['restrictlinks']['cat'] ? 'checked="checked"' : ''; 
    $restrictlinks_cat_onlysubcats = $options['restrictlinks']['cat-onlysubcats'] ? 'checked="checked"' : '';
    echo '<input type="checkbox" class="checkbox" id="stc-widget-restrictlinks-tag" name="stc-widget-restrictlinks-tag" '.$restrictlinks_tag.' />'.'Restricted to current tag'.'<br />';    
    echo '<input type="checkbox" class="checkbox" id="stc-widget-restrictlinks-cat" name="stc-widget-restrictlinks-cat" '.$restrictlinks_cat.' />'.'Restricted to current category'.' (Subcategories not included!)'.'<br />';    
    echo '&nbsp&nbsp&nbsp<input type="checkbox" class="checkbox" id="stc-widget-restrictlinks-cat-onlysubcats" name="stc-widget-restrictlinks-cat-onlysubcats" '.$restrictlinks_cat_onlysubcats.' />'.'Restrict only to categories without subcategories'.'<br />';
  echo '</p>';  
  echo '<p>'.'<h3>'.'Style'.'</h3>';
    echo '<table border="0">';
    foreach( $argkeys as $argkey=>$values ) {
      echo '<tr>';
      echo '<td>';
      if( array_key_exists($argkey,$argdescrs) )
        echo $argdescrs[$argkey];
      else
        echo $argkey.' ';
      echo '</td>';        
      echo '<td>';
      if( is_int($values) || is_string($values) )
        echo '<input type="text" style="width:150px" id="stc-widget-args-'.$argkey.'" name="stc-widget-args-'.$argkey.'" value="'.$options['args'][$argkey].'" />';
      if( is_array($values) ) {
        echo '<select id="stc-widget-args-'.$argkey.'" name="stc-widget-args-'.$argkey.'">';
        foreach( $values as $value ) {
          echo '<option '.($value==$options['args'][$argkey]?'selected':'').'>'.$value.'</option>';      
        }
        echo '</select>';
      }
      echo '</td>';
      echo '</tr>';
    }
    echo '</table>';
  echo '</p>';  
  echo '<p>'.'<h3>'.'Related'.'</h3>';  
    $relatedposttags = $options['relatedposttags'] ? 'checked="checked"' : '';
    echo '<input type="checkbox" class="checkbox" id="stc-widget-relatedposttags" name="stc-widget-relatedposttags" '.$relatedposttags.' />'.'Show also related tags if displaying a single post'.'<br />';  
  echo '</p>';  
  echo '<p>'.'<h3>'.'Exclude'.'</h3>';
    $excludesearchtags = $options['excludesearchtags'] ? 'checked="checked"' : '';
    echo '<input type="checkbox" class="checkbox" id="stc-widget-excludesearchtags" name="stc-widget-excludesearchtags" '.$excludesearchtags.' />'.'Exclude current query tags'.'<br />';
    $excludetags = implode( ', ', $options['excludetags'] );
    echo 'Exclude Tags'.' '.'<input type="text" class="text" id="stc-widget-excludetags" name="stc-widget-excludetags" value="'.$excludetags.'"/>'.'<br />';
  echo '</p>';  
  echo '<p>'.'<h3>'.'Minimum'.'</h3>';  
    echo 'Minimum number of occurrences a tag has to have to be displayed'.'<br>';
    $min = $options['min'];
    foreach( $min as $minkey=>$minvalue ) {
      if( !($minvalue>1) )
        $min[$minkey] = '';
    }
    echo '<input type="text" class="text" id="stc-widget-min-home" name="stc-widget-min-home" value="'.$min['home'].'"/>'.' on home page (overall)'.'<br />';
    echo '<input type="text" class="text" id="stc-widget-min-page" name="stc-widget-min-page" value="'.$min['page'].'"/>'.' on static pages (overall)'.'<br />';
    echo '<input type="text" class="text" id="stc-widget-min-archive" name="stc-widget-min-archive" value="'.$min['archive'].'"/>'.' on archives (in current selection)'.'<br />';
  echo '<p>'.'<h3>'.'Limit'.'</h3>';  
    echo 'Maximum number of tags to display'.'<br>';
    $limit = $options['limit'];
    foreach( $limit as $limitkey=>$limitvalue ) {
      if( !($limitvalue>0) )
        $limit[$limitkey] = '';
    }
    echo '<input type="text" class="text" id="stc-widget-limit-home" name="stc-widget-limit-home" value="'.$limit['home'].'"/>'.' on home page'.'<br />';
    echo '<input type="text" class="text" id="stc-widget-limit-post" name="stc-widget-limit-post" value="'.$limit['post'].'"/>'.' on post pages'.'<br />';
    echo '<input type="text" class="text" id="stc-widget-limit-page" name="stc-widget-limit-page" value="'.$limit['page'].'"/>'.' on static pages'.'<br />';
    echo '<input type="text" class="text" id="stc-widget-limit-archive" name="stc-widget-limit-archive" value="'.$limit['archive'].'"/>'.' on archives'.'<br />';
  echo '</p>';    
  echo '<p>'.'<h3>'.'Performance'.'</h3>';
    $activateperformancehacks = $options['activateperformancehacks'] ? 'checked="checked"' : '';
    echo '<input type="checkbox" class="checkbox" id="stc-widget-activateperformancehacks" name="stc-widget-activateperformancehacks" '.$activateperformancehacks.' />'.'Activate Performance Hacks'.'<br />';
  echo '</p>';  
  echo '<input type="hidden" name="stc-widget-submit" id="stc-widget-submit" value="1" />';
  
  // completed control
  return;
}

//-----------------------------------------------------------------------------

function stc_admin() {

  // page output
  echo '<div class="wrap">';
    echo '<h2>SensitiveTagCloud Configuration</h2>';
    echo '<div class="controlform">';
      echo '<form method="post">';
        stc_admin_output();
        echo '<input type="submit" value="Save">';
      echo '</form>';
    echo '</div>';
  echo '</div>';
  echo '<div class="wrap">';
    echo '<h2>SensitiveTagCloud Instructions</h2>';
    echo 'If your Theme does not support widgets, add the following code to your template file where you like to output the SensitiveTagCloud:<br>';
    echo '<br>';
    highlight_string(
      '<?php '."\n".
      '  if( function_exists("stc_widget") )'."\n".
      '    stc_widget();'."\n".
      '?>' );
    echo '<br>';      
  echo '</div>';
  echo '<div class="wrap">';
	echo '<h2>SensitiveTagCloud About</h2>';
    echo 'Official Plugin Website: '
         .'<a href="http://www.rene-ade.de/inhalte/wordpress-plugin-sensitivetagcloud.html" target="_blank">'
         .'http://www.rene-ade.de/inhalte/wordpress-plugin-sensitivetagcloud.html'
         .'</a> '
         .'(Informations, Updates, ...)'
         .'<br>';      
    echo 'Donations to the Author: '
         .'<a href="http://www.rene-ade.de/stichwoerter/spenden" target="_blank">'
         .'http://www.rene-ade.de/stichwoerter/spenden'
         .'</a> '
         .'(Amazon-Wishlist, Paypal, ...)'
         .'<br>';
  echo '</div>';
  echo '<br>';
}

function stc_admin_add() {
  add_submenu_page( 'themes.php', 'SensitiveTagCloud', 'SensitiveTagCloud', 10/*ADMIN_ONLY*/, 'sensitivetagcloud', 'stc_admin' ); 
}

//-----------------------------------------------------------------------------

// filter query
function stc_filter_query_onlyminimum( $query ) {
  global $stc_filter_query_onlyminimum_active;
  if( !$stc_filter_query_onlyminimum_active )
    return $query;
    
  global $wpdb;
  $query = str_replace( " $wpdb->posts.* ",
                        " $wpdb->posts.ID, $wpdb->posts.post_type ", 
                        $query ); // select only the id
                             
  // return the optimized query                        
  return $query;                        
}

//-----------------------------------------------------------------------------

// get tag link
function stc_get_tag_link( $tag_id, $options=null ) {
	global $wp_rewrite;
  
  // permastruct
	$taglink = $wp_rewrite->get_tag_permastruct();
  
  // get current slugs
  $slugs = stc_get_tag_link_slugs( $options ); // get all restriction slugs
      
  // get tag slug by id
  $tag_term = &get_term( $tag_id, 'post_tag' );
  if( is_wp_error($tag_term) )  
    return null;
    
  // merge slugs
  $link_slugs = array( $tag_term->slug ); // the current tag slug
  $link_slugs = array_merge( $link_slugs, $slugs['slugs_and'] );
  // unique
  $link_slugs = array_unique( $link_slugs );
  
  // slugs
  $slugs = implode( '+', $link_slugs );

  // cat links
  $catlink = false;
  $cat_id = get_query_var('cat'); // cat
  if( $options['restrictlinks']['cat'] && !empty($cat_id) ) { // restirct to cat?
    $cat_hasnochilds = null;
    if( $options['restrictlinks']['cat-onlysubcats'] ) { // check for subcategories if needed
      $cat_children = get_term_children( $cat_id, 'category' ); // get direct subcategories
      if( !is_wp_error($cat_children) )
        $cat_hasnochilds = ( count($cat_children)==0 ); // count subcategories
    }
    if( !$options['restrictlinks']['cat-onlysubcats'] || $cat_hasnochilds ) { // check if has subcategories if restricted
      $cat_term = &get_term( $cat_id, 'category' ); // get term
      if( !is_wp_error($cat_term) )
        $catlink = true;
    }
  }
  
  // build link
	if ( empty($taglink) || $catlink ) { // no permalink: use getvars // cat slug as tag slug will not longer work (2.7)
		$file = get_option('home') . '/';
    if( $catlink )
  		$taglink = $file . '?cat=' . $cat_id . '&tag=' . $tag_term->slug . '+' . $slugs; // wp bug #5433 
    else
  		$taglink = $file . '?tag=' . $slugs;
	} else { // permalink
		$taglink = str_replace('%tag%', $slugs, $taglink);
		$taglink = get_option('home') . user_trailingslashit($taglink, 'category');
	}

  // apply filter and return link
  return apply_filters('tag_link', $taglink, $tag_id);  
}

// get current slugs
function stc_get_tag_link_slugs( $options=null ) {

  // use cached values if possible
  global $stc_get_tag_link_slugs_cache;
  if( is_array($stc_get_tag_link_slugs_cache) )
    return $stc_get_tag_link_slugs_cache;
  
  // initialize
  $stc_get_tag_link_slugs_cache = array(
    'slugs_and' => array() 
  );
  
  // options
  if( !$options )
    $options = get_option( 'stc_widget' ); // get options
      
  // get last slugs
  $stc_get_tag_link_slugs_cache['slugs_and'] = 
    get_query_var('tag_slug__and');
    
  // add current slugs
  $tag_id = get_query_var('tag_id'); // tag
  if( $options['restrictlinks']['tag'] && !empty($tag_id) ) { // restrict to tag?
    $tag_term = &get_term( $tag_id, 'post_tag' ); // get term
    if( !is_wp_error($tag_term) )
      $stc_get_tag_link_slugs_cache['slugs_and'][] = $tag_term->slug; // slug
  }
    
  // unique
  $stc_get_tag_link_slugs_cache['slugs_and'] = array_unique(
    $stc_get_tag_link_slugs_cache['slugs_and'] );
    
  // return slugs
  return $stc_get_tag_link_slugs_cache;
}

// filter tag link
function stc_filter_tag_link( $taglink, $tag_id ) {
  global $stc_filter_tag_link_active;
  if( !$stc_filter_tag_link_active )
    return $taglink;

  // options
  $options = get_option( 'stc_widget' ); // get options

  // only for tag archives ant cats
  $restrictlinks = false;
  if( $options['restrictlinks']['tag'] && is_tag() ) // tag
    $restrictlinks = true;
  if( $options['restrictlinks']['cat'] && is_category() ) // category
    $restrictlinks = true;
  if( !$restrictlinks )
    return $taglink;
    
  // get link
  $stc_filter_tag_link_active = false; // no endless loop through filters
  $newtaglink = stc_get_tag_link( $tag_id, $options ); // get link by slugs
  if( !$newtaglink ) 
    return $taglink;
  $stc_filter_tag_link_active = true; // reset
    
  // return tag link
  return $newtaglink;
}

//-----------------------------------------------------------------------------

// add admin actions
function stc_filter_plugin_action_links( $action_links, $plugin_file ) {
  if( $plugin_file!=stc_plugin_basename() ) // only for this plugin
    return $action_links;

  // add links
  $action_links[] = '<a href="themes.php?page=sensitivetagcloud">'.__('Configure').'</a>';
  $action_links[] = '<a href="http://www.rene-ade.de/stichwoerter/spenden" target="_blank">'.__('Donate').'</a>';

  // return with links
  return $action_links;
}

//-----------------------------------------------------------------------------
    
// (de)activation
function stc_activate() {
  
  // default args
  $defaultargs = array(
    'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 
    'format' => 'flat', 'orderby' => 'name', 'order' => 'ASC'
  );
  
  // options, defaultvalues
  $options = array( 
    'title'   => 'Tags', 
    'args'    => $defaultargs,
    'display' => array( // display only if function evaluates to true
      null       => false,
      'is_single'   => false, 
      'is_page'     => false,
      'is_archive'  => true,     
      'is_date'     => true,
      'is_author'   => true,
      'is_category' => true,
      'is_tag'      => true,
      'is_home'     => true,
      'is_search'   => true
    ),
    'restrictlinks' => array( // restrict links to...
      'tag' => true,
      'cat' => false,
      'cat-onlysubcats' => false
    ),
    'min' => array( // min count
      'page' => 1,
      'home' => 1,
      'archive' => 1
    ),
    'limit' => array( // max number of tags
      'post' => 0,
      'page' => 0,
      'home' => 0,
      'archive' => 0
    ),
    'activateperformancehacks' => true, // activate performance hacks
    'excludetags'              => array(), // a list of tags to exclude from the tagcloud
    'excludesearchtags'        => false // exclude search tags
  );
  
  // register option
  add_option( 'stc_widget', $options );
  
  // activeted
  return;
}
function stc_deactivate() {

  // unregister option
  delete_option('stc_widget'); 
  
  // deactivated
  return;
}

// initialization
function stc_init() {  

  // register widget
  $class['classname'] = 'stc_widget';
  wp_register_sidebar_widget('sensitive_tag_cloud', 'Sensitive Tag Cloud', 'stc_widget', $class);
  wp_register_widget_control('sensitive_tag_cloud', 'Sensitive Tag Cloud', 'stc_widget_control', 'width=300&height=100');
  
  // init globals
  global $stc_filter_query_onlyminimum_active; // performance hack
  global $stc_filter_tag_link_active;          // restrict links
  global $stc_get_tag_link_slugs_cache; // current restriction slugs
  $stc_filter_query_onlyminimum_active = false;
  $stc_filter_tag_link_active          = false;
  $stc_get_tag_link_slugs_cache = null;
  
  // initialized
  return;
}

//-----------------------------------------------------------------------------

// actions
add_action( 'activate_'.stc_plugin_basename(),   'stc_activate' );
add_action( 'deactivate_'.stc_plugin_basename(), 'stc_deactivate' );
add_action( 'init', 'stc_init');
add_action( 'admin_menu', 'stc_admin_add' );

// filters
add_filter( 'query', 'stc_filter_query_onlyminimum', 9 ); // a filter for fields queried in post/get_posts() only would be better
add_filter( 'tag_link', 'stc_filter_tag_link', 5, 2 ); // extend tag links
add_filter( 'plugin_action_links', 'stc_filter_plugin_action_links', 5, 2 ); // add admin actions

//-----------------------------------------------------------------------------

?>