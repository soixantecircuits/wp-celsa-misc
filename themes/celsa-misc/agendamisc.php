<?php
/**
* Template Name: Agenda 2012
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
      <h2 class="title"><?php the_title(); ?></h2>
  </div>

<p style="margin-left:10px;margin-top:10px">Conférences, sorties, actualités littéraires... Une sélection régulière des MISC pour vous tenir au courant des nouveautés du secteur.
<br></p>


<div style="width:740px;float:left;">

   <script type="text/javascript">
    $(function(){ $('.agenda-item').equalHeights(); });

    </script>

<?php

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

// The Query
query_posts( array ( 'category_name' => 'Agenda', 'posts_per_page' => '6', 'paged' => $paged) );


// The Loop
while ( have_posts() ) : the_post();
	echo '<div class="agenda-item">';
		echo '<div id="agenda-img">';
		ec3_the_schedule('%s ','%1$s %3$s %2$s. ',' %s ');
		echo '</div>';
		echo '<div id="agenda-content">';
		echo '<a href="';the_permalink(); echo '"><h3>';the_title(); echo'</h3></a>';
		echo'<br>';
		the_content();
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
previous_posts_link('Evénements à venir &rarr;');
echo '</div>';

?>
		
</div>

<div style="float:right;">
<br>
 <div class="widget-annuaire">
  <?php ec3_get_calendar(); ?>
    </div>

 

 <div class="widget-annuaire">
   <?php // get_sidebar('annuaire_esp1'); ?>
    </div>
    
    <div class="widget-annuaire">
    <?php // get_sidebar('annuaire_esp2'); ?>
    </div>
    
    <div class="widget-annuaire">
    <?php//  get_sidebar('annuaire_esp3'); ?>
    </div>

  </div>

</div> <!--end #contenu-->



</div> <!--end #contenu-push-home-->



<div class="clear"></div>
<?php get_footer(); ?>

