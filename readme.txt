=== Live COVID19 LITE with Elementor ===
Contributors: chandang
Plugin Name: Live COVID19 LITE
Plugin URI: https://www.wpmentals.com/live-covid19
Tags: live covid19, coronavirus, Corona virus, covid19, elementor
Author URI: https://www.wpmentals.com
Author: Chandan Kumar
Donate link: https://www.paypal.me/chandankumargouda
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Requires at least: 3.0
Stable tag: 1.0.0
Tested up to: 5.4.1
Requires PHP: 5.0
Version:  1.0.0

Show Corona Affected Data in a wordpress website through Elementor Widgets , Wordpress Widgets , Wordpress Shortcode

== Description ==

Live Corona19 Wordpress Plugin helps to show COVID19 affected data on any wordpress site through wordpress shortcodes, widgets and powerful elementor widgets

To create shortcodes in easily, Shortcode generator is available in wordpress Dashboard >> Settings >> Live COVID19 LTE >> Shortcode Generator

### Some of the features ###
##All Cases
   - Confirm Cases
   - Today Confirms( Available in Pro Version )
   - Deaths
   - Today Deaths ( Available in Pro Version )
   - Recovered
   - Active ( Available in Pro Version )
   - Tests ( Available in Pro Version )

Search and Sort the Data in table
Full Table and custom height table is available 
Numeric data Counter with custom time duration
>> Data exports with PDF, print and Excel file format also available in Pro version .

*Check PRO*  : [Live COVID19](https://wpmentals.com/live-covid19) 

### How to show Data in Website ###

== Through Elementor Widget ==
1. COVID 19 : World
2. COVID 19 : ALL Countries Table
3. COVID19 : Single Country

== Through Wordpress Widgets ==
1. COVID19 Global Data
2. COVID19 Single Country Data 

== Through Wordpress Shortcodes ==
>> Use Shortcode Generator tool to easy to create Shortcodes  in Wordpress Dashboard >> Settings >> Live Covid19 >> Shortcode Generator

1. [lcovid-table] : To Show Table Data of All Countries 
2. [lcovid-global] : To Show Global Data of COVID-19
3. [lcovid-country] : To Show Single Country Data of COVID-19 

**Attributes of [lcovid-table]**

   	1. flag  		: value will be "yes" or "no", Add "yes" if you want to show country's flag in table
   	2. sorting  	: value will be "yes" or "no", Add "yes" if you want to enable table sorting
   	3. separator	: value will be "yes" or "no", Add "yes" if you want to enable thousand separator
   	4. delimiter	: value will be "," or "." or " ", Add thousand separator in all country's table numeric data
	5. confirms  	: value will be "yes" or "no", Add "yes" if you want to show confirm cases in table
  	6. deaths  	: value will be "yes" or "no", Add "yes" if you want to show death cases in table
   	7. recovered  	: value will be "yes" or "no", Add "yes" if you want to show recovered cases in table
   	8. title_confirms 	: title of the confirm cases
   	9. title_deaths  	: title of the deaths
   	10. title_recovered   : title of the recovered

for example to show data table with country flag and custom title to confirmed cases 

    [lcovid-table flag="yes" title_confirms = "Total Confirm Cases" ]

**Attributes of [lcovid-global]**

	1. show_title  	: value will be "yes" or "no", Add "yes" if you want to show Titles of the all cases
	2. counter  	: value will be "yes" or "no", Add "yes" if you want to enable counter for numeric data
   	3. duration  	: value will be in milli seconds
   	4. separator  	: value will be "yes" or "no", Add "yes" if you want to enable thousand separaor for numeric data
   	5. delimiter	: value will be in milli seconds ',' or '.' ' '(space) of thorusand separator
   	6. confirms  	: value will be "yes" or "no", Add "yes" if you want to show confirm cases
   	7. deaths  	: value will be "yes" or "no", Add "yes" if you want to show death cases
   	8. recovered  	: value will be "yes" or "no", Add "yes" if you want to show recovered cases
   	9. title_confirms 	: title of the confirm cases
   	10. title_deaths  	: title of the deaths cases
   	11. title_recovered : title of the recovered cases

for example to show global data with counter and add thousand separator

	[lcovid-global counter= "yes"  separator="yes"]

**Attributes of [lcovid-country]**

   	1. country 	: Value will be iso3 name of the specific country for which will show
   	2. show_title  	: value will be "yes" or "no", Add "yes" if you want to show Titles of the all cases
   	3. counter  	: value will be "yes" or "no", Add "yes" if you want to enable counter for numeric data
   	4. duration  	: value will be in milli seconds
   	5. separator  	: value will be "yes" or "no", Add "yes" if you want to enable thousand separaor for numeric data
   	6. delimiter	: value will be in milli seconds ',' or '.' ' '(space) of thorusand separator
   	7. confirms  	: value will be "yes" or "no", Add "yes" if you want to show confirm cases
   	8. deaths  	: value will be "yes" or "no", Add "yes" if you want to show death cases
   	9. recovered  	: value will be "yes" or "no", Add "yes" if you want to show recovered cases
   	10. title_confirms 	: title of the confirm cases
   	11. title_deaths  	: title of the deaths cases
   	12. title_recovered : title of the recovered cases

for example to show India data without case title and display only confirm cases

	[lcovid-global country="IND" deaths="no" recovered="no"] 



### API INFOMATION ###
NovelCOVID/API

API website: https://github.com/NovelCOVID/API

License: https://github.com/NovelCOVID/API/blob/master/LICENSE

Endpoint: https://corona.lmao.ninja/v2/

Privacy policy: https://github.com/NovelCOVID/API/blob/master/privacy.md

Please read the Privacy Policy of this API before you download and install this plugin in your website.

Privacy Policy: https://github.com/NovelCOVID/API/blob/master/privacy.md

Feel free to suggest if you have any suggestions, regarding the plugin.


## Credits or THIRD PARTY SERVICES  ##
 API: https://github.com/NovelCOVID/API

=== Installation ===

1. Go to the WordPress Dashboard "Add New Plugin" section.
2. Search For "Live Covid19 Lite". 
3. Install, then Activate it.

== Screenshots ==

1. Data Table of All Countries
2. Elementor Widgets
3. Single Country Data
4. Global Data
5. Shortcode Generator

