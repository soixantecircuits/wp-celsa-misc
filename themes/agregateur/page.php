<?php get_header(); ?>
	<!-- BEGIN content -->
	<div id="main-content" class="">
	<div id="content">
	
		<?php if (have_posts()) : the_post(); ?>
		<!-- begin latest -->
		<div class="latest single">
		<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><br>
		<?php the_content('Read More'); ?>
		<div class="break"></div></div>
		<!-- end latest -->
		
		<?php else : ?>
		<div class="notfound">
			<h2>Not Found</h2>
			<p>Sorry, but you are looking for something that is not here.</p>
		</div>
		<?php endif; ?>
		<div id="comments"><?php comments_template(); ?></div>
		
		
		
	</div>
	<?php get_sidebar(); ?>
	</div>
	<!-- END content -->
    <div class="clear" style="clear:both"></div>
<?php get_footer(); ?>
