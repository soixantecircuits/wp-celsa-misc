<?php
/*
Template Name: Conference
*/
?>

<?php get_header(); 
?>
<div class="clear"></div>



<div id="contenu" align="center">
  <div id="contenu_push-home" style="background:#FFF; text-align:left;">
      <div style="margin-left:10px;border-bottom:3px solid #4D649C">
      <?php if (have_posts()) : the_post(); ?>
      <h2 class="title"><?php the_title(); ?></h2>
      </div>
           		<?php else : ?>
    		<div class="notfound">
    			<h2>Not Found</h2>
    			<p>Sorry, but you are looking for something that is not here.</p>
    		</div>
    		<?php endif; ?>
      <div style="margin-left:10px; margin-top:10px;">
       <div style="float:left">
       <div id="cblog">
    		<!-- begin latest -->   
            		<!-- begin latest -->   
        <?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts('posts_per_page=7&cat=8&paged=$paged');

//AUTRES POSTS 
if ( have_posts() ) : while ( have_posts() ) : the_post();
echo '<h2><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></h2>'; 
//dp_attachment_image($post->ID, 'full', 'alt="'.$post->post_title.'"');   
echo $post->post_content;
echo '<a href="'.get_comments_link().'"><b>Commentaires : </b>'.$post->comment_count.'</a> <b>Date : </b>'.$post->post_date.' <b>Tags :</b>';
the_tags(' ', ', ', '<br />');
echo '<br /><br />';
endwhile; 

next_posts_link('&laquo; Older Entries');
else:
echo '';
endif;
//Reset Query
wp_reset_query(); 
?>
 </div>  
 </div>  
 
 <div style="float:right">
   <div class="widget-blog">
    <?php get_sidebar('conference_pres'); ?>
    </div>
    
    <div class="widget-blog">
    <?php get_sidebar('blog_esp1'); ?>
    </div>
    
    <div class="widget-blog">
    <?php get_sidebar('blog_esp2'); ?>
    </div>
    
    <div class="widget-blog">
    <?php get_sidebar('blog_esp3'); ?>
    </div>
    
    <div class="widget-blog">
    <?php get_sidebar('blog_esp4'); ?>
    </div> 
  </div>
</div>


<div class="clear"></div>
 <?php get_footer(); ?>