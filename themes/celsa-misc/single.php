<?php get_header(); ?>
 <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/style-agenda.css">
<div class="clear"></div>



<?php

// <!-- Les posts de l'agenda sont affichés à part pour qu'ils s'affichent bien -->

 if (in_category ('Agenda') ) :
echo '<div id="contenu" align="center">
  <div id="contenu_push-home" style="background:#FFF; text-align:left;">
      <div style="width:740px;float:left;">
		<div id="cblog">
		<div class="agenda-article">
 			<div class="agenda-post">';
             	   if (have_posts()) : the_post(); // <!-- on vérifie que y'a bien des posts qui existent -->
                	 echo'<h2 class="title">'; the_title(); echo'</h2>
    		      <br>';
   		      the_content();
         	 echo'</div>
               <br>
           <div id="agenda-post">';
		            echo 'Du '.get_post_meta($post->ID, 'Du', true).' au '.get_post_meta($post->ID, 'Au', true);
		  echo'</div>';
		
          echo' <div id="agenda-social">';
                    lacands_wp_filter_content_widget();
		  echo'</div>';

          echo'<div style="float:left">'; previous_post_link('%link', 'Post précédent', TRUE); echo'</div>';
          echo'<div style="float:right">'; next_post_link('%link', 'Post suivant', TRUE); echo'</div>';

       	 else : // <!-- ça c'est la 404 qui s'affiche s'il n'y a pas de post -->
    		echo '<div class="notfound">
    			 <img src="http://www.celsa-misc.fr/wp-content/themes/celsa-misc/images/404misc2.jpg">
    			</div>';

 endif;
  echo '</div></div></div>'; // <!--on ferme cblog, agenda-article et la div en float:left -->


echo'<div style="float:right;">
	<br><div class="widget-annuaire">';
     	get_sidebar('annuaire_esp1');

		echo '<br><ul>';

		// <!-- ça c'est la liste des tags : on trie les articles en fonctions de la catégorie puisque là c'est que les articles dans « agenda, et là on rajoute les tags. Ce premier blog isole les tags qui on trait au type d'événement : -->		

		echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=conference">Conférences</a></li>';
		echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=revue">Revues</a></li>';
		echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=livre">Livres</a></li>';
		echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=podcast">Podcasts</a></li>';
		echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=videos">Vidéos</a></li>';
		echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag=compte-rendu">Compte-rendus</a></li>';

		echo'<br><br>';

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

// <!- là on éjecte les quelques tags qu'ont rien à voir avec l'agenda -->

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

//<!-- et là on crée donc à chaque tag un lien qui pointe vers l'affichage des posts correspondant à agenda+tag -->

		echo '<li><a href="http://www.celsa-misc.fr/agenda/?tdo_tag='.$post_tag->slug.'">'.$post_tag->name.'</a></li>';
	}
}



	echo'</ul>


    </div>

</div>
</div>';

//<!-- et là commence l'affichage des posts qui sont dans toutes les autres catégories -->

else:

echo '<div id="contenu" align="center">
  		<div id="contenu_push-home" style="background:#FFF; text-align:left;">
 		    <div style="width:740px;float:left;" id="div1">
				<div id="cblog">';

				if (have_posts()) : the_post();
     			echo'<h2 class="title">';the_title(); echo'</h2>';
       			echo'<div class="metainfo"><span> Ecrit par <b>'; the_author(); echo'</b> le '; the_date(); echo'</span></div>';
	
      			echo'<div style="margin-left:10px; margin-top:10px; id="div2"> 
       					<div style="float:left">';
         					the_content('Read More');
      						echo '<div class="break"></div>
      						<div class="details">';
    						the_tags('<p>Tags: ', ', ', '</p>'); 
    						echo'</div>';
     						
							echo'<div id="comments">' ;
							comments_template();
							echo'</div>';

				else : // <!-- again, si y'a pas de post, il sort le nyan cat -->
    			echo '<div class="notfound">
    			<img src="http://www.celsa-misc.fr/wp-content/themes/celsa-misc/images/404misc2.jpg">
    			</div>';

 				endif;

	
				echo '</div></div>
        </div>';  //<!-- on ferme cblog, div1 et div 2
				  // et là, on met une sidebar, qui ne sert à rien là MAIS ON SAIT JAMAIS -->

		echo '<div style="float:right">
   			<div class="widget-article">';
    			get_sidebar('article_esp1');
    		echo '</div>
    
  			<div class="widget-article">';
   				 get_sidebar('article_esp2');
    		echo'</div>
    
    		<div class="widget-article">';
    			get_sidebar('article_esp3');
    		echo '</div>
  		</div>
	</div> 
 </div>'; // <!-- on ferme contenu_push-home et contenu -->


endif;
?>

<!-- ça c'est les javascripts qui permettent de faire fonctionner le calendrier -->
<script type='text/javascript'>try{jQuery.noConflict();}catch(e){};</script>
<script type='text/javascript' src='http://rhanney.co.uk/wp/wp-content/plugins/google-calendar-events/js/jquery-qtip.js?ver=3.3.2'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var GoogleCalendarEvents = {"ajaxurl":"http:\/\/rhanney.co.uk\/wp\/wp-admin\/admin-ajax.php","loading":"Loading..."};
/* ]]> */
</script>
<script type='text/javascript' src='http://rhanney.co.uk/wp/wp-content/plugins/google-calendar-events/js/gce-script.js?ver=3.3.2'></script>
<div class="clear"></div>


<?php get_footer(); ?>          
