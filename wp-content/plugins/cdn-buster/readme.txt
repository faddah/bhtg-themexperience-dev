=== CDN Buster ===
Contributors: manojtd
Donate link: http://buy.thulasidas.com/cdn-buster
Tags: cdn, cache, cache invalidation, wp super cache, w3 total cache, cache update, clear cache, cache refresh
Requires at least: 4.2
Tested up to: 4.5
Stable tag: 1.40
License: GPL2 or later

CDN Buster is a tool to invalidate the files cached on your CDN server en masse. It helps you update the stale files on your CDN server easily.

== Description ==

Once you use a Content Delivery Network (CDN) such as Amazon Cloudfront to speed up your blog, you will come across instances when you update a static file (a style or image file, for instance), but your readers keep getting the stale file from the CDN. No amount of cache clearing on your blog server is going to help refresh the cached file because it is on the CDN. The only way would be to "invalidate" the file, which will signal the CDN to pull a fresh copy from the origin location. But this necessitates you to log on to the CDN server, locate the file, generate a proper invalidation request, and wait for it to percolate to all the mirrors. And it often costs money.

CDN Buster offers a much easier alternative. You enter a Version String in the plugin admin page, and append the same string where you define the CDN address in your caching plugins, such as WP Super Cache or W3 Total Cache. This way, when your reader loads a page, he is looking for a different file, and your CDN server will query your blog server for it, where this plugin will intercept the query and serve the modified file from the *original* location. Thus, the modified file will get loaded on your CDN and all will be well.

= Pro Version =

In addition to the fully functional Lite version, *CDN Buster*  also has a [Pro version](http://buy.thulasidas.com/cdn-buster "CDN Buster -- easy invalidation of your CDN cache, $5.95") with many more features.

1. Automatically update the CDN settings in your WP Super Cache or W3 Total Cache plugin.
2. Change the origin pull location on your CDN server to a generic string (e.g. `cdn-bustor-*` where `*` can be anything) without touching your blog settings to invalidate the cache.
3. Invalidate by file type, so that only certain types of files are invalidated.
4. Invalidate single files from a list that you specify.

= Why use a CDN =

Content Delivery Network (CDN) is a collection of geographically distributed servers that mirror and serve you static contents (images, JavaScrip/CSS files, movies etc.) to your readers much faster than your own blog server can. It speeds up your blog tremendously:

1. It serves a large part of your website payload from servers that are close to the readers. CDN servers are specifically optimized for such contents.
2. Since your resources on the CDN have different address (URL), the reader's browser loads the statc content and the dynamic content (from your blog server) in parallel, enhancing the user experience.
3. The load on your blog server goes down becuase it is no longer serving a large part of the page content, which improves its performance.

In short, if you are not using a CDN yet, you should. It is very easy to set it up if you use any popular cacching plugins (such as WP Super Cache or W3 Total Cache). Most CNDs are of the so-called Origin Pull kind, where the CDN server automatically pulls a file from a location (typically your blog itself) whenever it is asked to serve a file it doesn't have in its cache. This is usually a one-time operation, which is slow. The CDN then proceeds to mirror the file on its servers all over the world. Thereafter, whenever the file is requested, the file is served instantly from a server closest to the reader.

== Upgrade Notice ==

Compatibility with WordPress 4.5.

== Screenshots ==

1. CDN Buster admin page.

== Installation ==

To install it as a WordPress plugin, please use the plugin installation interface.

1. Search for the plugin CDN Buster from your admin menu Plugins -> Add New.
2. Click on install.

It can also be installed from a downloaded zip archive.

1. Go to your admin menu Plugins -> Add New, and click on "Upload Plugin" near the top.
2. Browse for the zip file and click on upload.

Once uploaded and activated,

1. Visit the CDN Buster plugin admin page to run it.
2. Take a tour of the plugin features from the CDN Buster admin menu Tour and Help.

== Frequently Asked Questions ==

= What does this program do? =

*CDN Buster* a tool to invalidate the files cached on your CDN server en masse. It helps you update the stale files on your CDN server without spending money and time to track them down and invalidate them one by one.


== Change Log ==

* V1.40: Compatibility with WordPress 4.5. [May 12, 2015]
* V1.31: Minor interface and documentation changes. [Feb 25, 2016]
* V1.30: Deprecating translation interface in favor of Google translation. [Feb 23, 2016]
* V1.20: Compatibility with WordPress 4.4. Code to avoid redirect caching. [Dec 5, 2015]
* V1.10: Refactoring changes. [Nov 7, 2015]
* V1.02: Improved documentation. [Oct 18, 2015]
* V1.01: Minor interface changes. [Oct 17, 2015]
* V1.00: Initial release. [Oct 15, 2015]
