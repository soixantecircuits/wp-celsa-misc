=== SensitiveTagCloud ===
Contributors: reneade
Donate link: http://www.rene-ade.de/stichwoerter/spenden
Tags: widget, sidebar, posts, tags, categories, category, navigation, widgets, links, tag, tagcloud, sensitive, condition, stc, drilldown, drill down, drill, down, related, limit, exclude
Stable tag: trunk
Requires at least: 2.3
Tested up to: 2.99999

This wordpress plugin provides a tagcloud that shows tags depending of the current context (e.g. Category, Author, Tag, Post) only. The tag-links of the cloud can be restricted to the current category or current selected tag, like a drill down navigation. The style, sizes and the conditions where the widget should be visible, are configurable. 

== Description ==

This wordpress plugin provides a configurable tagcloud that shows tags depending of the current context only. For example the tagcloud shows only tags that really occur in the current category, or within the current date-, author-, tag- archive or even only the tags that occur in the search results. 
It is also possible to restrict the links of the tag cloud to the current viewing tag archive or category: If you click on the tag "test1" within the tag cloud of the tag archive of "test2" the target page will only contain posts that have both tags, like a drill down navigation. It is possible to exclude the tag of the tag-archive itself from the tagcloud.
For the single post pages you can configure the tagcloud to show also related tags of the current posts, not only the direct tags of the post. And you can configure the tagcloud to exclude the tag of the current post, to show only the related tags.
The style and sizes of the tagcloud can be configured, and the widget can be configured to be only visible if viewing a tag archive, category, a sinlge post or even only if viewing the searchresults for example. It is also possible to configure the number of tags that should be displayed in the different conditions.

Plugin Website: http://www.rene-ade.de/inhalte/wordpress-plugin-sensitivetagcloud.html
Donations: http://www.rene-ade.de/stichwoerter/spenden

== Installation ==

1. Upload the folder 'sensitive-tag-cloud' with all files to '/wp-content/plugins' on your webserver
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add the widget "sensitive tag cloud" to your sidebar and configure it as you like

German ScreenShots: sensitive-tag-cloud_install_de.jpg

IF YOUR THEME DOES NOT SUPPORT SIDEBAR WIDGETS:
- Use the page "SensitiveTagCloud" under the "Presentation"/"Themes"-menu of your admin panel to configure the SensitiveTagCloud 
- Add the following code to your template file where you like to output the SensitiveTagCloud:
  ' 
  <?php 
    if( function_exists("stc_widget") )
      stc_widget(); 
  ?> 
  '

== Update ==

1. Deactivate the Plugin
2. Remove the existing folder 'sensitive-tag-cloud' with all files from the 'wp-content/plugins' folder on your webserver
3. Upload the new folder 'sensitive-tag-cloud' with all files to '/wp-content/plugins' on your webserver
4. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

Screenshots can be found on the plugin website
http://www.rene-ade.de/inhalte/wordpress-plugin-sensitivetagcloud.html