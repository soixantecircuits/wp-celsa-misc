<?php
/**
* Template Name: Agenda test
 *
 * @package WordPress
 */
?>
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/style-agenda.css">
<?php get_header(); ?>

<div class="clear"></div>

 <div id="contenu" align="center">
  <div id="contenu_push-home" style="background:#FFF; text-align:left;">
	<div style="margin-left:10px;border-bottom:3px solid #4D649C">
      <h1><?php the_title(); ?></h1>
  	</div>

	<p style="margin-left:10px;margin-top:10px">Conférences, sorties, actualités littéraires... Une sélection régulière des MISC pour 		vous tenir au courant des nouveautés du secteur.
	<br></p>

	<div style="width:740px;float:left;" id="div1">

	<?php

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

	// The Query
	query_posts( array ( 'category_name' => 'Agenda', 'posts_per_page' => '6', 'paged' => $paged) );


	// The Loop
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

	echo '<div style="float:left;">';
		next_posts_link('&larr; Evénements passés');
	echo '</div>';

	echo '<div style="float:right;">';
		previous_posts_link('Evénements à venir &rarr;');
	echo '</div>';
	?>
		
	</div><!-- fin div1 -->

	<div style="float:right;">
		<br>

		 <div class="widget-annuaire">
   			 <?php get_sidebar('annuaire_esp1'); ?>
			<br>
			<ul>
			<?php

// <!-- ça c'est la liste des tags : on trie les articles en fonctions de la catégorie puisque là c'est que les articles dans « agenda, et là on rajoute les tags. Ce premier blog isole les tags qui on trait au type d'événement : -->	


echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=conference">Conférences</a></li>';
echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=revue">Revues</a></li>';
echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=livre">Livres</a></li>';
echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=podcast">Podcasts</a></li>';
echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=videos">Vidéos</a></li>';
echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=compte-rendu">Compte-rendus</a></li>';
?>

<br><br>

<?php

		//<!-- là c'est tous les autres, en vrac -->

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
?>
	</ul>


    </div> <!-- fin widget-annuaire -->
    
  </div> <!-- fin div en float:right -->

</div> <!--end #contenu-->


<!-- ça c'est les javascripts qui permettent de faire fonctionner le calendrier -->

<script type='text/javascript'>try{jQuery.noConflict();}catch(e){};</script>
<script type='text/javascript' src='http://rhanney.co.uk/wp/wp-content/plugins/google-calendar-events/js/jquery-qtip.js?ver=3.3.2'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var GoogleCalendarEvents = {"ajaxurl":"http:\/\/rhanney.co.uk\/wp\/wp-admin\/admin-ajax.php","loading":"Loading..."};
/* ]]> */
</script>
<script type='text/javascript' src='http://rhanney.co.uk/wp/wp-content/plugins/google-calendar-events/js/gce-script.js?ver=3.3.2'></script>




</div> <!--end #contenu-push-home-->



<div class="clear"></div>
<?php get_footer(); ?>

