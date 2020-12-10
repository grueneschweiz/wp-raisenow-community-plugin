# RaiseNow donation forms #
**Contributors:** [cyrillbolliger](https://profiles.wordpress.org/cyrillbolliger), [phil8900](https://github.com/phil8900/)
**Tags:** donations, raisenow, fundraising  
**Requires at least:** 4.9  
**Tested up to:** 5.6
**Stable tag:** 1.2.1
**License:** GPLv2 or later  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html  

Add configurable RaiseNow donation forms using shortcode.
**IMPORTANT:** You need to have a contract with RaiseNow.  

## Description ##

Integrating the LEMA or TAMARO widget from [RaiseNow](https://raisenow.com/) could not be easier: Just install this plugin,
edit the page where you want the donation form to appear, click the **Insert donation form** button and enter the
API-key provided from RaiseNow. That's it!

You may want to **configure** the widgets style or inject some custom javascript? Just head over to the settings panel,
the options page is waiting for you.

**IMPORTANT:** You'll need to get a contract with [RaiseNow](https://raisenow.com/), before you can use this plugin.
Once you've got the contract signed, [RaiseNow](https://raisenow.com/) will provide you your API-Key.

## Installation ##

Same as any other standard WordPress plugin.

## Changelog ##

### 1.2.1 ###
* Fix: legacy forms showing amount 0 

### 1.2 ###
* Provide convenient interface to customize amounts

### 1.1 ###
* Replace per form api-key with a global api-key
* Hide detailed error messages from non privileged users
* Cleanup translations
* Cleanup js dependencies

### 1.0 ###
* Initial release

## Contribute ##

Thank you for contributing! Every pull request is highly appreciated.

### Setting up dockerized development environment

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

Log in to `/wp-admin/` with **Username** `wordpress` and **Password** `wordpress`.
###