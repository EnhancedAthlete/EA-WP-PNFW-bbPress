
[![WordPress tested 5.2](https://img.shields.io/badge/WordPress-v5.2%20tested-brightgreen)](https://wordpress.org/plugins/ea-wp-pnfw-bbpress) [![PHPCS WPCS](https://img.shields.io/badge/PHPCS-WordPress%20Coding%20Standards-brightgreen)](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) [![License: GPL v2 or later](https://img.shields.io/badge/License-GPL%20v2%20or%20later-blue.svg)](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html) [![PHPUnit ](https://img.shields.io/badge/PHPUnit-91%25%20coverage-28a745.svg)]()

# EA WP PNFW bbPress

A [WordPress](https://wordpress.org/) plugin to send [bbPress](https://bbpress.org/) forum reply notifications through Delite Studio's [Push Notifications for WordPress](https://products.delitestudio.com/wordpress/push-notifications-for-wordpress/) plugin.

## Installation

Download the latest release. Add it as a plugin in your WordPress install.

The paid version of Delite Studio's [Push Notifications for WordPress](https://products.delitestudio.com/wordpress/push-notifications-for-wordpress/) plugin is required.

There is no configuration necessary.

This plugin is not presently in the WordPress plugin directory.

## Operation

This plugin hooks into the bbPress action `bbp_post_notify_subscribers` and sends notifications using the `pnfw_send_notification()` function to anyone who has ticked "Notify me of follow-up replies via email".

The notification sent contains the title "New reply to Topic Title" and has a `user_info` array with `link` containing the link to the reply.


### Filters

The message title and the user_info array can be modified with filters.

```
add_filter( 'bbp_post_notify_subscribers_pnfw_message', 'my_pnfw_message', 10, 4);

/**
 * @param string	$message		The title of the push notification.
 * @param int 		$reply_id		The reply id.
 * @param int 		$topic_id		The topic the reply is to.
 * @param int 		$user_id		The user the message is being sent to.
 *
 * @return string
 */
function my_pnfw_message( $message, $reply_id, $topic_id, $user_id ) {
	
	...

	return $message;
}
```

```
add_filter( 'bbp_post_notify_subscribers_pnfw_message', 'my_pnfw_user_info', 10, 4);

/**
 * @param array		$user_info		The user_info array being sent with the message.
 * @param int 		$reply_id		The reply id.
 * @param int 		$topic_id		The topic the reply is to.
 * @param int 		$user_id		The user the message is being sent to.
 *
 * @return array
 */
function my_pnfw_user_info( $user_info, $reply_id, $topic_id, $user_id ) {

	...
	
	return $user_info;
}
```

## Develop

To install [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer), the  [WordPress Coding Standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards), [WP_Mock](https://github.com/10up/wp_mock) (and its [PHP Unit 7](https://github.com/sebastianbergmann/phpunit) dependency) and wordpress-develop testing environment run:

```
composer install
```

### Symlinks

A symlink to the Composer installed bbPress in `vendor` needs to be created in `wp-content/plugins` (where [WordPress Packagist](https://wpackagist.org/) plugins are conventionally installed).

```
ln -s ../../vendor/bbpress/bbpress/src ./wp-content/plugins/
```

```
mv wp-content/plugins/src wp-content/plugins/bbpress
```

I also like to add WordPress itself in the project root directory.

```
ln -s vendor/wordpress/wordpress/ .
```

### WordPress Coding Standards

To see WordPress Coding Standards errors run:

```
vendor/bin/phpcs
```

To automatically correct them where possible run:

```
vendor/bin/phpcbf
```

### WP_Mock Tests

WP_Mock tests can be run with:

```
phpunit -c tests/wp-mock/phpunit.xml
```

### WordPress-Develop Tests

The wordpress-develop tests are configured to require a local [MySQL database](https://dev.mysql.com/downloads/mysql/) (which gets wiped each time) and this plugin is set to require a database called `wordpress_tests` and a user named `wordpress-develop` with the password `wordpress-develop`. 

To setup the database, open MySQL shell:

```
mysql -u root -p
```

Create the database and user, granting the user full permissions:

```
CREATE DATABASE wordpress_tests;
CREATE USER 'wordpress-develop'@'%' IDENTIFIED WITH mysql_native_password BY 'wordpress-develop'
GRANT ALL PRIVILEGES ON wordpress_tests.* TO 'wordpress-develop'@'%';
```

```
quit
```

The wordpress-develop tests can then be run with:

```
phpunit -c tests/wordpress-develop/phpunit.xml 
```

### Code Coverage

Code coverage reporting requires [Xdebug](https://xdebug.org/) installed.

### All Together

To fix WPCS fixable errors, display the remaining, run WP_Mock and WordPress-develop test suites and output code coverage, run:

```
vendor/bin/phpcbf; 
vendor/bin/phpcs; 
phpunit -c tests/wordpress-develop/phpunit.xml --coverage-php tests/reports/wordpress-develop.cov  --coverage-text; 
phpunit -c tests/wp-mock/phpunit.xml --coverage-php tests/reports/wp-mock.cov --coverage-text; 
vendor/bin/phpcov merge --clover tests/reports/clover.xml --html tests/reports/html tests/reports --text
```

Code coverage will be output in the console, and as HTML under `/tests/reports/html/`.

## TODO

* Logging
* Change "Notify me of follow-up replies via email" to "Notify me of follow-up replies"

## Acknowledgements

Built by [Brian Henry](https://BrianHenry.ie) using [WordPress Plugin Boilerplate](https://wppb.me/) and [WP Mock](https://github.com/10up/wp_mock) for:

[![Enhanced Athlete](./assets/Enhanced_Athlete.png "Enhanced Athlete")](https://EnhancedAthlete.com)