# WPT Custom Mo File

WPT Custom Mo File is a powerful translation plugin that helps you use your own translation .mo files. Simple as that.

[![WordPress Plugin Version](https://img.shields.io/wordpress/plugin/v/wpt-custom-mo-file?label=Plugin%20Version&logo=wordpress)](https://wordpress.org/plugins/wpt-custom-mo-file/)
[![WordPress Plugin Rating](https://img.shields.io/wordpress/plugin/stars/wpt-custom-mo-file?label=Plugin%20Rating&logo=wordpress)](https://wordpress.org/support/plugin/wpt-custom-mo-file/reviews/)
[![WordPress Plugin Downloads](https://img.shields.io/wordpress/plugin/dt/wpt-custom-mo-file.svg?label=Downloads&logo=wordpress)](https://wordpress.org/plugins/wpt-custom-mo-file/advanced/)

[![WordPress Plugin Required PHP Version](https://img.shields.io/wordpress/plugin/required-php/wpt-custom-mo-file?label=PHP%20Required&logo=php&logoColor=white)](https://wordpress.org/plugins/wpt-custom-mo-file/)
[![WordPress Plugin: Required WP Version](https://img.shields.io/wordpress/plugin/wp-version/wpt-custom-mo-file?label=WordPress%20Required&logo=wordpress)](https://wordpress.org/plugins/wpt-custom-mo-file/)
[![WordPress Plugin: Tested WP Version](https://img.shields.io/wordpress/plugin/tested/wpt-custom-mo-file.svg?label=WordPress%20Tested&logo=wordpress)](https://wordpress.org/plugins/wpt-custom-mo-file/)

[![Coding Standards](https://github.com/WP-Translations/wpt-custom-mo-file/actions/workflows/coding-standards.yml/badge.svg)](https://github.com/WP-Translations/wpt-custom-mo-file/actions/workflows/coding-standards.yml)
[![Static Analysis](https://github.com/WP-Translations/wpt-custom-mo-file/actions/workflows/static-analysis.yml/badge.svg)](https://github.com/WP-Translations/wpt-custom-mo-file/actions/workflows/static-analysis.yml)

## Description

WPT Custom Mo File is a free translation plugin that allows you to override and use your own translation files for any WordPress themes or plugins.

For one or any languages of your choice, select the WordPress languages, WPT Custom Mo File will automatically use your defined rules for those locales.

Built to integrate seamlessly with WordPress, WPT Custom Mo File is the solution that gives website owner complete control over their translations.

Thanks to [Pixabay](https://pixabay.com/en/wood-cube-abc-cube-letters-473703/) for the banner image.

## Installation

### Minimum Requirements

* PHP version 7.2 or greater (PHP 7.3 or greater is recommended)
* MySQL version 5.0 or greater (MySQL 5.6 or greater is recommended)
* WPT Custom Mo File 1.2 requires WordPress 5.3 or greater

### Automatic installation

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don’t need to leave your web browser. To do an automatic install of WPT Custom Mo File, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type “WPT Custom Mo File” and click Search Plugins. Once you’ve found our translation plugin you can view details about it such as the point release, rating and description. Most importantly of course, you can install it by simply clicking “Install Now”.

### Manual installation

The manual installation method involves downloading our translation plugin and uploading it to your webserver via your favourite FTP application. Check the documentation about [managing plugins](https://wordpress.org/support/article/managing-plugins/).

### Updating

Automatic updates should work like a charm; as always though, ensure you backup your site just in case.

### Usage

1. Select the textdomain in the list at *Tools > WPT Custom Mo File*
2. Select your language
3. Upload your custom `.mo` file
4. That's it. Enjoy your Custom Translations

## Frequently Asked Questions

### Can I use .po files?

No, not yet. Until we implement this feature, we recommend you to use any gettext editor to create your .mo files. E.g. [Poedit](https://make.wordpress.org/polyglots/handbook/translating/glotpress-translate-wordpress-org/poedit/)

### Where can I get support or talk to other users?

If you get stuck, you can ask for help in the [WPT Custom Mo File plugin Forum](https://wordpress.org/support/plugin/wpt-custom-mo-file).

### Will WPT Custom Mo File work with my theme and plugins?

Yes, WPT Custom Mo File work with any WordPress theme and plugins.

### Will WPT Custom Mo File work with any languages?

Yes, WPT Custom Mo File work with any WordPress supported languages.

### Where can I request new features, report bugs or contribute to the project?

Bugs can be reported either in our support forum or preferably on the [WPT Custom Mo File GitHub repository](https://github.com/WP-Translations/wpt-custom-mo-file/issues).

### WPT Custom Mo File is awesome! Can I contribute?

Yes you can! Join in on our [GitHub repository](https://github.com/WP-Translations/wpt-custom-mo-file) :)

## Changelog

### Unreleased

* Tested up to WP 6.1

### 1.2.2 - 25 May 2022

* Tested up to WP 6.0
* Search only .mo files on upload file field
* Fix PHP notice on new v1.2.1 install

### 1.2.1 - 22 Feb 2022

* Fix mime type according to WordPress core fileinfo mime type check

### 1.2.0 - 22 Feb 2022

* Tested up to WP 5.9
* Minimum requirement: WP 5.3 and PHP 7.2
* Update assets
* Code review and fix coding standards

### 1.1.0 - 03 Jan 2018

* Change hook to override text domain
* Bugfix for PHP 7.x.x
* Update assets
* Change donation link

### 1.0.1 - 07 Sept 2016

* Add support for get_user_locale()

### 1.0.0 - 07 Sept 2016

* Initial Release
