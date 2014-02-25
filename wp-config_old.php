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
define('AUTH_KEY',         '*$B.v`:m89&b1jAnHIg1rkOR7*7bYzDBMn|_P&e#e?F3I?;?kw1`JA8~3p2X-q)j');

define('SECURE_AUTH_KEY',  '.+c]+.nEOz:Xt~VA:Ql##PW-E: 6(#r;AIeUJOQob+4-4?r<OayKr=f|Gmnb@-L/');

define('LOGGED_IN_KEY',    'Nc+aBwj`r]E`<L UpE{LEa-h8F]|DL[)dO(m~x4b<v0}UNj@[Z|^()D`yF#~ys-w');

define('NONCE_KEY',        'Ht^[<Km8sg[6W`LBX#Q-6M!)X%+)EaC;||Iki4}i-0^cxnp|C(v6&G&h[1tG:DB+');

define('AUTH_SALT',        'gaTQ+.WBvJD6xAD H*Z.)  0{;tY{C!t=txQJcu$i9w-P`p;_l(I8z%x@t]4sPh_');

define('SECURE_AUTH_SALT', '$g)-[8HJy]e3~A$F*.[1p^EV{RHJLz<(L+yOS5N+*Hj0uyj.z-|j|AOc<11U@8kV');

define('LOGGED_IN_SALT',   'o12B#-zmt%10d;FF5YgY|6-tk7/WoEuMlFPKdyM|1b:Hi)?unBU|pemj+-xwL|K%');

define('NONCE_SALT',       '|.Om)+fDKWqr,=jOP+[ZA2w6X0/78()2b{<$ZDu,[6n11]/Y^)o-tj_|c4LQ>g8:');


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
