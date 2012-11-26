<?php
/*
Template Name: Annuaire
*/
?>

 <?php get_header(); ?>
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/style-annuaire.css?v=1">
  <link rel="stylesheet" media="handheld" href="<?php bloginfo('template_url'); ?>/css/handheld.css?v=1">
  <script src="<?php bloginfo('template_url'); ?>/js/modernizr-1.5.min.js"></script>
  
<div class="clear"></div>


 <div id="contenu" align="center">
  <div id="contenu_push-home" style="background:#FFF; text-align:left;">
      <div style="margin-left:10px;border-bottom:3px solid #4D649C">
      <?php if (have_posts()) : the_post(); ?>
      <h1><?php the_title(); ?></h1>
      </div>
           		<?php else : ?>
    		<div class="notfound">
    			<h2>Not Found</h2>
    			<p>Sorry, but you are looking for something that is not here.</p>
    		</div>
    		<?php endif; ?>
      <div style="margin-left:10px; margin-top:10px;">
       <div style="float:left">
       <div id="cannuaire">
    		<!-- begin latest -->   
         <p>Retrouvez tous les MISC, étudiants ou anciens. Découvrez les métiers qu’ils exercent aujourd’hui, leurs travaux de recherche et leurs centres d’intérêt ; contactez-les sur les réseaux sociaux.</p>  <br/> <br/>
    
    <div id="chargement"> 
      <img src="<?php bloginfo('template_url'); ?>/images/load.gif"/> 
      <span><br/>chargement</span> 
    </div> 
    <div id="annuaire" align="center"> 
            <form class="search" onsubmit="return(false)"> 
          <fieldset> 
            <label for="target">Recherche:</label> 
              <input id="target" type="text" /> 
            </fieldset> 
        </form> 
    <ul id="promos_misc" class="tabs"> 
   </ul> 
    <div class="panes" id="main"> 
    </div> 
    </div> 
  
 
 
 
 
 </div>  
 </div>  
 
 <div style="float:right">
   <div class="widget-annuaire">
    <?php// get_sidebar('annuaire_esp1'); ?>
    </div>
    
    <div class="widget-annuaire">
    <?php // get_sidebar('annuaire_esp2'); ?>
    </div>
    
    <div class="widget-annuaire">
    <?php //get_sidebar('annuaire_esp3'); ?>
    </div>
  </div>
</div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script>!window.jQuery && document.write('<script src="js/jquery-1.4.2.min.js"><\/script>')</script>

  <script src="<?php bloginfo('template_url'); ?>/js/jquery.tools.min.js?v=1"></script>
  <script src="<?php bloginfo('template_url'); ?>/js/plugins.js?v=1"></script>
  <script src="<?php bloginfo('template_url'); ?>/js/script-annuaire.js?v=1"></script>

  <!--[if lt IE 7 ]>
    <script src="<?php bloginfo('template_url'); ?>/js/dd_belatedpng.js?v=1"></script>
  <![endif]-->

<div class="clear"></div> <!-- on termine la deuxième ligne -->

 <?php get_footer(); ?> <!-- et hop, le footer du thème-->

