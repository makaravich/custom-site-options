=== Custom site options ===
Contributors: makaravich
Donate link: https://www.buymeacoffee.com/mcarena
Tags: options, settings, customization, admin
Requires at least: 4.7
Tested up to: 6.2
Stable tag: 0.0.1
Requires PHP: 7.4
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

The plugin allows you to easily create a settings page for your custom theme or plugin

== Description ==

The Custom site options plugin is a great tool for developers who need to quickly and easily create a settings page for their custom theme or plugin. This plugin allows you create a settings page with a few clicks of the mouse. You can customize the settings page to include any number of fields, such as text boxes, checkboxes, radio buttons, and more.
This plugin is a great way to quickly and easily create a settings page that is tailored to your specific needs. Additionally, it features a built-in validation system that ensures all the settings are valid before they are saved.


== Installation ==
= AUTOMATIC INSTALLATION (EASIEST WAY) =
* To do an automatic install of WP Tabs, log in to your WordPress dashboard, navigate to the Plugins menu and click
Add New.
* In the search field type “Custom site options”. Once you have found it you can install it by simply clicking
“Install Now” and then “Activate”.

= MANUAL INSTALLATION =

## Uploading in WordPress Dashboard
* Download custom-site-options.zip
* Navigate to the ‘Add New’ in the plugins dashboard
* Navigate to the ‘Upload’ area
* Select custom-site-options.zip from your computer
* Click ‘Install Now’
* Activate the plugin in the Plugin dashboard

## Using FTP
* Download custom-site-options.zip
* Extract the custom-site-options directory to your computer
* Upload the custom-site-options directory to the /wp-content/plugins/ directory
* Activate the plugin in the Plugin dashboard

= AFTER INSTALLATION =
* Go to the Custom Site Options section of the Dashboard of your site. Here you can see the list of options pages, that you created.
* Press the button Add Options record to create a new options page
* On the new page fill in necessary fields, such as the title of your options page, label for Save button, and others.
* Press the button with "+" to add a new field to your settings page.
* Fill in the properties of the field
* If needed add other fields
* Save the edits. After this, you will see your options page in the Settings section of your site's Dashboard.


== Frequently Asked Questions ==

= Which types of fields can I add on the created options page using this plugin? =

So far you can use the following types of fields:
* Text,
* Text area,
* Rich edit,
* Checkbox,
* Radio buttons,
* Select,
* Email,
* Password.

Other types will be added soon.

= How can I use values of saved fields? =

Use this snippet to get value of the field, called 'general-site-settings' for options page with slug 'main-font-size'
`<?php
 	$my_options = get_option( 'general-site-settings' );
 	echo $my_options['def_def_main-font-size'] ;
 ?>`

def_def_ - it's a prefix, which means default tab and default section of the settings. These features are not implemented yet.

== Screenshots ==

1. Screenshot of page where a user can edit an option page's fields and properties.
2. Example of created page with site's options.

== Changelog ==

= 0.0.1 =
* The first public version of the plugin

== Upgrade Notice ==

= 0.0.1 =
The first release