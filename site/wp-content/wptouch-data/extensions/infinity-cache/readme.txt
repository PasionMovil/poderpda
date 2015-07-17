Extension Name: Infinity Cache
Description: A lightweight caching module designed specifically for WPtouch Pro
Version: 1.2.2
Stable tag: 1.2.2
Depends-on: 3.7.8
Author: BraveNewCode Inc.

== Changelog ==

= Version 1.2.2 =

* Fixed: Infinity Cache now handles password protected pages
* Changed: Automatically flush the cache when updating the WPtouch Pro plugin

= Version 1.2.1 =

* Fixed: Issue with URLs without explicit protocol reference (i.e. // vs http://)

= Version 1.2 =

* Changed: Fixed issue where CSS files weren’t switched to CDNs
* Changed: Replaced CDN regex code for improved performance

= Version 1.1.1 =

* Changed: Now removing the WP admin bar quick link to clearing the cache when Infinity Cache is disabled

= Version 1.1 =

* Changed: Automatically flush cache when WPtouch Pro settings are updated
* Changed: Extension settings layout

= Version 1.0.7 =

* Fixed: Escape add_query_arg

= Version 1.0.6 =

* Fixed: Ignore blank lines in ignored-urls list

= Version 1.0.5 =

* Changed: Caching a page can now be prevented via the wptouch_addon_cache_current_page filter

= Version 1.0.4 =

* Fixed: Removed filemtime warnings

= Version 1.0.3 =

* Changed: Moved settings to accommodate multi-ads add-on

= Version 1.0.2 =

* Fixed: An issue with desktop caching on servers with high load

= Version 1.0.1 =

* Fixed: Caching issue with comment forms
