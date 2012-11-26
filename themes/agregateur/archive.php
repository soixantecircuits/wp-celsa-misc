<?php get_header(); ?>
	<!-- BEGIN content -->
	<div id="main-content" class="">
	<div id="content">
	
	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h2 class="title">Archive for the <strong><?php single_cat_title(); ?></strong> Category</h2>
	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<h2 class="title">Posts Tagged <strong><?php single_tag_title(); ?></strong></h2>
	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h2 class="title">Archive for <?php the_time('F jS, Y'); ?></h2>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h2 class="title">Archive for <?php the_time('F, Y'); ?></h2>
	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h2 class="title">Archive for <?php the_time('Y'); ?></h2>
	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h2 class="title">Author Archive</h2>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h2 class="title">Blog Archives</h2>
	<?php } ?>
	
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
