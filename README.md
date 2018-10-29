# Property Carousel for Property Hive

[![Travis (.com)](https://img.shields.io/travis/com/mhcg/property-carousel-propertyhive.svg)](https://travis-ci.com/mhcg/property-carousel-propertyhive)
[![Code Climate maintainability](https://img.shields.io/codeclimate/maintainability/mhcg/property-carousel-propertyhive.svg)](https://codeclimate.com/github/mhcg/property-carousel-propertyhive)
[![Code Climate coverage](https://img.shields.io/codeclimate/coverage/mhcg/property-carousel-propertyhive.svg)](https://codeclimate.com/github/mhcg/property-carousel-propertyhive)

WordPress plugin for [Property Hive](https://github.com/propertyhive/WP-Property-Hive) to add a carousel feature.

This is an add-on to the popular Property Hive (Estate agency software for WordPress).  As such it needs the
Property Hive plugin as well to work.  The plugin has been written by a 3rd party with no affiliation to the authors
of the Property Hive plugin.

Full full details of the Property Hive plugin see one of the following links.

* [Property Hive for WordPress Homepage](https://wp-property-hive.com/)
* [Property Hive on GitHub](https://github.com/propertyhive/WP-Property-Hive)

This plugin adds a basic carousel feature allowing you to put a shortcode on any page or post to showcase either
all properties or featured (or not) properties.  Properties are displayed from a random selected of no more than 10.

## Example Usage ##

`[property_carousel featured="yes"]`

`[property_carousel featured="yes" department="residential-sales"]`

## Supported Shortcode Attributes ##

**featured** - Featured (or not), or blank for all, i.e. "yes", "no" or "".

**department** - Department, one of "residential-sales", "residential-lettings" or "commercial".

**office_id** - Office ID.