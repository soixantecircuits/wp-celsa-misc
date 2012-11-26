<?php get_header(); ?>

<!--appel de l'header du thème-->

<div class="clear"></div>

<div id="contenu" align="center">

	<div style="height:290px;width:950px;padding:20px"> <!--//div 1

<!--Ouais on a des divs avec du style dedans. C'est pas très propre, du coup je nomme les divs qu'on s'y retrouve.
	Là, le contenu commence, on appelle la vidéo youtoube ici : -->

    <div style="width:560px;height:350px; float:left; margin-top:12px; padding-bottom:10px;text-align:left;position:relative;z-index:80;"> <!--div 2-->

		<hr style="background:#16296d;height:12px">
		<br>
		<h2 style="color:#16296d;">A la une</h2>
		<br/>
		<?php echo do_shortcode('[FrontpageSlideshow fs_slides=2 fs_show_buttons=0 fs_show_prevnext_buttons=0 fs_default_link_to_page_link=1 fs_default_comment_to_excerpt=0 fs_main_width=560px fs_main_height=280px fs_placeholder_height=225px fs_button_normal_color=#0d1941 fs_button_hover_color=#132563 fs_button_current_color=#132563 fs_ul_color=#0d1941 fs_text_bgcolor=#132563 fs_text_opacity=90% fs_main_border_color=#0d1941 fs_orderby=date fs_loader_image=http://www.celsa-misc.fr/medias-informatises-strategie-communication/wp-content/plugins/frontpage-slideshow/images/loading_black.gif fs_previous_image=http://www.celsa-misc.fr/medias-informatises-strategie-communication/wp-content/plugins/frontpage-slideshow/images/prev.png fs_next_image=http://www.celsa-misc.fr/medias-informatises-strategie-communication/wp-content/plugins/frontpage-slideshow/images/next.png fs_rounded=0 fs_theme=default fs_pause_duration=5000 fs_transition_on_duration=500 fs_transition_duration=500 fs_template=default]'); ?>
     </div> <!--fin // div 2 -->

<!-- Là c'est la définition du MISC et le lien vers l'appli :-->

	<div style="width:310px;float:right;margin-top:12px;text-align:left">  <!-- div 3 --> 
	<hr style="background:#16296d;height:12px">	
	<br>
		<h2 style="color:#16296d;">MISC ?</h2>
		<br/>
		<p class="definition">
		<strong>I.</strong> - Acronyme du Master 2 Professionnel : <strong>M</strong>édias <strong>I</strong>nformatisés et <strong>S</strong>tratégies de <strong>C</strong>ommunication
		</p>		
		<br/><hr><br/>
		<p class="definition">
		<strong>II.</strong> - Subst. Nom qualifiant les étudiants du Master 2 MISC. Plus qu'un simple titre, une communauté, un style de vie...
		</p>		
		<br/><hr><br/>
		<p class="definition">
		<strong>III.</strong> - Sur Twitter, hashtag associé à une promo, qui permet de discuter/partager des informations sur un sujet
		<br/>
		<a href="http://twitter.com/#!/search/realtime/%23misc13" target="_blank">#misc13</a> pour la promo 2013, <a href="https://twitter.com/#!/search/realtime/%23intermisc" target="_blank">#intermisc</a> pour toutes les promos.
		</p>
		<br/><br/>
		<a href="http://celsa-misc.fr/quizz/" target="_BLANK"><img src="http://www.celsa-misc.fr/wp-content/themes/celsa-misc/images/Miscapp3.jpg"></a>
    </div> <!-- fin div 3 -->

    <div class="clear"></div> <!-- c'est juste un clearer, il sépare les deux lignes de la HP-->

<!-- Attention, bordel. Ici on affiche les tweets de @celsamisc : -->

	<br><br>    

	<div style="width:270px; float:left; margin-top:5px;text-align:left;"> <!-- div 4-->
		<hr style="background:#16296d;height:12px">
		<br>
	<h2 style="color:#16296d;">MISC tweets</h2>
		</br></br>

			<div id="likebox-frame" style="width: 250px; height: 230px; overflow: hidden;"> 


				<div style="width: 250px; height: 280px; margin: -53px 0 0 0;" frameborder="0" border="0" > <!--div 5-->


				<script src="http://widgets.twimg.com/j/2/widget.js"></script>
				<script>
				new TWTR.Widget({
  				version: 2,
  				type: 'profile',
  				rpp: 3,
  				interval: 30000,
  				width: 250,
  				height: 180,
  				theme: {
    				shell: {
      				background: '#ffffff',
      				color: '#ffffff'
    				},
    				tweets: {
      				background: '#ffffff',
      				color: '#0b0473',
      				links: '#777785'
    				}
  				},
  				features: {
   				scrollbar: false,
    			loop: false,
    			live: false,
    			behavior: 'all'
  				}
				}).render().setUser('CELSAMISC').start();
				</script>


				</div> <!-- fin div 5 -->

			</div> <!--fin likebox-frame -->

<!-- Je ne peux pas indenter correctement le code de ce tabkeau, donc imagine très fort que c'est le cas. -->

<TABLE>
<TR>
 		<TH>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </TH>
 
<TH>
<a href="http://twitter.com/CelsaMISC" class="twitter-follow-button" data-show-count="false" data-lang="fr">Follow @CelsaMISC</a>
<script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script>
 </TH>

  </TR>
</TABLE> 


		</div> <!--fin div 4 -->

<!-- là on va appeler les titres des derniers événements -->

	<div style="width:250px; float:left; margin-top:5px;margin-left:45px;text-align:left;"> <!-- div 6-->
		<hr style="background:#16296d;height:12px">
		<br>
		<h2 style="color:#16296d;">Actus du digital<h2>
		<br>
		<?php
		query_posts( array ( 'category_name' => 'Agenda','showposts'=> 3) );
		while ( have_posts() ) : the_post();
		echo '<p style="font-size:14px;color:#777785;text-transform:lowercase;">';
		echo 'Du '.get_post_meta($post->ID, 'Du', true).' au '.get_post_meta($post->ID, 'Au', true);
		echo '</p>';
		echo '<a href="';the_permalink(); echo '"><p style="color:#0b0473;text-transform:lowercase;">';the_title(); echo'</p></a><br><br>';		
		endwhile;
		?>
	</div><!-- fin div 6 -->

<!-- ici c'est la MISCMap ! -->

	<div style="width:310px; float:right; margin-top:5px;text-align:left;"> <!--div 7-->
		<hr style="background:#16296d;height:12px">
		<br>
		<h2 style="color:#16296d;">Où sommes-nous ? <br></h2>
		<br>
		<iframe src="http://maps.google.fr/maps/ms?msa=0&amp;msid=214614797033187550059.0004b6de967b480f26a4d&amp;ie=UTF8&amp;t=m&amp;vpsrc=6&amp;ll=48.867778,2.329205&amp;spn=48.871123,2.342312&amp;z=12&amp;output=embed" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" width="310" height="290"></iframe>
	</div> <!--fin div 7-->


</div> <!--fin div 1-->


</div> <!--fin contenu-->

<div class="clear"></div> <!-- on termine la deuxième ligne -->

 <?php get_footer(); ?> <!-- et hop, le footer du thème-->


