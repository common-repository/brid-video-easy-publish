=== Target Video Easy Publish ===
Contributors: Sovica, pedjoni, losmicar, sibussiso, nebojsadabic
Donate link: https://target-video.com/
Tags: video library, video monetization, video player, VPAID, VAST
Requires at least: 5.0
Tested up to: 6.6.2
Stable tag: 3.8.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Seamlessly embed your videos (YouTube, streaming, HTML5, Flash) using TargetVideo video players into your WordPress site or blog. 

== Description ==

With this plugin, you will be able to seamlessly add TargetVideo video players and your video content to your WordPress website or blog.
TargetVideo has a user-friendly CMS where you can easily upload or import videos and monetize them.

**Main Features**

*   Fast and lightweight HTML5 player
*   Full VAST/VPAID support for video monetization
*   Full video header bidding support including prebidJS
*   Outstream ad units
*   Fully customizable player skins
*   Responsive player sizing
*   Powerful analytics.

Learn more about TargetVideo on our [product page](https://target-video.com/?utm_source=marketing_wordpress&utm_medium=wordpress-plugin&utm_campaign=target-video-wordpress-plugin "website").

Users will be able to easily search for videos in their TargetVideo library. In addition all of your playlists and videos will be easily accessible with editable thumbnail, title and other information about the video. Using a simple user interface, click on the video you want and insert it into your post or page.

Default players for videos and playlists can be set throughout the site to create a consistent look as well as default heights and widths which depend on the player setup. All of these defaults can be overridden at the time of video insertion to allow for customization of a video or player.

In addition this plugin features a live preview of the video or playlist and player so you will know that you have the right video before you add it to your site.

== Installation ==

1. Upload the TargetVideo Easy Publish plugin to your site via the "Add New" section of the "Plugins" tab.

2. Once the plugin has been uploaded, activate the plugin.

3. Once activated, click on the "Configure" link that appears at the top.

4. You will be prompted to authorize plugin usage with Target-Video.com. Click on the Authorize button.

5. You will now be prompted with a login page in which you should input your TargetVideo login credentials. If you don't have an Target-Video.com account you can create one on the same page for free.

6. Once you login or signup, you will be prompted again to authorize Target-Video.com usage with the installed plugin. Click on the authorize button and you are done!

Alternatively, you can install the plugin right from your WordPress admin dashboard. Simply search for "TargetVideo easy publish" in the plugin section of the admin. WordPress will download and install the plugin for you automatically.
 
You will be able to use TargetVideo videos and players in your regular Wordpress posting screen by clicking on the Target-Video.com button located above the formatting bar of your post screen. 
You can also manage your TargetVideo library and playlists under Media > TargetVideo.

== Frequently asked questions ==

= I have installed the plugin but it does not work. =

Make sure that your WordPress version is at least 3.9, as versions below are not supported.

= Can I run the plugin on a WordPress install that isn't publicly accessible? =

No. Your site will need to be available to the public for the plugin to correctly configure.

= Can I use this plugin to host videos on my own server? =

Yes! You can use any video hosting that you prefer and our TargetVideo player will use these video files as a source.

= What shortcodes can I use for TargetVideo playlist widgets? =

[brid_widget items="25" player="1" height="540" type="0" autoplay="1"]
This is the basic template for a TargetVideo playlist widget shortcode:

*   items: set the number of videos you want to appear in the widget. Maximum allowed is 50.
*   player: input the ID of the TargetVideo player you wish to use. Contact TargetVideo support if you are not sure what your player ID is.
*   height: set the height in pixels for the widget.
*   autoplay: 1 if you wish for the widget to autoplay. 0 for click to play.

= Have any further questions? =

See our extensive FAQ and documentation section here - https://helpdesk.target-video.com/hc/en-us

== Screenshots ==

1. Video library
2. Video edit view
3. Add a new VAST/VPAID ad tag to your player for monetization
4. Playlists screen
5. Add to post TargetVideo button
6. Upload video to your account
7. Add a YouTube video to your account
8. Add an externally hosted video to your account
9. TargetVideo settings page
10. TargetVideo player configuration
11. TargetVideo quick post video screen
12. Embedded TargetVideo player in a WordPress post
13. Related videos screen in TargetVideo player with a TargetVideo latest playlist widget in the site sidebar

== Changelog ==

= Version 3.8.3 =
*   Added support for our new CMS domain

= Version 3.8.1 =
*   Fix for async embeds
*   Fix for multiselect dropdowns

= Version 3.8.0 = 
*   Added new feature: Syndication rules
*   Added new setting option for default Syndication rules
*   Added IAB Content Taxonomy
*   Added listing smart playlists
*   Removed feature: Shared partners
*   Removed categories (channels) from videos / playlists
*   Added "Credits / Source" text on video list page
*   Fix for form save validation messages

= Version 3.7.12 = 
*   Bug fix for widget filter 

= Version 3.7.10 / 3.7.11 = 
*   Added "geo" prefix inside shortcode urls for geo targeting videos
*   Fix shortcode CDN url 

= Version 3.7.9 = 
*   Fix css admin bug

= Version 3.7.8 = 
*   Fix widget loading speed

= Version 3.7.7 = 
*   Added shared partner on shortcode url path

= Version 3.7.6 = 
*   Fixed embed div id for multiple players on page
*   Bug fix for snapshoot insite shortcode
*   Bug fixed for php 8.1 version

= Version 3.7.5 = 
*   Bug fix for copy shortcode for playlists on post widget
*   Bug fix for shared videos filter for video library on post widget

= Version 3.7.4 = 
*   Added player templates into player settings
*   Added prompt alert if "tag" field is empty and alert option is enabled
*   Added video filter options on widget for listing videos in library
*   Added support for video sharing option
*   Added info display for video Geo, if enabled
*   Fixed for uploading ".mp3" files
*   Bug fixed for php 8.1 version
*   Added best quality snapshot to shortcode

= Version 3.7.3 = 
*   Refactored the entire plugin following the latest coding standards
*   Added new oAuth2 Client library
*   Autosave option is now contoled by CMS account settings
*   Upload options are controlled with permissions from CMS user plan
*   Added "Exit intent prompt window" if page is closed but not saved
*   Added support for video matching embed code
*   Added error messages on Widget (if error occured)
*   Added new options to disable embed shortcode if video is not encoded
*   Added video "Status" info message on Widget - Video Library Tab
*   Fixed display thumbnail snapshots for video list in widget.
*   Fixed bug for upload file size limit
*   Fixed displaying errors on pages and broken images
*   Bug fixed on Settings option page
*   Fixed overlaping message with other options when there is no videos uploaded
*   Fixed bug with 'publish' and 'monetize' buttons
*   Google Structured data added for playlist shortcode (if enabled in settings)
*   Added player select drop for playlist embeding shortcode
*   Corrections are added for embeding shortcode
*   Added new options on settings page to controll displaying tabs in Widget

= Version 3.6.8 = 
*   Fixed uploading of custom snapshots.

= Version 3.6.7 = 
*   Fixed display of snapshots on video and playlist lists.
*   Fixed copy shortcode button when adding new videos.

= Version 3.6.6 = 
*   Updated the UI for re-ordering items in a playlist.
*   Fixed a minor bug where the Brid video carousels tab would dissapear.
*   Added an option to override and set custom sizes for your players through the shortcode.

= Version 3.6.5 = 
*   Fixed upload functionlity when trying to change a videos title in the middle of the upload process.

= Version 3.6.4 = 
*   Fixed upload process for new setup.

= Version 3.6.3 = 
*   Fixed the process of rearranging items on the edit playlist screen.

= Version 3.6.2 = 
*   Fixed site save on settings page bug

= Version 3.6.1 = 
*   Fixed video previews
*   Fixed playlist quick edit

= Version 3.6.0 = 
*   Added custom post type support.
*   Added custom channel support in the plugin.
*   Changed the styling of the "Add to playlist" button to more resemble a button and be more prominent.
*   Added a notice when trying to fetch YouTube VEVO videos.
*   Fixed an issue where not saving the settings panel after initial authorization would break the video library page.

= Version 3.5.9 = 
*   Added support for Brid video carousels in the plugin.
*   Fixed a bug where the "edit here" link would not work after fetching a YouTube video.
*   Fixed an issue where certain newly added videos would have the wrong publish date.
*   Added better handling of invalid text inputs for different video metadata.
*   Removed support for fetching YouTube videos via a query as this is not possible anymore through the plugin. Use our CMS for this specific purpose. Fetching directly via YouTube link is still supported though.

= Version 3.5.6 = 
*   Fixed minor issue when saving players with empty bid fields.

= Version 3.5.5 = 
*   Fixed a couple of minor PHP notices that would appear on the admin part of the plugin.
*   Added full prebidJS support for the player inside the plugin.
*   Added Amazon video bidding on the player setup screen.
*   Fixed a minor CSS issue on the search input box when selecting custom featured images.
*   Added video click-through support on the edit video screen.
*   Added a copy video option to multiple partners/sites on the video edit screen.
*   Added display banner fallback slots for outstream units.

= Version 3.5.4 = 
*   Fixed a couple of minor PHP notices that our shortcode.php file had.

= Version 3.5.3 = 
*   Fixed another permission handling issue if there are no overrides set for the current account.
*   Fixed the issue where unpublished videos would appear when trying to add new videos to a playlist.

= Version 3.5.2 = 
*   Fixed user account permission handling if there are no overrides set for the current account.

= Version 3.5.1 = 
*   Returned support for PHP 5.6 for older WP installs that are still on legacy PHP.

= Version 3.5.0 = 
*   Refactored the entire plugin to use the Brid API ver. 3.0.
*   Added SpotX prebidding support.
*   Added sellers.json support for prebid implementations.
*   Fixed many inconsistencies inside the plugin and also squashed a couple of bugs.

= Version 3.2.2 = 
*   Added support for ad pods in WP plugin.
*   Added support for prebid in WP plugin.
*   Fixed a couple of minor bugs.

= Version 3.2.1 = 
*   Fixed the stripping of certain special characters inside posts.

= Version 3.2.0 = 
*   Added support for adding 5 video renditions qualities on the add/edit video screen.
*   Fixed the edit function for ad tags.
*   Updated the display for plan limits.

= Version 3.1.0 = 
*   Added support for uploading custom snapshots onto our hosting and CDN.
*   Added an option to completely replace an already uploaded video in Brid through the plugin for videos hosted by Brid.
*   Added an option to choose a custom snapshot from your uploaded video.
*   Added compatibility for WordPress 5.3
*   Added support for video content URL's for Google structured data purposes.

= Version 3.0.7 = 
*   Added support for Google structured data for Brid player AMP embeds.
*   Added compatibility for titles and descriptions which contain special characters when rendering Google Structured data.

= Version 3.0.6 = 
*   Added support for Google structured data for Brid player embeds. This is now a settable option on your plugin settings screen and if enabled, our short-code generator will automatically add Google structured data to your embed codes.

= Version 3.0.5 = 
*   Fixed new parameter to send valid pings to Brid Analytics.

= Version 3.0.4 = 
*   Added support for player onReady callbacks for players and outstream units.
*	Added the option to set a global onReady callback method on the plugin settings page.
*	Added the option to set a callback on the shortcode level.
*   Fixed a bug where German Umlauts where not copied correctly in shortcodes.
*   Added support for the Brid shortcode metabox on custom post type - shows and default WordPress pages.

= Version 3.0.3 = 
*   Added support for localization.
*	Minor auth and JavaScript bug fixes.
*	Updated the new embed codes to support new Analytics pings.
*   Fixed bug where the WP post button would be un-clickable when used with a custom playlist widget implementation. 

= Version 3.0.2 = 
*   Fixed jQuery plugin incompatibility for older WP versions.

= Version 3.0.1 = 
*   Backward compatibility with older WP versions.

= Version 3.0.0 = 
*   Added support for the new ad tag monetization system in Brid.
*   Deprecated the option to replace default WP video embeds.
*   Added new screens which list your Brid players and outstream units.
*   Added many new options on the player edit screen so you can now set up your player with almost all options inside WordPress itself.
*   Added basic account info inside the plugin so you have a quick overview of your current usage right inside the plugin itself.
*   Removed a lot of custom styling for the plugin so that it now uses default WordPress styling for most admin screens. This improves the plugin size and performance.
*   Optimized a lot of the backend code so the plugin now behaves more snappy.
*   Fixed a couple of minor bugs.

= Version 2.9.8 = 
*   Video category select fix
*   Edit video title and snapshot fix
*   Resolved saving issue when editing video title and snapshot
*   Multiple bug fixes

= Version 2.9.7 = 
*   Video edit bug fix

= Version 2.9.6 = 
*   Video monetization override option added

= Version 2.9.5 = 
*   Player SDK select fix 
*   Remove video from playlist fix
*   Minor bug fixes

= Version 2.9.4 = 
*   Fixed empty edit video issue
*   Fixed conflict with drag & drop functionality
*   Optimized copy shortcode option to automatically copy the players shortcode in all operations

= Version 2.9.3 = 
*   Added limited editor support, performance optimizations

= Version 2.9.2 = 
*   Resolved double AMP script call with 3rd party AMP plugins

= Version 2.9.1 = 
*   Resolved jQyuery conflict

= Version 2.8.9 =

*   Fixed pasting the embed code for new Gutenberg editor
*   Various bug fixes

= Version 2.8.9 =

*   Fixed incompatibility on certain WordPress sites when async embed codes are used.
*   Removed incomplete Google structured data from the shortcode embed code generator.
*   Deprecated Flash player option from player settings.

= Version 2.8.8 =

*   Checked compatibility with latest WordPress version 4.9.6.
*   Fixed display elements on the edit playlist screen to properly show certain buttons.


= Version 2.8.7 =

*   Added possibility to override autoplay setting from shortcode.

= Version 2.8.6 =

*   Added support for autoplay AMP players.
*   Added support for AMP pages where a trailing slash is missing due to different server configurations.
*   Checked compatibility with latest WordPress version 4.9.4.

= Version 2.8.5 =

*   Changed Facebook Instant Article embed code support for the iframe wrapper method.
*   Added support for the popular AMP for WP plugin for rendering Brid AMP embed codes.
*   Added AMP embed code support for Brid in-content outstream units.
*   Added some more basic player settings that we already provide in Brid CMS so you can change them in the plugin.
*   Added asynchronous embed code support for Brid players.
*   Removed some logs.

= Version 2.8.4 =

*   Removed ad container DIV being rendered by the Brid shortcode as it is not needed anymore.
*   Renamed the slide in view option to stay in view so that it matches the naming convention in the Brid CMS.
*   Updated the API to reference all changes made on the platform.


= Version 2.8.3 =

*   Added compatibility with WordPress 4.8.
*   Added support for default WP player replacer to take the poster image into account and set it up accordingly.

= Version 2.8.2 =

*   File uploader timeout fix.

= Version 2.8.1 =

*   Fixed SAVE button not enableing properly when fetching external URL's.

= Version 2.8 =

*   Added new encoding system in place for faster encodes.
*   Separated all API calls.

= Version 2.7.1 =

*   Fixed CSS conflict with WordPress default media gallery where its vertical scrollbar would not appear on smaller screens.

= Version 2.7 =

*   Fixed JavaScript conflict with the contact form builder plugin from WebDorado.
*   Fixed CSS override for the WP Background Takeover plugin.

= Version 2.6 =

*   Fixed playlist widget display on Appearance -> Widgets.

= Version 2.5 =

*   Fixed API user call.

= Version 2.4 =

*   Deprecated the old ADD YOUTUBE video option.
*   Removed the YouTube video player replacer.
*   Removed the intro video feature.
*   Synchronized the plugin with Brid CMS changes.
*   Added support for external video URL's that use IP's instead of domains and specific ports.
*   Added ad waterfalling options on the player monetization level in the plugin.
*   Added comscore tracking support.
*   Added basic outstream unit functionality.
*   Added the new option to add YouTube videos.
*   Added the new option to add Vimeo videos.
*   Various bug fixes.

= Version 2.3.1 =

*   Added support for Facebook Instant Articles when used in conjunction with the Automattic Facebook Instant Articles plugin - https://wordpress.org/plugins/fb-instant-articles/

= Version 2.3.0 =

*   Fixed potential XSS security exploit.
*   Patched multiple other files to make the plugin more secure.

= Version 2.2.5 =

*   Fixed async attribute for AMP player integration.
*   Checked compatibility for WordPress version 4.7.

= Version 2.2.4 =

*   Removed jQuery dependency for mobile playlist widget display.
*   Removed iScroll dependency for mobile playlist widget display.
*   Fixed minor bug where certain videos on the POST video screen were not clickable.

= Version 2.2.3 =

*   Fixed all Brid plugin admin views for display on smaller tablet screens.
*   Fixed minor JavaScript error when adding mid rolls on the monetization settings screen.
*   Changed the way player DIV HTML element ID's are constructed so they can be accessed with the players JavaScript API. They are not dynamically changed anymore.
*   Added the "ADD ANOTHER VIDEO" option on the ADD VIDEO screen so users can easily add multiple videos.
*   Added a default category option on the SETTINGS menu. All videos when added will go directly to this category if selected.
*   Added a default snapshot option on the SETTINGS menu. All videos will get this default starting snapshot when added.
*   Fixed no duration being present when adding external MP4 files.
*   Changed notification message when installing the plugin for the configure link.

= Version 2.2.2 =

*   Minor compatibility issues fixed
*   Background fixes

= Version 2.2.1 =

*   Added AMP player support when used in conjunction with the Automattic AMP plugin - https://wordpress.org/plugins/amp/
*   Removed crossdomain.xml references in the plugin as the Flash player is deprecated.
*   Added rocketscript exemption for certain frontend JavaScript files.

= Version 2.2.0 =

*   Added check to see if jQuery is already loaded.
*   Changed colors for share icons on mobile for playlist widgets.
*   Added mobile support for playlist widgets on Nexus 7 and Nexus 10.
*   Fixed Changing skin bug on player settings page.
*   Fixed double upload video bug when uploading videos on the POST page.
*   Added minor cosmetic changes to accomodate Brid new paid plans.
*   Added player configuration option for Facebook like player experience.
*   Added player configuration option for autoplay when 50% in view.
*   Added player configuration option for inpage playback on mobile devices.
*   Improved localhost detection when adding sites.
*   Fixed player preview bug on post screen after selecting one video.
*   Fixed minor upload issues on post and page screens.
*   Fixed title display when adding videos to an already existing user created playlist.

= Version 2.1.2 =

*   Fixed plugin conflict issue with Cloudflare WP plugin.
*   Tested compatibility with new WP 4.4 version.

= Version 2.1.1 =

*   Fixed JavaScript error under Appearance -> Customize when Brid playlist widgets were used.

= Version 2.1.0 =

*   Added option to disable player preview in posts or pages when embedding.
*   Massive optimizations and design changes to the Brid playlist widget.
*   Added more playlist options to the Brid playlist widget.
*   Added new options to the plugin in regards to the Brid partnership program.
*   Added shortcode support for Brid playlist widgets.

= Version 2.0.6 =

*   Fixed YouTube replacer functionality to not replace Dailymotion embeds.
*   Changed behavior for width and height player replacer for YouTube videos.
*   Fixed Api header response for certain premium themes compatibility.

= Version 2.0.5 =

*   Fixed YouTube replacer functionality when embed code is used without http(s) prefix.
*   Fixed YouTube replacer functionality if Vimeo embeds are used. It will not try to replace these embeds now.
*   Fixed Fit to Post option when no default width values were present for a player.

= Version 2.0.4 =

*   Fixed minor incompatibility with Jetpack's share plugin when displaying Twitter share buttons.

= Version 2.0.3 =

*   Fixed certain YouTube URL's that would not ingest properly.
*   Added notice for monetization options in regards to YouTube.
*   Fixed YouTube replacer functionality for certain premium themes.

= Version 2.0.2 =

*   Added compatibility with YouTube embed plugin.
*   Added new resize setting on the player level to set player size to the post/page size.
*   Changed certain HTML id's so that ad blockers do not recognize them as ads.
*   Changed the YouTube API version used to 3.0.

= Version 2.0.1 =

*   Added invalid URL check for intro videos.
*   Made plugin compatible with 3.9 WordPress version and onwards.
*   Optmized skin changing operation in settings menu to now use the player API. As a result, the change player skin operation is much faster.
*   Added a couple of checks on the settings page so changes propagate correctly between the CMS and the WP plugin.

= Version 2.0.0 =

This is almost a complete rework of our original plugin. There have been numerous changes and we could not list them all even if we wanted to. Here is brief overview of all the main features:

*   JavaScript backend optimizations in WordPress admin - Brid JavaScript are loaded only on admin pages that have Brid functionality.
*	Optimized Brid JavaScript front-end delivery when more than one Brid embed code is located on a single post or page.
*   Added a new settings page which contains additional monetization options for your player.
*   Added two new Brid replacers which can replace any YouTube or other WordPress video that was added to any post or page with a Brid player.
*   Added many configuration options for Brid players under the new settings page.
*	Added a FAQ section which contains valuable information regarding the plugin functionality.
*	All Brid plugin options are now centralized under a new entry in your main left hand menu under Brid.tv.
*	Added a Brid preview player on the Visual tab of any WordPress post or page.
*	Re-worked the new Brid quick post button on WordPress pages and posts.
*   Added functionality so that users can add any type of video or playlist through the Brid quick post button.
*	Added a report a bug section on the right sidebar.
*	Added a Brid playlist widget which you can find under your WordPress widgets section. It can currently display only your latest video playlist.
*	Added numerous optimizations for WordPress sites under HTTPS.
*   Fixed a couple of minor bugs on the video library page.

= Version 1.0.11 =

*   Resolved CSS class conflicts with some premium plugins and themes (SmartMag and WPtouch PRO).
*   Added feature so that re-authorization of the plugin is not needed anymore when upgrading to a newer version.

= Version 1.0.10 =

*   Added editor permissions to see Brid Video entry under Media menu.

= Version 1.0.9 =

*   Resolved JavaScript conflict on the videos list.

= Version 1.0.8 =

*   Removed redundant code that is not in use anymore.
*   Removed all references to fancybox due to GPL license.

= Version 1.0.7 =

*   Fixed bug where the plugin would recognize a plugin installation as a dev environment when in fact the site was not.
*   Fixed add video link when no videos were added.
*   Improved uploader functionality when a user cancels an upload.
*   Improved authorization protocols.

= Version 1.0.6 =

*   Updated WP plugin to work with new changes in the CMS backend.
*   Added new plan options.

= Version 1.0.5 =

*   Added a couple of security checks in the backend.
*   Fixed small preview player on edit playlist and edit video screens.
*   Added default preview player.
*   Fixed pagination when adding videos to an already created playlist.
*   Updated API to support newly added options in the WordPress plugin.

= Version 1.0.4 =

*   Fixed certain URL's to player to point to the right servers.

= Version 1.0.3 =

*   Added classification of playlists to differentiate between YouTube and internal Brid playlists.
*   Shortcode now displays JavaScript Brid player embed code for better ad support.
*   Removed field for landing pages that could appear on certain sections.

= Version 1.0.2 =

*   Fixed various CSS overrides so that the plugin does not interfere with different core CSS elements in WordPress.

= Version 1.0.1 =

*   Fixed radial button initialization when a Brid user tries to add their first video.

= Version 1.0.0 =

*   Primary stable plugin release.



== Upgrade Notice ==

= 3.6.9 =
We suggest that you always upgrade to the latest version. This is the only way to make sure proper functionality of the plugin.
