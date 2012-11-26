<?php
//-----------------------------------------------------------------------------
/*
Plugin Name: Sensitive Tag Cloud
Version: 1.4.1
Plugin URI: http://www.rene-ade.de/inhalte/wordpress-plugin-sensitivetagcloud.html
Description: This wordpress plugin provides a highly configurable tagcloud that shows tags depending of the current context.
Author: Ren&eacute; Ade
Author URI: http://www.rene-ade.de
Min WP Version: 2.3
*/
//-----------------------------------------------------------------------------
?>
<?php
  function stc_plugin_basename() {
    return plugin_basename(__FILE__);
  }
  include 'sensitive-tag-cloud/sensitive-tag-cloud.php';
?>