<div id="sidebar2wrap">
	<div id="sidebar2">
		<h2>Shortcuts &amp; Links</h2>
		<h2 class="small">Search</h2>
		<ul>
			<li><?php include ('searchform.php'); ?></li>
		</ul>
		<h2 class="small">Latest Posts</h2>
		<ul>
		<?php
		$args=array(
		'showposts'=>5,
		'caller_get_posts'=>1
		);
		$my_query = new WP_Query($args);
		if( $my_query->have_posts() ) {
		while ($my_query->have_posts()) : $my_query->the_post(); ?>
			<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><small><?php the_time('M d Y') ?></small><br /><?php the_title(); ?></a></li>
		<?php endwhile; } ?>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar2') ) : ?><?php endif; ?>
		</ul>
	</div>
</div>