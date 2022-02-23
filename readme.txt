=== WPT Custom Mo File ===
Contributors: wptranslationsteam, g3ronim0, fxbenard, pedromendonca
Tags: language, textdomain, translation, localization, internationalization
Donate link: https://paypal.me/wptranslations
Requires at least: 5.3
Tested up to: 5.9
Requires PHP: 7.2
Stable tag: 1.2.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

WPT Custom Mo File is a powerful translation plugin that helps you use your own translation .mo files. Simple as that.

== Description ==

WPT Custom Mo File is a free translation plugin that allows you to override and use your own translation files for any WordPress themes or plugins.

For one or any languages of your choice, select the WordPress languages, WPT Custom Mo File will automatically use your defined rules for those locales.

Built to integrate seamlessly with WordPress, WPT Custom Mo File is the solution that gives website owner complete control over their translations.

Thanks to [Pixabay](https://pixabay.com/en/wood-cube-abc-cube-letters-473703/) for the banner image.

== Installation ==

= Minimum Requirements =

* PHP version 7.2 or greater (PHP 7.3 or greater is recommended)
* MySQL version 5.0 or greater (MySQL 5.6 or greater is recommended)
* WPT Custom Mo File 1.1 requires WordPress 5.3 or greater

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don’t need to leave your web browser. To do an automatic install of WPT Custom Mo File, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type “WPT Custom Mo File” and click Search Plugins. Once you’ve found our translation plugin you can view details about it such as the point release, rating and description. Most importantly of course, you can install it by simply clicking “Install Now”.

= Manual installation =

The manual installation method involves downloading our translation plugin and uploading it to your webserver via your favourite FTP application. Check the documentation about [managing plugins](https://wordpress.org/support/article/managing-plugins/).

= Updating =

Automatic updates should work like a charm; as always though, ensure you backup your site just in case.

= Usage =

1. Select the textdomain in the list at *Tools > WPT Custom Mo File*
2. Select your language
3. Upload your custom `.mo` file
4. That's it. Enjoy your Custom Translations

== Frequently Asked Questions ==

= Can I use .po files? =

No, not yet. Until we implement this feature, we recommend you to use any gettext editor to create your .mo files. E.g. [Poedit](https://make.wordpress.org/polyglots/handbook/translating/glotpress-translate-wordpress-org/poedit/)

= Where can I get support or talk to other users? =

If you get stuck, you can ask for help in the [WPT Custom Mo File plugin Forum](https://wordpress.org/support/plugin/wpt-custom-mo-file).

= Will WPT Custom Mo File work with my theme and plugins? =

Yes, WPT Custom Mo File work with any WordPress theme and plugins.

= Will WPT Custom Mo File work with any languages? =

Yes, WPT Custom Mo File work with any WordPress supported languages.

= Where can I request new features, report bugs or contribute to the project? =

Bugs can be reported either in our support forum or preferably on the [WPT Custom Mo File GitHub repository](https://github.com/WP-Translations/wpt-custom-mo-file/issues).

= WPT Custom Mo File is awesome! Can I contribute? =

Yes you can! Join in on our [GitHub repository](https://github.com/WP-Translations/wpt-custom-mo-file) :)

== Screenshots ==

1. The slick but efficient WPT Custom Mo File settings panel.

== Changelog ==

= 1.2.1 - 22 Feb 2022 =
* Fix mime type according to WordPress core fileinfo mime type check.

= 1.2.0 - 22 Feb 2022 =
* Tested up to WP 5.9
* Minimum requirement: WP 5.3 and PHP 7.2
* Update assets
* Code review and fix coding standards

= 1.1.0 - 03 Jan 2018 =
* Change hook to override text domain
* Bugfix for PHP 7.x.x
* Update assets
* Change donation link

= 1.0.1 - 07 Sept 2016 =
* Add support for get_user_locale()

= 1.0.0 - 07 Sept 2016 =
* Initial Release
