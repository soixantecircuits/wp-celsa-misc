<?php
require( dirname(__FILE__) . '/../../../wp-config.php' );
wp_cache_init();
if ( isset( $_REQUEST['id'] ) ) {
    if ( rssFeederImportRssFeed( $_REQUEST['id'] ) )
        wp_die( __( 'Feed ID ' . $_REQUEST['id'] . ' successfully imported.' ), __( 'Import Successful' ) );
    else
        wp_die( __( 'Nothing imported: Feed ID ' . $_REQUEST['id'] . ' may not be setup correctly.' ), __( 'Import Error' ) );
} else {
    wp_die( __( 'Nothing imported: Feed ID not set.' ), __( 'Import Error' ) );
}
