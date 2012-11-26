 <?php
 
 ?>


<?php get_header(); ?>
<?php if (in_category ('Agenda') ) {
	echo'<link rel="stylesheet" href="http://www.celsa-misc.fr/wp-content/themes/celsa-misc/css/style-agenda.css">';
} ?>
<div class="clear"></div>
<div id="contenu" align="center">
  <div id="contenu_push-home" style="background:#FFF; text-align:left;">
      <div style="margin-left:10px;border-bottom:3px solid #4D649C">
      <?php if (have_posts()) : the_post(); ?>
      <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */

if (is_category()) { ?>
	<h2 class="title">Archives pour la catégorie <strong><?php single_cat_title(); ?></strong></h2>
	
<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<h2 class="title">Posts Taggés <strong><?php single_tag_title(); ?></strong></h2>
	
<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h2 class="title">Archives de <?php the_time('F jS, Y'); ?></h2>
	
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h2 class="title">Archives de <?php the_time('F, Y'); ?></h2>
	
<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h2 class="title">Archives de <?php the_time('Y'); ?></h2>
	
<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h2 class="title">Author Archive</h2>
	
<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h2 class="title">Blog Archives</h2>
	<?php } ?>

<?php else : ?>
	<h2 class="title">404 !</h2>
      </div>

            <div class="left"><?php next_posts_link('&laquo; Posts pr&eacute;c&eacute;dents') ?></div>
            <div class="right"><?php previous_posts_link('Posts suivants &raquo;') ?></div>
           	
    		<?php endif; ?>
      <div style="width:740px;float:left;">

   <script type="text/javascript">
    $(function(){ $('.agenda-item').equalHeights(); });

    </script>

<?php if (in_category ('Agenda') ) {


$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// The Query
query_posts( array ( 'category_name' => 'Agenda', 'posts_per_page' => '6', 'paged' => $paged) );
if (have_posts()) : the_post();
while ( have_posts() ) : the_post();
	echo '<div class="agenda-item">';	
		echo '<div id="agenda-content">';
		echo '<a href="';the_permalink(); echo '"><h3>';the_title(); echo'</h3></a>';
        echo'<br>';
        echo '<div id="agenda-img">';	
        echo 'Du '.get_post_meta($post->ID, 'Du', true).' au '.get_post_meta($post->ID, 'Au', true);
		echo '</div>';                                                                              the_content();
		echo '</div>';
		
		echo'<div id="agenda-social">';
		lacands_wp_filter_content_widget();
		echo '</div>';

	echo '</div>';
endwhile;
endif;
} 

else { 

if (have_posts()) : the_post();
      echo'<h2 class="title">';the_title(); echo'</h2>';
       echo'<div class="metainfo"><span> Ecrit par <b>'; the_author(); echo'</b> le'; the_date(); echo'</span></div>
      </div>';
      echo'<div style="margin-left:10px; margin-top:10px;">
       <div style="float:left">
		<div id="cblog">';
         	the_content('Read More');
      		echo '<div class="break"></div>
      		<div class="details">';
      		the_tags('<p>Tags: ', ', ', '</p>'); 
      		echo'</div>';
     echo'<div id="comments">' ;
	comments_template();
	echo'</div>';

else :
    		echo '<img src="http://www.celsa-misc.fr/wp-content/themes/celsa-misc/images/404misc2.jpg">';
    		endif;
} ?> 

</div>
<?php if (in_category ('Agenda') ) {
echo'<div style="width:200px;float:right;"><br><div class="widget-annuaire">';
    get_sidebar('annuaire_esp1'); 
echo'<br><ul>';

echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=conference">Conférences</a></li>';
echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=revue">Revues</a></li>';
echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=livre">Livres</a></li>';
echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=podcast">Podcasts</a></li>';
echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=video">Vidéos</a></li>';
echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=compte-rendu">Compte-rendus</a></li>';


echo'<br><br>';


$args = array ('category_name'=> 'Agenda');
	query_posts($args);
	if(have_posts()): while (have_posts()) : the_post();
        $all_tag_objects = get_the_tags();
		if($all_tag_objects){
			foreach($all_tag_objects as $tag) {
				if($tag->count > 0) {$all_tag_ids[] = $tag -> term_id;}
			}

		}
	endwhile;endif;
	$tag_ids_unique = array_unique($all_tag_ids);

foreach($tag_ids_unique as $tag_id) {
		$post_tag = get_term( $tag_id, 'post_tag' );
switch ($post_tag->term_id) {
 case 76:
 case 415:
 case 372:
 case 421:
 case 139:
  break;
 default:
		echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag='.$post_tag->slug.'">'.$post_tag->name.'</a></li>';
	}
}


	echo '</ul></div>';
}
 
else {

echo '<div style="float:right">';
  	echo'<div class="widget-blog">';
    get_sidebar('blog_pres'); 
    echo'</div>';
    
    echo'<div class="widget-blog">';
    get_sidebar('blog_esp1');
    echo'</div>';
    
    echo'<div class="widget-blog">';
    get_sidebar('blog_esp2');
    echo'</div>';
    
    echo'<div class="widget-blog">';
    get_sidebar('blog_esp3');
    echo'</div>';
    
    echo'<div class="widget-blog">';
    get_sidebar('blog_esp4');
   	echo'</div> 
  </div>';
}


?>

</div>
 </div>
</div>
<div class="clear"></div>
 <?php get_footer(); ?>
