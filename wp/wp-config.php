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
define('DB_NAME', 'wordpress_stable');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'EIVkDihAwm42f96RlaZPqcWCPXseEsEzhqc');

/** MySQL hostname */
define('DB_HOST', '127.0.0.1:3308');

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
define('AUTH_KEY',         'ZJU]`d*P`4+#jcgoe7S$L6|gB2b<i>:C;ly=Q <YMS{1brBnz@<Ryj/~Q:A$65J5');
define('SECURE_AUTH_KEY',  '?3/5bglT3&St#CPJQQ^ 3y[|zxM| ;PbE,}:)hvm2N,To?<,MbRC +]>;qU%Y|4L');
define('LOGGED_IN_KEY',    'nu@krKN:|u0rJ:m2r:$Agl+.,GCF1{^-(rsUe0NM=kmqd|9y)<=Nuq+%[j|~hv(e');
define('NONCE_KEY',        ':>VsyXHRE>aZ}/@JXR<M}CM`$s-F <e#|Yd:k=u|PIlmQL+,X<=ql[{EOWcvDN-{');
define('AUTH_SALT',        '(},|m7M -$#{~Wo1ucj+j2p}A-4@z~|{(+KA:?[]G]a+8<trA_?I(,-iB@ /0-He');
define('SECURE_AUTH_SALT', '4h^^ Z4IK_PqhCFhsh,60 ?}$UQ|>3+7OW|(O~E;|>`:rn-oOo&,FXz*Nuy{(QAV');
define('LOGGED_IN_SALT',   '%-b1|-3Wp5dx-HJ]!$xV}Mg|1aHTOH3qZBphhI`1Nl:HyO?|j^DV%^04wI?cEBc-');
define('NONCE_SALT',       'gM#+o3y-Z?CSnMG,iD-y;~[rF6VDJYZC2L|t+#nqbvq!`L6z=?C]/wq;+i i7uq<');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'mmx_';

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

define('WP_HOME', 'https://blog.sparkmodel.com');
define('WP_SITEURL','https://blog.sparkmodel.com');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
