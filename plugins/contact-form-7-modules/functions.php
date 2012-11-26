<?php

add_action('admin_notices', 'contact_form_7_modules_gf');

function contact_form_7_modules_gf() {
	global $pagenow;

	if(!current_user_can('install_plugins')) { return; }

	$message = (int)get_option('cf7_modules_hide_gf_message');

	if(isset($_REQUEST['hide']) && $_REQUEST['hide'] == 'cf7_modules_gf_message') {
		$message = 2;
		update_option('cf7_modules_hide_gf_message', $message);
	}

	if($pagenow == 'admin.php' && isset($_REQUEST['page']) && $_REQUEST['page'] == 'wpcf7' && $message !== 2) {
	?>
	<div class="updated" style="font-size:1.2em">
		<a href="<?php echo add_query_arg('hide', 'cf7_modules_gf_message'); ?>" class="button alignright" style="font-style:normal; margin:.75em 0 .75em .75em;">Hide this message</a>
		<h2>Want to integrate your form with a newsletter?</h2>
		<a href="http://katz.si/4i"><img src="<?php echo plugins_url('constant-contact-logo.png', __FILE__); ?>" width="281" height="41" alt="Constant Contact Logo" style="margin:.75em 0 0;" /></a>
		<h4 style="margin:.75em 0; font-size:1.2em; font-weight:normal;">Don't have a Constant Contact account? <a href="http://katz.si/4i">Try Constant Contact for free</a> for 15 days!</h4>
		<p>The Contact Form 7 Constant Contact Module makes it <em>super-simple</em> to add your contacts to an email newsletter. Simply sign up for a free trial at Constant Contact, enter your details, and you're ready to rock.</p>
		<p class="submit"><a href="<?php echo admin_url('plugin-install.php?tab=plugin-information&amp;plugin=contact-form-7-newsletter&amp;TB_iframe=true&amp;width=600&amp;height=800'); ?>" class="button button-primary thickbox" style="display:inline-block; margin-bottom:1em; font-size:1em; line-height:1.2em; height:1.2em;" title="Install Contact Form 7 - Constant Contact Module">Add Newsletter Support</a><strong class="description"> - It&rsquo;s easy!</strong></p>
		<div class="clear"></div>
	</div>
	<?php
	}
}

add_filter( 'wpcf7_cf7com_links', 'contact_form_7_modules_links' );

function contact_form_7_modules_links($links) {
	return str_replace('</div>', ' - <a href="http://katz.si/gf?con=link" target="_blank" title="Gravity Forms is the best WordPress contact form plugin." style="font-size:1.2em;">Try Gravity Forms</a></div>', $links);
}

?>