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
define('DB_NAME', 'WPmagazin');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '198993');

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
define('AUTH_KEY',         'dc[A9_Xh`ty Y]PTKOI(#.Fq`C/7n8knl`*CK4cGG&~-/h.frq[`y9KR&[35G$!+');
define('SECURE_AUTH_KEY',  'D,V?4styX?Ir PFeXa%4qCl df<RGNPFBAIlEE1Y(gW/MQWrHZ S_k7$QEO@nKb/');
define('LOGGED_IN_KEY',    'ET)pwYK,XM!`~9u9lHvgww0XxGM9iyY/ ;*BlLuc%&f;Osye*12Ku$p~-4&XRw#n');
define('NONCE_KEY',        ']w4U#AsT-r?[b^odW_`AyGvB{jSG*46{ni|.5>;p6y:9<|f}.+2SstE9+9BdQ)(z');
define('AUTH_SALT',        '2-=pJ(2M6e^kRMJl?th<^*>ni@p9srxtV/i2iqJinlylxIjQhX!lJ]S;|r*`}kW2');
define('SECURE_AUTH_SALT', 'r([$gt7s)pN{V|G>%.nqK}Oq!~wQU*9r+~boO3K6(IHr$|<iA#MRk4Q5{:a5;;{9');
define('LOGGED_IN_SALT',   ' U ^)#nGtX[D;7c/2+ejs5-k0w4iNkI3wxNAy6m=.$n~X|yqL<hPa~l}eiRM]6*4');
define('NONCE_SALT',       'jF>tX1Cwk3Zdi$Hej)XR>[qKr:l}0-5f[@}=U.6Usonj+^%/-&jv0pzfN3yE(9+B');

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
