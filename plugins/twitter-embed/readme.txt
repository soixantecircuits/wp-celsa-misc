=== Twitter Embed ===
Contributors: kovshenin
Donate link: http://kovshenin.com/beer/
Tags: twitter, embed, tweet, oembed
Requires at Least: 3.1
Tested Up To: 3.3.1
Stable tag: 1.0.1

Easily embed tweets in your posts and pages by posting the tweet URL on a line by itself or by using a shortcode provided by the new Twitter interface.

== Description ==

Twitter Embed requires no configuration, it works out of the box right after activation. Copy a link to a tweet on Twitter.com and paste it on a line by itself in your post or page editor. When viewing the post, you'll see that the link has been replaced with the embedded tweet with options to reply, retweet, favorite and follow.

The plugin uses Twitter's original widgets API, the shortcode and embed HTML are available too. Embed HTML is reversed to a Tweet shortcode when HTML is filtered (for authors or contributors). The tweets themselves are cached in post meta for better performance.

== Installation ==

1. Download the plugin zip archive.
2. Extract it in your `wp-content/plugins` folder or upload via admin panel.
3. Browse to your plugins section and active the plugin.
4. Use it in your posts and pages by linking to tweets on a line by itself.

== Frequently Asked Questions ==

= Where do I get the link to a tweet? =

Good question. It really depends on the Twitter application/client that you're using. If you're using twitter.com then take a close look at the tweets and you'll see that the date of when the tweet has posted (1 hour ago, etc) is a link. That link is the one you're looking for. If you're using the Twitter for Mac application, you can right click any of the tweets and select View on Twitter.com which will take you to that particular tweet in your browser.

== Screenshots ==
1. This is how your embedded tweets will appear on your blog or site.
2. This is how you embed your tweets in the editor -- just a link on it's own line or a shortcode.

== Changelog ==

= 1.0.1 =
* Protected meta security fix (which enabled authors to post unfiltered HTML, but not anymore!)
* Commenting code

= 1.0 =
* First release