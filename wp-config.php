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
define('DB_NAME', 'underdogz');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '4dg?uVYV;-.G?5|UPSRP+4e>ik?kgn[[<S~lju{@;q-2tX_WtfNWm|guOIe~~Xh7');
define('SECURE_AUTH_KEY',  '$a|}mEX4_E],w_JIqpOfn0alO(py^:&/C|?i?5;R|T8 bQX]#J1l>2O~hj]%>pGF');
define('LOGGED_IN_KEY',    'l5;?I{7d<pi#qv%ohJk9QM14A!la;a.d9K1s%YI>o]dYaEZ<}n<|daMM/+djwei;');
define('NONCE_KEY',        'QU8WSl}o7C|&mQt _UfE&V8xN&<NI3t6%c0D5*MYi*/MbeXw+`0z[3!q@~eXP5w$');
define('AUTH_SALT',        '4qksC^_k1}CYL:;[1LPKcXNi4R3[4lPQWp=jgWzk8_28{0b>^-tQCcP<:9nF&QLW');
define('SECURE_AUTH_SALT', 'iNg9F%/YxZ]F8%xR.)o]iL{tGd0@<kNhjmCM*2vucuT]Vl:UBl9IL-SJ%[]yT4KT');
define('LOGGED_IN_SALT',   'u=Q;ml.09IusYZfQ>>T$vMgw;%3YNq]gv&DycmlzH!#=qELIZ|_l,Wq^,.4H;phP');
define('NONCE_SALT',       ']%d&E!~DNSMjhFa9_XJ8i,+~u7,Z=.mO.pU(2Ih MGlcgHX5fTi-qNY?lW*SO~`#');

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