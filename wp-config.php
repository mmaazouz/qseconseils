<?php

define('FS_METHOD', 'direct');
define('FORCE_SSL_ADMIN', true);

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dbs8499346' );

/** Database username */
define( 'DB_USER', 'dbu2029658' );

/** Database password */
define( 'DB_PASSWORD', 'CBnZTbukvHZoLKQTuzgJ' );

/** Database hostname */
define( 'DB_HOST', 'db5010026419.hosting-data.io' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'V>3]HgsCm{%b6<Ca%4Fz|h(Yll_[]m>`sk;QSx$o$/[4.*j9i@EUv9(*?v;9]^M-' );
define( 'SECURE_AUTH_KEY',   'JCQ/tez|=`|9/^zMDE<rfluzt/J9fsab EXii+Ibgnd3C4U7j)[G}`]~:gqU>!i*' );
define( 'LOGGED_IN_KEY',     '_X{(d`p?k6dJS3:Z!8kXww89OIsA>NLtvaVQV[~fk6,x~:5v`&O1$A/g6<JlG:OQ' );
define( 'NONCE_KEY',         'o1oHN0KYgQT?w#}MT-1!>G24raYu;lSl!F0o6ZZW|XCE?q>vma=)KaA,dCtI%.}a' );
define( 'AUTH_SALT',         '3`6v*LXT8)pWu>M.EM%T4XTZMiV2$:h}_j#uQHQj8x4IdVWT:,Q.kU`$-IG=[PU-' );
define( 'SECURE_AUTH_SALT',  '-Ru9[:/~l0xI@`.uyv(CX.r^&Aq[a>y-DqKV`@eqEIUpN/yP?{{aC~mVdElo<m2Y' );
define( 'LOGGED_IN_SALT',    'yCy++HL09(vi^1iY@QI1e=JU_$lY/-gw)@xJx7D,Bz<PNuLO;KtI6J1=ccP^1NUR' );
define( 'NONCE_SALT',        '^7Rs?@*)dQnk.9U*p`_xWKw/e}-g$=0p>}Okq`(A^{As.t&x6Q,WScRV}xq`@GI+' );
define( 'WP_CACHE_KEY_SALT', '9D0AWD~O8<f93;4qG2P?m)xL_M_2tLP!<Uu312U`EF|Z#-R2v-5p0?[,IuUXXtrB' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'qCGSikez';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
