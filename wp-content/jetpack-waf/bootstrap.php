<?php
define( 'DISABLE_JETPACK_WAF', false );
if ( defined( 'DISABLE_JETPACK_WAF' ) && DISABLE_JETPACK_WAF ) return;
define( 'JETPACK_WAF_MODE', 'normal' );
define( 'JETPACK_WAF_SHARE_DATA', '1' );
define( 'JETPACK_WAF_DIR', '/homepages/44/d922533528/htdocs/clickandbuilds/QSEconseils/wp-content/jetpack-waf' );
define( 'JETPACK_WAF_WPCONFIG', '/homepages/44/d922533528/htdocs/clickandbuilds/QSEconseils/wp-content/../wp-config.php' );
require_once '/homepages/44/d922533528/htdocs/clickandbuilds/QSEconseils/wp-content/plugins/jetpack-protect/vendor/autoload.php';
Automattic\Jetpack\Waf\Waf_Runner::initialize();
