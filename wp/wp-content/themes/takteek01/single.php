<?php get_header();?>
	<?php include ('sidebar1.php'); ?>
	<div id="content">
		<div id="postlink"><?php previous_post_link('&lsaquo; %link') ?> &mdash; <?php next_post_link('%link &rsaquo;') ?></div>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<div class="postmetadata-top"><small><?php the_date('M d Y'); ?> <?php edit_post_link(); ?><br />Filed In: <?php the_category(', '); ?></small></div>
			<?php the_content('Read more &rsaquo;'); ?>
			<div class="backtotop"><a href="#top">Back to Top</a></div>
			<div class="postmetadata-bottom"><small>Tags: <?php the_tags('', ', '); ?></small></div>
		</div>
		<?php endwhile; endif; ?>
		<?php comments_template(); ?>
	</div>
	<?php include ('sidebar2.php'); ?>
<?php get_footer();?>