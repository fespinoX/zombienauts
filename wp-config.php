<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'zombienauts');

/** MySQL database username */
define('DB_USER', 'zombienaut');

/** MySQL database password */
define('DB_PASSWORD', '1234');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'CUs44Y.dyIn&nqhN;>/?rGW28s{r~4ysc6<#;+i~.4xe>^ kHSq(~C_u{kjTl[%9');
define('SECURE_AUTH_KEY',  '?(<cwfB!zI~b3DY7*(6F=shDSDD2&Ip(cJIa>h+`vEA`kJq>M<=?bCx~}k8-PaM$');
define('LOGGED_IN_KEY',    'LfsPu[mfyUJvt*q`lPa}<7chSXZ(Qh%jcUkt;=U=r e,ExA2`&y?+utzzIyd k $');
define('NONCE_KEY',        '3uV=X4xws-Ivm@CqBcB`fvf8Tb[XN6s=|E9(}uSi?dXV,O1X`}PQ*PAYdxpTG;Zo');
define('AUTH_SALT',        'fUp}enw2o(|-g&]X0jW5Gtlh-jQ33EOP8`Zqy>9eRpW^5dT?f/g_2B9s9>Wy!G#!');
define('SECURE_AUTH_SALT', '1)u1Ze?]11sMAH!Dl%sSq#:Rve,:e6e0Hw#=e}045hj#nf^g1a-#EmFV);_LklJP');
define('LOGGED_IN_SALT',   'XY@em4tNl=HqDcG&0vcP|.wzuX{R,f{*(Vf##%!+jVFLHSOLaJ3y:@I18VxA$jjm');
define('NONCE_SALT',       '{?[)1.h|5>Tgk*Q>iR$i}s[uQqUZPq`fv{F>7;l(33j|?D%%~}fLS@0n#G9H9Njw');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
