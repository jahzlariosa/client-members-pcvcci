<?php
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
define( 'DB_NAME', 'pcvcci-members' );

/** Database username */
define( 'DB_USER', 'pcvcci-members' );

/** Database password */
define( 'DB_PASSWORD', '7C2UYMNZHAYcrPtEVWZP' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1:3306' );

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
define( 'AUTH_KEY',          'bc0V]3d@XZ]dbgsSVB=LnKx/xP_ka1,mi8wc?=7L<X8FPZ3IE0x4ziBT#Rjr@g]c' );
define( 'SECURE_AUTH_KEY',   'yd4<@kACZy$H<7k?D!T$V2 NTmWkk%zL`LbLV9wO)dZ1Z|JR)e4B+={F|(<W<)9m' );
define( 'LOGGED_IN_KEY',     '(HUvp_IX[D0MVl^/fa&$$o>+!s/DyeOoxVr:6J&J#zEfQ+YV>DnU*uJ;&fC%e4oc' );
define( 'NONCE_KEY',         '|9NUU1~3K|js8ZG7a0r;0H:X=)%I{!$k,nD9w5dfL3Ni)n4,O? obJ/IEz#aG#zP' );
define( 'AUTH_SALT',         'B$E[ZrjIC6_D/Zf FTx8u_![x-h/bout9<YK*pbqN Q`>wxghp,|E;Zt+E KGSSI' );
define( 'SECURE_AUTH_SALT',  'dG{bMt7^&w?~Xt1tJ^rBtI&mK)/BDelW$y=[7ovUdVj@y1Iznw(t*uUt]W$VbtOz' );
define( 'LOGGED_IN_SALT',    '3mE^#G$w{wm3=^QO2Muk ^vkk3>q,Sj)L!]:{]|ae=*n%&`+k=iam+&`)TA|rq6Y' );
define( 'NONCE_SALT',        '?cMD(EE<u*BGLc%>Rt6,`>-y*+j;bs5*WlEAc!P}T_4~I83%e~5)*D0S}/Z=}[D0' );
define( 'WP_CACHE_KEY_SALT', ';6;K.pnu+e]53.08w|69vYSEbh%?K&sPgI|Zk6XW1[2j8^?yACLOaKX$40kxtmsC' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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



define( 'FS_METHOD', 'direct' );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', true );
define( 'CONCATENATE_SCRIPTS', false );
define( 'AUTOSAVE_INTERVAL', 600 );
define( 'WP_POST_REVISIONS', 5 );
define( 'EMPTY_TRASH_DAYS', 21 );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
