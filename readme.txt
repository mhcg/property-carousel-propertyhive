=== Property Carousel for Property Hive ===
Contributors: markheydon
Donate link: http://bit.ly/mhcg-open-source-project-donation
Tags: estate agent, property, carousel, propertyhive, property carousel
Tested up to: 4.9.8
Requires at least: 4.7
Requires PHP: 5.6
Stable tag: 1.0.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

Property Hive extension to add a carousel feature.

== Description ==

This is an add-on to the popular Property Hive (Estate agency software for WordPress).  As such it needs the
Property Hive plugin as well to work.  The plugin has been written by a 3rd party with no affiliation to the authors
of the Property Hive plugin.

Full full details of the Property Hive plugin see one of the following links.

* [Property Hive for WordPress Homepage](https://wp-property-hive.com/)
* [Property Hive on GitHub](https://github.com/propertyhive/WP-Property-Hive)

This plugin adds a basic carousel feature allowing you to put a shortcode on any page or post to showcase either
all properties or featured (or not) properties.  Properties are displayed from a random selected of no more than 10.

= Example Usage =

`[property_carousel featured="yes"]`

`[property_carousel featured="yes" department="residential-sales"]`

= Supported Shortcode Attributes =

**featured** - Featured (or not), or blank for all, i.e. "yes", "no" or "".

**department** - Department, one of "residential-sales", "residential-lettings" or "commercial".

**office_id** - Office ID.

== Frequently Asked Questions ==

= Will this plugin work without any styling? =

The short answer is yes.  The plugin works out of the box (so long as Property Hive is also installed), however it
is highly likely some CSS styling will be required to make the carousel match the site it is installed on.

== Changelog ==

= 1.0.0 =
Initial version.
