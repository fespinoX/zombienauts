=== WP Testimonial Widget ===
Contributors: starkinfo
Tags: testimonial, testimonial widget, testimonial with widget, simple testimonial, testimonial shortcode, testimonial with shortcode, quicktag, testimonial with slick slider
Requires at least: 4.0
Requires PHP : 5.5
Tested up to: 4.8
Stable tag: 3.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin is for creating testimonials & display using Widget & Shortcodes on front end side. You can select from different available jQuery effects to show testimonials.

== Description ==

Using WP Testimonial Widget, you are able to manage the testimonials for your website. You can specify the number of testimonials to be displayed on your site on page or post or in widget. You can also use quicktag to insert shortcode. You can also re-order the testimonial by drag and drop UI. Now you can categorized your testimonial by adding category in to it. CSS can be uploaded in back end by setting menu.

There is shortcode [swp-testimonial] available to add testimonials on post or page.


A few features:

* Manage your testimonials (Add, Edit, and Delete)
* Set number of testimonials to display
* Set number of words to display
* Fill the following information for each testimonial: Company Name, Author Name, Designation, Author Avatar, testimonial Category, Company URL, testimonial
* Display testimonial in sidebar using widget. Configure widget using different available options
* Add shortcode to display testimonials in page or post
* Option to select different display options
* Quicktag to add shortcode
* Add testimonial category
* Re-order testimonial using drag and drop
* Add Your Custom CSS in setting menu

<a href="http://www.starkdigital.net"><strong>Visit plugin site</strong></a>

== Installation ==

1. Upload `wp-testimonial-widget` zip to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place the short-code [swp-testimonial] with attributes like testimonials, order, etc. (To know more about how to add short-code please check the Help menu at admin side.)


== Frequently asked questions ==

= How do I add company name and website URL in plugin? =
1. Click on 'Add New'.
2. On the right sidebar you will get two text-box two add company name and website.

= How to display website URL on front end? =
1. In widget or in shortcode, if you have added value as company and website, it will assign URL to the company name.
2. Or if you have selected only website, it will display on front end.

= How to display only Testimonial and image? =
1. In widget or in shortcode, if you want to display selected fields. You can select any fields from widget or add any fields shortcode in "fields" attribute.

E.g. [swp-testimonial testimonials=2 fields='description,client_avtar']

== Screenshots ==

1. Manage testimonials
2. Widget options
3. Re order testimonial page
4. Help

== Changelog ==

= 3.0 =
* Replaced old slider with 'slick' slider.
* Added new parameters for shortcode and widget setting for slick slider configuration. eg.draggable,pauseOnHover etc.
* Delete older plugin and reinstall new plugin. Don't worry your data will not be deleted.

= 2.0 =
* Added more details to testimonial like designation, category, avatar.
* Added category option to categorized testimonial.
* Added re-order option for testimonial.
* Added custom css option.
* Delete older plugin and reinstall new plugin. Don't worry your data will not be deleted.

= 1.0.2 =
* Removed the wrongly committed files to wordpress.org
* Changed the icon in menu.
* Delete older plugin and reinstall new plugin. Don't worry your data will not be deleted.

= 1.0.1 =
* Added feature to order testimonial.
* Added quick tag in post editor to insert shortcode easily.

 == Upgrade Notice == 

* This is the major release for "WP Testimonial Widget". Please configure it manually to avoid unexpected behavior of a plugin. 