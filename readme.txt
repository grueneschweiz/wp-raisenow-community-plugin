=== RaiseNow donation forms ===
Contributors: cyrillbolliger, phil8900, vdrouotmecom
Tags: donations, raisenow, fundraising
Requires at least: 4.9
Tested up to: 5.6.0
Stable tag: 1.7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add configurable RaiseNow donation forms using shortcode.
IMPORTANT: You need to have a contract with RaiseNow.

== Description ==

Integrating the LEMA or TAMARO widget from [RaiseNow](https://raisenow.com/)
could not be easier:
1) Install this plugin
1) Enter the API-key provided from RaiseNow in WordPress under `Settings` >
   `Online donations`
1) Edit the page where you want the donation form to appear, click the **Insert
   donation form** button and enter the amounts of your desire. That's it!

You may leave amount fields blank to reduce the number of choices.

Do you want to **configure** the widgets style or inject some custom
javascript? Just head over to the settings panel, the options page is waiting
for you.

**IMPORTANT:** You'll need to get a contract with
[RaiseNow](https://raisenow.com/), before you can use this plugin. Once you've
got the contract signed, [RaiseNow](https://raisenow.com/) will provide you your
API-Key.

== Installation ==

Same as any other standard WordPress plugin.

== Changelog ==

= 1.7.2 =
* Fix warning about deprecated string notation

= 1.7.1 =
* Fix PHP notice if shortcode misses amounts.
* Shortcode generator not fully visible on small screens.

= 1.7.0 =
* Support for italian donation forms.

= 1.6.0 =
* Define default amounts on settings page.
* Display shortcode on settings page.

= 1.5.0 =
* Allow variable number of amount fields.

= 1.4.2 =
* Fix form language for tamaro widget. Props to [@vdrouotmecom](https://wordpress.org/support/users/vdrouotmecom/) for reporting the bug.

= 1.4.1 =
* French translations. Many thanks to [@vdrouotmecom](https://wordpress.org/support/users/vdrouotmecom/) for contributing them. 

= 1.4.0 =
* Support to customize amounts with TAMARO widget
* Minor improvements

= 1.3.0 =
* Added support for the TAMARO widget
* Tested up to WordPress 5.6.0

= 1.2.1 =
* Fix: legacy forms showing amount 0

= 1.2 =
* Provide convenient interface to customize amounts

= 1.1 =
* Replace per form api-key with a global api-key
* Hide detailed error messages from non privileged users
* Cleanup translations
* Cleanup js dependencies

= 1.0 =
* Initial release

== Contribute ==

Thank you for contributing! Every pull request is highly appreciated.

= Setting up dockerized development environment

1. Clone or fork https://github.com/grueneschweiz/wp-raisenow-community-plugin

2. Start environment using Docker

```sh
docker-compose up -d
```

The first time you run this, it will take a few minutes to pull in the required
images. On subsequent runs, it should take less than 30 seconds before you can
connect to WordPress in your browser. (Most of this time is waiting for MariaDB
to be ready to accept connections.)

The `-d` flag backgrounds the process and log output. To view logs for a
specific container, use `docker-compose logs [container]`, e.g.:

```sh
docker-compose logs wordpress
```

Please refer to the [Docker Compose documentation][docker-compose] for more
information about starting, stopping, and interacting with your environment.

Log in to `/wp-admin/` with **Username** `wordpress` and **Password**
`wordpress`.
