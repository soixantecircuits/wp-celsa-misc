<?php // Do not delete these lines
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>
			<p class="nocomments">This post is password protected. Enter the password to view comments.<p>
			<?php
			return;
		}
	}
/* This variable is for alternating comment background */
$oddcomment = 'comment1';
?>
<h2>Commentaires<?php comments_number('', ' (1)', ' (%)' );?></h2> 
<?php comments_number('<p>Pas de commentaires</p>', '', '' );?>
<?php if ($comments) : $first = true; ?>
<?php foreach ($comments as $comment) : ?>
<div class="<?php echo $oddcomment; ?><?php if ($first) { echo ' first'; $first = false; } ?>" id="comment-<?php comment_ID() ?>">
	<div class="commentdetails">
		<span class="commentauthor"><?php comment_author_link() ?></span>
		<?php if ($comment->comment_approved == '0') : ?>
		<em>Your comment is awaiting moderation.</em>
		<?php endif; ?>
		<span class="commentdate"><?php comment_date('F jS, Y') ?> at <?php comment_time() ?>
		&nbsp; &nbsp; <?php edit_comment_link('Editer Commentaires','',''); ?>
		</span>
	</div>
	<?php dp_gravatar(50, 'class="gravatar"'); ?>
  <div class="comment_text">
	<?php comment_text() ?>
  </div>
  <div class="clear"></div>
  <br/>
</div>
<?php endforeach; /* end for each comment */ ?>
<?php endif; ?>
<h2 id="respond">Laisser un commentaire</h2>
<?php if ('open' == $post->comment_status) : ?>
	<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
	<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
	<?php if ( $user_ID ) : ?>
	<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>
	<?php else : ?>
		<p><input size="36" type="text" name="author" /> Nom <span class="required">*</span></p>
		<p><input size="36" type="text" name="email" /> Email <span class="required">*</span></p>
		<p><input size="36" type="text" name="url" /> Site Web</p>
	<?php endif; ?>
		<p><textarea rows="12" cols="42" name="comment"></textarea></p>
		<p><button name="submit" type="submit" id="submit" tabindex="5">Envoyer votre commentaire</button>
		<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
		</p>
		<?php # do_action('comment_form', $post->ID); ?>
	</form>
	<?php endif; ?>
	<?php endif; ?>
