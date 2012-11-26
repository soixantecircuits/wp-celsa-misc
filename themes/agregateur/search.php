<?php get_header(); ?>
	<!-- BEGIN content -->
	
	<div id="main-content" class="">
	<div id="content">
	
	<h2 class="title">Search Results for <strong><?php the_search_query(); ?></strong></h2>
	
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
	<p><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></p>
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
		<h2>Not Found</h2>
		<p>Sorry, but you are looking for something that is not here.</p>
	</div>
	<?php endif; ?>
	
	</div>
	<?php get_sidebar(); ?>
	</div>
	<!-- END content -->
<?php get_footer(); ?>