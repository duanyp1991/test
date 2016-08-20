<?php get_header();?>
	<?php include ('sidebar1.php'); ?>
	<div id="content">
		<div class="post"><h2>Search Results for "<font color="#ffffff"><?php the_search_query(); ?></font>"</h2></div>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<div class="postmetadata-top"><small><?php the_date('M d Y'); ?> <?php edit_post_link(); ?><br />Filed In: <?php the_category(', '); ?></small></div>
			<?php the_excerpt(); ?>
			<div class="backtotop"><a href="#top">Back to Top</a> | <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></div>
			<div class="postmetadata-bottom"><small>Tags: <?php the_tags('', ', '); ?></small></div>
		</div>
		<?php endwhile; ?>
		<?php else : ?>
			<div class="post"><p>Nothing found. Try something else.</p></div>
		<?php endif; ?>
		<div id="navlink">
			<?php posts_nav_link(' &mdash; ', '&lsaquo; Newer Posts', 'Older Posts &rsaquo;'); ?>
		</div>
	</div>
	<?php include ('sidebar2.php'); ?>
<?php get_footer();?>