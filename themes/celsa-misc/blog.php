<?php
/*
Template Name: Blog
*/
?>

	

<?php get_header(); 
is_front_page();
?>
<div class="clear"></div>



<div id="contenu" align="center">
  <div id="contenu_push-home" style="background:#FFF; text-align:left;">
      <div style="margin-left:10px;border-bottom:3px solid #4D649C">
      <?php if (have_posts()) : the_post(); ?>
      <h1><?php the_title(); ?></h1>
      </div>
           		<?php else : ?>
    		<div class="notfound">
    		 <img src="http://www.celsa-misc.fr/wp-content/themes/celsa-misc/images/404misc2.jpg">
    		</div>
    		<?php endif; ?>
      <div style="margin-left:10px; margin-top:10px;">
       <div style="float:left">
       <div id="cblog">
    		<!-- begin latest -->   
      
<?php
query_posts('cat=4');

//PUSH2
if ( have_posts() ) : while ( have_posts() ) : the_post();
echo '<br/><hr/><br/><h2><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></h2><br/><br/>'; 
//echo dp_clean($post->post_content, 300).'[...]';
echo $post->post_content;
echo '<br /><br /><b>Commentaires : </b>'.$post->comment_count.' <b>Date : </b>'.$post->post_date.' <b>Tags :</b>';
the_tags(' ', ', ', '<br /><br />');
endwhile; else:
echo '';
endif;

//Reset Query
wp_reset_query();



$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
query_posts('posts_per_page=7&cat=6&paged=$paged');

//AUTRES POSTS 
if ( have_posts() ) : while ( have_posts() ) : the_post();
echo '<br/><hr/><br/><h2 class"title_blog"><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></h2>'; 
echo '<div class="metainfo">Ecrit par <b>'.get_the_author().'</b> le '.get_the_time('j F Y').'</div>';
//dp_attachment_image($post->ID, 'full', 'alt="'.$post->post_title.'"');   
//echo dp_clean($post->post_content, 300).'[...]';
echo $post->post_content;

echo '<a href="'.get_comments_link().'"><div style"clear:both"></div><b>Commentaires : </b>'.$post->comment_count.' </a><br /><b>Tags :</b>';
the_tags(' ', ', ', '<br /><br/>');
endwhile; 
next_posts_link('&laquo; Posts précédents');
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
    <?php get_sidebar('blog_pres'); ?>
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

</div>

<div class="clear"></div>
 <?php get_footer(); ?>
