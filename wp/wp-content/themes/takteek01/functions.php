<?php
	if ( function_exists('register_sidebar') )
		register_sidebar(array('name'=>'sidebar1',
		'before_title' => '<h2 class="small">',
		'after_title' => '</h2>',
	));
	register_sidebar(array('name'=>'sidebar2',
		'before_title' => '<h2 class="small">',
		'after_title' => '</h2>',
	));
	require_once('controlpanel.php');
?>