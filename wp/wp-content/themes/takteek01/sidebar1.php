<div id="sidebar1wrap">
	<div id="sidebar1">
		<h2>Essentials</h2>
		<h2 class="small">Meta</h2>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
		</ul>
		<h2 class="small">Pages</h2>
		<ul>
			<li><a href="<?php bloginfo('url'); ?>">Home</a></li>
			<?php wp_list_pages('title_li='); ?>
		</ul>
		<h2 class="small">Categories</h2>
		<ul>
			<?php wp_list_categories('title_li=&orderby=name'); ?>
		</ul>
		<ul>
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar1') ) : ?><?php endif; ?>
		</ul>
	</div>
</div>