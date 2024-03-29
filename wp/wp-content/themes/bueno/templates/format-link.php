<?php
/**
 * The template part for displaying link post format.
 *
 * @package bueno
 */
?>	
	<article id="post-<?php the_ID(); ?>" <?php post_class('post__holder'); ?>>

		<header class="post-header">

			<?php if ( is_single() ) { ?>
			<h1 class="post-title">
				<?php if ( function_exists('get_the_post_format_url') ) { ?>
					<a href="<?php echo esc_url( bueno_get_link_url() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				 <?php } else {
				?>
					<a href="<?php the_permalink(); ?>" title="<?php esc_attr_e('Permalink to:', 'bueno');?> <?php the_title(); ?>"><?php the_title(); ?></a>
				<?php
				 } ?>
			</h1>
			<?php } else { ?>
			<h4 class="post-title link">
				<?php if ( function_exists('get_the_post_format_url') ) { ?>
					<a href="<?php echo esc_url( bueno_get_link_url() ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				 <?php } else {
				?>
					<a href="<?php the_permalink(); ?>" title="<?php esc_attr_e('Permalink to:', 'bueno');?> <?php the_title(); ?>"><?php the_title(); ?></a>
				<?php
				 } ?>
				
			</h4>
			<?php } ?>

			<?php get_template_part('templates/post-meta'); ?>
			
		</header>
		
		
		<!-- Post Content -->
		<div class="post_content">
			<?php the_content( __( 'Continue reading', 'bueno' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'bueno' ), 'after' => '</div>' ) ); ?>
		</div>
		<!-- //Post Content -->
		<?php if( ( has_tag() ) && ( is_singular() ) ) { ?>
			<footer class="post-footer">
				<i class="icon-tags"></i> <?php the_tags('Tags: ', ' ', ''); ?>
			</footer>
		<?php } ?>
		
<!--//.post-holder-->  
</article>

<?php if ( is_single() && get_the_author_meta( 'description' ) ) {
	get_template_part( 'templates/post-author-bio' );
} ?>