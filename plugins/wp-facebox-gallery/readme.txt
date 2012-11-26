=== WP Facebox Gallery ===
Contributors: Dave Bergschneider
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=27ZFBCXC3LWGN
Tags: facebox, media, gallery, modal, lightwindow, image, images, media, nextgen gallery, photo, photo albums, photos, picture, pictures, thickbox, lightbox
Requires at least: 2.8
Tested up to: 3.3.1
Stable tag: 2.0

Automatically invokes Facebox on gallery items and linked images in a post or page.

== Description ==

Facebox is a jQuery-based, Facebook-style lightbox which can display images, divs, or entire remote pages. It's simple to use and easy on the eyes. This plugin makes Facebox installation a breeze and automatically invokes the facebox modal when images are detected however it additionally detects if there are multiple linked images and adds gallery and slideshow controls accordingly.

Related Links: <a href="http://www.crunchingpixels.com/portfolio/2010/02/wp-facebox-gallery/" title="WP Facebox Gallery Plugin for WordPress at Crunching Pixels">Plugin Homepage</a>, <a href="http://defunkt.io/facebox/" title="Facebox Official Website">Facebox</a>

Please submit feedback to the plugin's home page in regards to features you would like to see in the future.

== Installation ==

1. Unzip and upload the `wp-facebox` directory to `/wp-content/plugins/`
2. Activate the plugin through the `Plugins` menu in WordPress
3. There is no step 3.\*

**Browser Compatibility**
This release relies on a lot of advanced CSS techniques (box-shadow, border-radius, RGBA). That being said, it's compatible with many browsers.
* Safari 4+
* Webkit Nightlies (Chromium, Chrome) as of 4/17/10
* Firefox 3.5+
* Internet Explorer 9+
* Internet Explorer 8 (degraded experience)
* Internet Explorer 7 (degraded experience)
* Internet Explorer 6 - I just don't care
* Opera - I just don't care


\* **Note**: *For advanced configuration, refer to the comments of the constructor method, located near the bottom of `wp-facebox.php`*
\* **Note**: *If you do not like v2 of this plugin, you can revert to the previous version by editing line 16 `var $ver = 3;` of `wp-facebox.php`. Simply change the 3 to 2.*

== Frequently Asked Questions ==

= What does this plugin do, exactly? =

a. For any image contained in a post that has been specified as linked to the image source (the default, e.g. a large image resized to 'medium' and linked to the larger version), add a `rel` attribute with the value `facebox`. This is accomplished as a filter on `the_content`.

b. *Any* linked content inside a shortcode gallery will demonstrate identical behaviour to those linked images in posts; viz., when clicked they will giggle and squee in delight, emitting sunshine and rainbow glitter.

Or, you know, a Facebook-style lightbox appears with the linked content.

= What does this plugin not do? =
This plugin does not allow for you to select image files or file directories for turning into a gallery...yet! If the demand and support for this plugin increases I may add this functionality. In the meantime, plugins such as <a href="http://wordpress.org/extend/plugins/nextgen-gallery/" title="NextGEN Gallery is a full integrated Image Gallery plugin for WordPress with dozens of options and features.">NextGen Gallery</a> has the functionality you are looking for.

= How do I add title's & captions to my images? =
a. The title is pulled from the image title attribute. Using Wordpress's insert image or edit image, the `Title` field.

b. The description / caption is pulled from the image alt attribute. Using Wordpress's insert image, use the `Alternate Text` field. When editing an existing image in wordpress, select Advanced Settings at the top to find the `Edit Alternate Text` field. 

**Note**: *The fields mentioned in a & b will inlude the title and alt attributes in the proper place without having to manually edit html.*

= How do I add title's & captions to inline content? =
At this time, the plugin is incapable of adding title's and caption for inline content calls. It is on my todo list and of course popularity, ratings and donation incentives go a long way here.

= What version of jQuery does it use? =
WP Facebox Gallery uses the same version and instance of jQuery installed with Wordpress and is used by the Wordpress dashboard. The Wordpress included version is typically not the latest version and is updated periodically.

= What else can it do? =
a. You can link to Divs, ex. `<a href="#mydiv" rel="facebox">text</a>`

b. You can link to pages via AJAX, ex. `<a href="remote.html" rel="facebox">text</a>`

= Does this plugin work with all WordPress versions? =

This plugin has been tested to work with 2.8 and newer. If you are using an older version, it is highly recommended to upgrade for your sites own security.

= The plugin installed correctly but nothing happens =
a. I have found the plugin wp-minify destroys the jQuery reference which is essential for this plugin to work correctly.

b. You may have another plugin installed that is trying to do something very similiar. I suggest disabling all other plugins, and check to see if it begins working. If it does, re-enable each plugin one by one and checking inbetween. Once you have found the culprit, please post a comment at my blog letting me know and I will add it to a list of plugin that can cause it to break until I find a solution for it.

c. You may not be linking correctly to an image file or content. Linking to content requires you manually add the attribute to re="facebox" while linking to images does this automatically.

= What plugins are known to break WP Facebox Gallery =
a. <a href="http://wordpress.org/extend/plugins/wp-minify/" title="This plugin uses the Minify engine to combine and compress JS and CSS files to improve page load time.">WP Minify</a>: Corrupts jQuery reference

== Changelog ==

= 2.0 =
* Updated Facebox Script from 1.1 to 1.2
* Updated Facebox CSS

= 1.0.6 =
* Updated compatibility version, updated outdated links, and notice of pending update.
* Added plugin banner to repository

= 1.0.5 =
* Adjusted the facebox z-index to 99999 from 100 due to conflicts from certain purchased themes.
* Added class prefixes to all output and in the stylesheet to help prevent css conflicts.

= 1.0.4 =
* Fixed a minor error in the CSS submitted by Johannes Henrysson.
* Added some additional information to the FAQs for clarification.

= 1.0.3 =
* Confirming fully compatible with Wordpress 3.0

= 1.0.2 =
* Bug Fix: Fixed auto-installation directory
* Added a much more indepth readme.txt file

= 1.0 =
* Added gallery and slideshow controls
* Added titles & descriptions
* Added Added detection for multiple linked images on the same page

== Screenshots ==

1. Closeup of gallery controls, title & caption areas
2. Example of full pop-up

== License ==

Good news, this plugin is free for everyone! Since it's released under the GPL, you can use it free of charge on your personal or commercial blog. But if you enjoy this plugin, you can thank me and leave a [small donation](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=27ZFBCXC3LWGN "Donate with PayPal") for the time I've spent writing and supporting this plugin.

== Special Thanks ==
<a href="http://www.corporatebloggingtips.com" title="Corporate Blogging for Dummies">Douglas Karr</a> for his generous donation and use of the plugin.<br />
Also HUGE thanks to <a href="http://www.codeandmore.com/" title="best Vietnamese web developer team">Code and More</a> for making v2 of this plugin possible.