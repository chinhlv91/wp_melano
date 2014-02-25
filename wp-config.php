<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_melano_new');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'mysql');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'L5,3kW[A8jIQC{y5q&T@k:uCAr78)LPj-r#fe/Ev0qCP(=w}i+NrS>Rv- i}x7qv');
define('SECURE_AUTH_KEY',  'OT81-kw2Go|zF6oEg) 4/T2wN(.-lA.AO+pquu 4DHoBk_@z[bMV_`3sX.}up]nm');
define('LOGGED_IN_KEY',    'G~)ZqTYg-K4[;!::aYxvV(-I09hr9=ORC57YJDB6W#Vj0Zsk`XRkuksV_i2cJ+**');
define('NONCE_KEY',        'fNDpnN7KU1PRLUhxh-CG=ea?x|qxyVX&&O[,Bp&X+7+l3r17vwe9FHsM7Cf-- *~');
define('AUTH_SALT',        '>n++B}jy@2[_m8rSye`N&qy4,:~=JN_s&h|uB:fPp]k.H|-ii4=Jm9v9N$!Pc2,/');
define('SECURE_AUTH_SALT', '?=bLTwo.Y|DnP+B-pz?^ |M3`D&5?0&j-y&P1cNQMQk(*+c-%cK;U [&1[(Wi6 x');
define('LOGGED_IN_SALT',   'RW0nD|!`;R30A.6c3,xqB((2)0eF+y 2NKz1!GItp)sNo[_f>FZs[l|V>$:%:{{W');
define('NONCE_SALT',       '-&{R,e{F=sj6H85J5l+-X]ltWX7}Ank%-38{Zv.#T`PE0F*NmO|DJ!L&`K^h*4Sf');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
