<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="shortcut icon" href="" type="image" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php 
	global $options;
	foreach ($options as $value) {
	if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } 
	else { $$value['id'] = stripslashes(get_settings( $value['id'] )); } 
	} ?>
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
</head>
<body>
<a name="top"></a>
<div id="header">
	<div id="topbar"><strong><a href="<?php bloginfo('url'); ?>" class="title"><?php bloginfo('name'); ?></a></strong> | <?php bloginfo('description'); ?></div>
	<div><table border="0" cellpadding="0" cellspacing="0" id="banner">
	<tbody>
		<tr>
			<td>
			<?php if ($takte_headerimage_toggle=="Toggle On") : ?>
				<img src="<?php echo $takte_headerimage; ?>" width="<?php echo $takte_headerimage_width; ?>" height="<?php echo $takte_headerimage_height; ?>" alt="<?php echo $takte_headerimage_alt; ?>" title="<?php echo $takte_headerimage_alt; ?>" />
			<?php endif; ?>
			<?php if ($takte_headertext_toggle=="Toggle On") : ?>
				<h1><?php echo $takte_headertext; ?></h1>
			<?php endif; ?>
			<?php if ($takte_headerimage_toggle=="Toggle On" && $takte_headertext_toggle=="Toggle On") : ?>
				<style type="text/css">#banner h1 {	margin-top: 20px; }</style>
			<?php endif; ?>
			</td>
		</tr>
	</tbody>
	</table></div>
</div>
<div id="contentwrap">