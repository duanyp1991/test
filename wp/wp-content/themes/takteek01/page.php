<?php get_header();?>
	<?php include ('sidebar1.php'); ?>
	<div id="content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><?php the_title(); ?></h2>
			<?php edit_post_link(); ?>
			<?php the_content(); ?>
		</div>
		<?php endwhile; endif ?>
		<?php comments_template(); ?>
	</div>
	<?php include ('sidebar2.php'); ?>
<?php get_footer();?>