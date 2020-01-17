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
define( 'DB_NAME', 'wp943' );

/** MySQL database username */
// define( 'DB_USER', 'wp943' );
define( 'DB_USER', 'root' );

/** MySQL database password */
// define( 'DB_PASSWORD', '6-S06S4p(U' );
define( 'DB_PASSWORD', 'csduo2004mysql' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'liduga6q1x3fmmsw5nhx3bo2orl9xux6dzfg9swgcd22ppic7iwhrmmfqxxrpmwk' );
define( 'SECURE_AUTH_KEY',  'a4l8iiro0g15ibnkul8t0lsgf1c32xo3bhbvyydvhw1dsuyyd811oihyj3chdiej' );
define( 'LOGGED_IN_KEY',    '8tk4lyuxwnwxyntwti6dqs2iyv795mjuglk1wyiqp4mowiqxakjdex7ugprb1cxi' );
define( 'NONCE_KEY',        'z9qiauhh1sgqi4gqsjwtbn5ht3ata9271zpxiwx9wifrunb6xrhenleb5a94knjg' );
define( 'AUTH_SALT',        'vqvkfbtztrzutd2mm5w0ppfhzgyjbs9xbw2llh5jivikrn5ujkfooidlbuoti0iq' );
define( 'SECURE_AUTH_SALT', '5o8pltzintybdk3udnxzzyvoxbpubawllxwny0smh94i3rpsxtxrsrjbjvi56ves' );
define( 'LOGGED_IN_SALT',   'w32xgy5qbjaxybbvom3puwv14wpps6xjf5rs294cmfkioyyaaf42xz49gq3jaabg' );
define( 'NONCE_SALT',       'u6kuqyp5ukdxfdj5gwig24bm1uz9nqfiljgowrq6nppff3x3pkystg9i5d8bzkgr' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpyb_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
