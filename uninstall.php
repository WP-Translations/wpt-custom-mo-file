<?php

// If uninstall not called from WordPress exit
defined( 'WP_UNINSTALL_PLUGIN' ) or die( 'Cheatin&#8217; uh?' );

// Delete WPTCMF options
delete_option( 'wptcmf_options' );

// Delete WPTCMF uplaod dir
unlink( WP_UPLOAD_DIR . '/wpt-custom-mo-file/' );
