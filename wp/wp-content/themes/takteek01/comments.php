<?php // Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	if ( post_password_required() ) {
?>
<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
<?php
	return;
	}
	// add a microid to all the comments
	function comment_add_microid($classes) {
		$c_email=get_comment_author_email();
		$c_url=get_comment_author_url();
		if (!empty($c_email) && !empty($c_url)) {
		$microid = 'microid-mailto+http:sha1:' . sha1(sha1('mailto:'.$c_email).sha1($c_url));
		$classes[] = $microid;
	}
	return $classes;	
	}
	add_filter('comment_class','comment_add_microid');
	// show the comments
	if ( have_comments() ) :
?>
<?php if ( get_option( 'page_comments' ) ) : ?>
<div id="commentpages">
	<h2 class="commentpages">Comment Pages</h2>
	<div class="commentlinks"><?php paginate_comments_links(); ?></div>
</div>
<?php endif; ?>
<div id="comments">
<h2 class="comments">There are <font color="#ffffff"><?php comments_number('0 Comments', '1 Comments', '% Comments' );?></font> to "<font color="#ffffff"><?php the_title(); ?></font>"</h2>
<ul class="singlecomments" id="commentlist">
	<?php wp_list_comments(
		array(
			'avatar_size'=>48,
			'reply_text'=>'Reply'
		)
	); ?>
</ul>
</div>
<?php else : // this is displayed if there are no comments so far ?>
<?php if ('open' == $post->comment_status) :
	// If comments are open, but there are no comments.
	else : 
	// comments are closed 
	endif;
	endif; 
	if ('open' == $post-> comment_status) : 
	// show the form
?>
<?php if ( get_option( 'page_comments' ) ) : ?>
<?php endif; ?>
<div id="respond">
<?php cancel_comment_reply_link('Cancel Reply'); ?>
<h2 class="respond">Write a Comment</h2>
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
	<?php if ( $user_ID ) : ?>
	Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a> (<?php wp_loginout(); ?>)
	<?php else : ?>
	<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
	<label for="author">Name <?php if ($req) echo "(required)"; ?></label>
	<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
	<label for="email">Email <?php if ($req) echo "(required)"; ?></label></p>
	<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
	<label for="url">Website</label></p>
	<?php endif; ?>
	<div>
		<?php comment_id_fields(); ?>
		<input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" />
	</div>
	<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>
	<p><textarea name="comment" id="commentbox" cols="10" rows="10" tabindex="4"></textarea></p>
	<?php if (get_option("comment_moderation") == "1") { ?>
	<p><small><strong>Please note:</strong> Comment moderation is enabled and may delay your comment. There is no need to resubmit your comment.</small></p>
	<?php } ?>
	<input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
	<?php do_action('comment_form', $post->ID); ?>
</form>
<?php endif; ?>
</div>
<?php endif; ?>