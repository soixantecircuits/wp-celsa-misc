<!-- begin featured -->
<div class="fwrapper">
<div class="featured-img">
	<div id="featured">
	<div class="featured">
		<?php 
		$tmp_query = $wp_query;
		query_posts('cat=' . get_cat_ID(dp_settings('featured')));
		if (have_posts()) :
		$first = true;
		while (have_posts()) : the_post();
		ob_start();
		?>
		<li<?php if ($first) echo ' class="first"'; ?>><a href="<?php the_permalink(); ?>"><?php dp_attachment_image($post->ID, 'full', 'alt="' . $post->post_title . '"'); ?></a></li>
		<?php
		$photos .= ob_get_clean();
		ob_start();
		?>
		<li<?php if ($first) echo ' class="first"'; ?>>
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<p><?php echo dp_clean($post->post_content, 300); ?></p>
			<a href="<?php the_permalink(); ?>" class="next">Lire la suite</a>
		</li>
		<?php
		$text .= ob_get_clean();
		$first = false;
		endwhile;
		endif;
		?>
		<ul class="photo">
		<?php echo $photos; ?>
		</ul>
		<ul class="text">
		<?php echo $text; ?>
		</ul>
	</div>
	</div>
</div>
</div>
<?php $wp_query = $tmp_query; ?>
<!-- end featured -->
