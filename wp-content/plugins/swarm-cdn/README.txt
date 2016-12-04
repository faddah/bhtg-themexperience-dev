=== Swarmify (formerly Swarm CDN) ===
Version: 0.4.1
Stable tag: trunk
License: GNU AFFERO GENERAL PUBLIC LICENSE
License URI: http://www.gnu.org/licenses/agpl-3.0.html

Allows you to easily configure your WordPress site to use Swarmify.

== Description ==

> [Swarmify](http://swarmify.com) is the first peer-to-peer content delivery network using WebRTC. This WordPress
plugin, in conjunction with a Swarmify account, will greatly simplify the process of getting Swarmify set up on your
WordPress site.

Swarmify provides a seamless (behind the scenes) real time network of your surfers so that they serve content to
each other (and only each other while they’re on your site). For every image that your surfers serve to each
other that is content that is not served via your host and therefore you save money.  If you’re already using a
CDN you can simply add Swarmify to your existing CDN.

You can read more extensively about Swarmify at our site http://swarmify.com

*If you do not load your images from the same domain as your WordPress site you should see the support
documents for help at our knowledge base.  Just login to http://swarmify.com and select knowledge base.

== Installation ==

1. Copy the `swarm-cdn` directory into your `/wp-content/plugins/` directory.
2. Activate the plugin through the *Plugins* menu in your WordPress Dashboard.
3. Navigate to the newly created *Swarmify* menu item, under the *Settings* menu in your WordPress Dashboard.
4. Configure the Swarmify plugin settings.

It is important to note that if you do not load your images from the same domain as your WordPress site you
should see the support documents for help at our knowledge base.  Just login to http://swarmify.com and select knowledge base.

= Known Issues =
 **Cross Domain Image/Video Hosting** - If you're hosting content on a different domain or subdomain (possibly a CDN), please see this [article](https://swarmlabs.zendesk.com/entries/25400078-You-host-images-video-on-a-different-domain-CDN-host-or-subdomain-You-NEED-to-do-the-following-).

 **Lazy Loading** - If you're using a Lazy Loading script go ahead and turn it off as it conflicts with our script and the best part is we already use Lazy Loading.

 **Inflated Analytics numbers when using Cloudflare.** - Swarmify uses an iframe to resolve a known issue with cross domain content loading.
 When you use Cloudflare they insert your Analytics code in this iframe and therefore your hits (numbers) will appear inflated.
 See this [forum post](https://swarmlabs.zendesk.com/entries/27583186-Inflated-Analytics-adwords-numbers-when-I-use-Swarm-)
 for a simple quick fix solution.

== Changelog ==
= 0.4.1 =
Change to load script over SSL by default

= 0.4.0 =
Prevented image swarming when the website is being accessed by a bot or other search engine. This is to ensure
proper crawling, indexing and SEO optimizations.

= 0.3.9 continued =
Changed branding from Swarm CDN to Swarmify. Retained version number as this is not a bug fix or functional update.

= 0.3.9 =
Added back in output buffering that was removed in 0.3.4 as an optional feature, defaulted to off.

= 0.3.8 =
Fixed a bug that would sometimes cause the Media Manager to not display any items for "All Media" or "Video" filters when the Swarm CDN plugin was active.

= 0.3.7 =
Added attributes to Swarm script tags to disable Cloudflare's async loading. This was accidentaly removed in version 0.3.4

= 0.3.6 =
Added back in filtering of 'the_content' that was present in 0.3.4, while maintaining the new filtering of 'the_posts' added in 0.3.5

= 0.3.5 =
Fixed a bug introduced by v0.3.4 that was not properly handling swarmed content in all page types.

= 0.3.4 =
Removed output buffering as it appeared to conflict with output buffering in other plugins.

= 0.3.3 =
Added additional embed options when embedding MP4 videos using Swarm CDN.
Moved the "Insert with Swarm CDN" button on the media-manager to a more obvious location.
Hid the default "Insert into Post" button so as not to confuse users on which one to use.
Changed the readme.txt plugin name to match the actual plugin name (Swarm CDN) once it is installed.

= 0.3.2 =
Fixed a permissions issue when writing out swarmcdniframe.html by changing the target directory to "uploads".
Added in a "swarmiframe" variable to the page-injected javascript which indicates the location of swarmcdniframe.html

= 0.3.1 =
Adding in missing jQuery Select2 dependencies.

= 0.3.0 =
Enhanced video support with embeddable SwarmCDN shortcodes. Check the SwarmCDN settings page after installing to get started.

= 0.2.1 =
Fixed a sanitization bug when saving settings that would allow the Swarm code to appear without a proper api key.

= 0.2.0 =
Added multisite support.

= 0.1.8 =
Performance improvements.

= 0.1.7 =
Fixed a pathing bug.

= 0.1.6 =
Added in a version check routine to run logic when the plugin is updated as the activation hook does not run on updates.

= 0.1.5 =
Fixed the 1x1 place holder graphic to use relative protocol.

= 0.1.4 =
Fixed a bug that would clear the plugin settings when the main WordPress settings were updated.

= 0.1.3 =
Modified script tags so that CloudFlare's Rocket Loader will ignore Swarm CDN scripts.
