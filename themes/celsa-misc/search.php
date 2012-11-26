<?php get_header(); ?>
<div class="clear"></div>

  <div id="contenu" align="center">
  
 
  
  <div id="contenu_push-home" style="background:#FFF; text-align:left;">
  <div style="margin-left:10px;border-bottom:3px groove #16296D">
  <h2 class="title"> Résultats pour : <strong><?php the_search_query(); ?></strong></h2>
  </div>
  
  
  <div style="margin-left:10px; margin-top:10px;">
      	<?php
    	if (have_posts()) : $side = 'r';
    	while (have_posts()) : the_post(); 
    	$arc_year = get_the_time('Y');
    	$arc_month = get_the_time('m');
    	$arc_day = get_the_time('d');
    	$side = ($side=='r') ? 'l' : 'r';
    	?>
    	<div class="archive">
    	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    	<?php dp_attachment_image(0, 'thumbnail', 'alt="' . $post->post_title . '"'); ?>
    	<?php the_excerpt(); ?>
    	<p><?php comments_popup_link('Pas de commentaires', '1 Commentaire', '% Commentaires'); ?></p>
      <div class="break"></div>
    	</div>
    	<?php endwhile; ?>
    	<div class="break"></div>
    	<!-- begin post navigation -->
    	<div class="postnav">
    	<?php if(function_exists('wp_page_numbers')) { wp_page_numbers(); } ?>
    	</div>
    	<!-- end post navigation -->
    	<?php else : ?>
    	<div class="notfound">
    		<h2>Ouups !</h2>
    		<p>Désolé il n'y a aucun résultat correspondant à votre recherche mais vous pouvez nous contacter !</p>
    	</div>
    	<?php endif; ?>
     </div>
  </div>

</div>
<div class="clear"></div>
 <?php get_footer(); ?>