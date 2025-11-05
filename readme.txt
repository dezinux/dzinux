=== Dezinux ===
Contributors: dezinux
Tags: custom-logo, one-column, two-columns, translation-ready
Requires at least: 4.9
Tested up to: 6.6
Requires PHP: 7.0
Stable tag: 1.0.2
License: GPL-3.0-or-later
License URI: https://www.gnu.org/licenses/gpl-3.0.html


== Description ==
Ultra‑minimal WordPress theme designed to be lightweight and work great with Elementor. Focuses on speed, clean markup, and essential features only.

== Installation ==
1. Upload the `dezinux` theme folder to `/wp-content/themes/` or install the ZIP via Appearance → Themes → Add New → Upload Theme.
2. Activate via Appearance → Themes.
3. Optional: ensure permalinks are set and Elementor is installed if you plan to use it.

== Automatic Updates ==
Dezinux includes a built‑in updater. When a new version is available, WordPress will offer the update in Dashboard → Updates and Appearance → Themes.

Update source:
- Manifest: `https://releases.dezinux.com/update.json`
- Download: versioned ZIPs such as `https://releases.dezinux.com/dezinux-1.0.3.zip`

Administrators can override the manifest via `wp-config.php`:
`define('DEZINUX_UPDATE_URL', 'https://releases.dezinux.com/update.json');`

== Changelog ==

= 1.0 =
* Added new option

= 0.5 =
* Security bug addressed
* Changed thumbnail size

== Upgrade Notice ==

= 1.0 =
* Upgrade notices describe the reason a user should upgrade.  No more than 300 characters.

= 0.5 =

* This version fixes a security related bug.  Upgrade immediately.

= 1.0.0 =
* 4-Sep-2018
* Initial release

= 1.0.1 =
* 5-Sep-2018
* Minor modifications to pass wordpress.org theme submission guidelines

= 1.0.2 =
* 6-Sep-2018
* Minor modifications to pass wordpress.org theme submission guidelines

= 1.0.3 =
* 13-Sep-2018
* Minor modifications to pass wordpress.org theme submission guidelines
* Tested with Theme Sniffer https://github.com/WPTRT/theme-sniffer
* Tested with Theme Check https://make.wordpress.org/themes/handbook/review/required/theme-check-plugin/

= 1.0.4 =
* 29-Oct-2018
* Changed readme.txt file format to comply with new wordpress.org theme submission guidelines
* Confirm that screenshot complies with new submission guidelines

= 1.0.5 =
* 19-Nov-2018
* Changed title display in header.php and validated readme.txt as suggested at #7 https://themes.trac.wordpress.org/ticket/59550

= 1.0.6 =
* 19-Nov-2018
* Remove duplicate page title from header.php

= 1.0.7 =
* 19-Nov-2018
* Remove a comment left in header.php

= 1.1.0 =
* 13-Mar-2019
* Improve alignment CSS
* Add basic gallery handling CSS

= 1.1.1 =
* 23-Mar-2019
* Removed debugging code left behind in index.php!!!

= 1.1.2 =
* 23-Mar-2019
* Add into functions.php: add_post_type_support( 'page', 'excerpt' );

= 1.1.4 =
* 18-Apr-2021
* 


