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
define('DB_NAME', 'soucatolico');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '89Hgs^$14b@qQ0bzirX>Xc$1h`~t,c(dHgm_W%jg#?E*O6gt<Q;e|MM/MBL(e`Qq');
define('SECURE_AUTH_KEY',  'hdx%A#aX3XTL|h=2oEk4ON}sLB`7*7u@U/,kT0rt=D>q$YmAi?+miFYUJV>$zekQ');
define('LOGGED_IN_KEY',    '>N*vH|]m&e3]^)10dAsl*7(?wG+/;4oabVNdSau_a7?IEhE.;&X{:9mc|1X-%Vr=');
define('NONCE_KEY',        ' bs*-eB1}KRe3V;z_,p*DqbHAJH`+D}gVwju+k=POqt4?JPwk*?0hlRy*I>6z`hI');
define('AUTH_SALT',        'm>ns:Id%5iJO,-AZaC;?a]4#@1P-4Ny>Iy4Q(*j?5-pX7:v,Kgqr (agL>M-p[Yp');
define('SECURE_AUTH_SALT', '9s}Lj+m [*xdlJTK5lcU1t>0oKS!^`G7X|$PW_auSxuE;LT|dI{I[-TG75fZ>i8f');
define('LOGGED_IN_SALT',   '|Ug2ijiP+8,Y`ZKls]jp,kCjf{7#}.%[JY?o}FQpnX7.[U}*V!Fg@]%]:77y3J=C');
define('NONCE_SALT',       ';D#rPKU2rFEZ_PVpdtt}r]!}fW2w$wW@W2c4:TF@B_mYez>T-_|f}N]qF9%9ml}c');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'sc_';

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
