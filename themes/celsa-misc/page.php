<?php get_header(); ?>
<div class="clear"></div>

<div id="contenu" align="center">
  <div id="contenu_push-home" style="background:#FFF; text-align:left;">
      <div style="margin-left:10px;border-bottom:3px solid #4D649C">
      <?php if (have_posts()) : the_post(); ?>
      <h1><?php the_title(); ?></h1>
      </div>
      
      <div style="margin-left:10px; margin-top:10px;">
    		<!-- begin latest -->
        
    		<?php the_content('Read More'); ?>
    		<!-- end latest -->
    		<?php else : ?>
    		<div class="notfound">
    		 <img src="http://www.celsa-misc.fr/wp-content/themes/celsa-misc/images/404misc2.jpg">
    		</div>
    		<?php endif; ?>
    		<div id="comments"><?php //comments_template(); ?></div>
      </div>
  </div>
</div>


<div class="clear"></div>
 <?php get_footer(); ?>









	
	

		
		
