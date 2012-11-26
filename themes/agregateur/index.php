<?php get_header(); ?>

	<!-- BEGIN content -->
	<div id="main-content" class="">

		<div id="content">

      <?php include("featured.php"); ?>
		
			<div class="cutting_line"></div>
			<?php
			if (have_posts()) : $side = 'r';
        while (have_posts()) : the_post(); 
          $arc_year = get_the_time('Y');
          $arc_month = get_the_time('m');
          $arc_day = get_the_time('d');
          $side = ($side=='r') ? 'l' : 'r';
			?>
          
           
			<?php endwhile;?>
			<div style="width:940px;">
			<!-- begin bandeau -->
            <div class="bandeau">
          
          <table id="pushs">
          <tr>
          <td> <h2>Notre chaîne vidéo</h2><br />
          <p>Regardez les vidéos réalisées par les étudiants du Master 2 MISC du Celsa : interviews, détournements...</p><br />
          </td>
          <td></td>
           <td> <h2>La conférence</h2><br />
          <p>“L’expertise numérique : le génie, le geek et le truand” à la Cantine le 19 janvier 2011. Découvrez le programme et les vidéos de l’événement organisé par le master 2 MISC. </p><br />
          </td>
           <td> <h2>L'annuaire</h2><br />
          <p>Retrouvez les étudiants et des professeurs du master 2 MISC du Celsa : travaux universitaire expériences professionnels, profils sur les réseaux sociaux...</p><br />
          </td>
          </tr>
          </table>
          </div>
      <!-- end bandeau -->
      <div style=" width:950px;">
      <div id="twitter">
      <div class="twcont">
      <div style="background:#16296D; height:30px;"> <img src="<?php bloginfo('template_url'); ?>/images/nos_tweets.png" style="margin-top:5px; margin-left:15px; z-index:10"/></div>
         <?php get_sidebar('custom'); ?>     
      </div>
      </div>
      
      
      <div id="contrss">
      <div class="rsscont">
       <div style="background:#16296D; height:30px;"> <img src="<?php bloginfo('template_url'); ?>/images/nous_lisons.png" style="margin-top:5px; margin-left:15px;" /></div>
      <h1>rss</h1>
      
      
      
      
      
      
      </div>
      </div>
      </div>
      
        <div class="break"></div>
        <!-- begin post navigation -->
          <div class="postnav">
          <?php if(function_exists('wp_page_numbers')) { wp_page_numbers(); } ?>
          </div>
        <!-- end post navigation -->
			<?php else : ?>
        <div class="notfound">
          <h2>Not Found</h2>
          <p>Sorry, but you are looking for something that is not here.</p>
        </div>
			<?php endif; ?>
		
		</div>
		
    <?php get_sidebar(); ?>
    

     
    
   
	</div>

<!-- END content -->
<div class="clear" style="clear:both"></div>
 <?php get_footer(); ?>



