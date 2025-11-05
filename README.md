# Dezinux — WordPress Theme

Ultra‑minimal WordPress theme designed to be lightweight and work great with Elementor. Focuses on speed, clean markup, and essential features only.

## Requirements
- WordPress 4.9+
- PHP 7.0+

## Installation
1. Download the release ZIP (e.g., `dezinux-1.0.3.zip`).
2. In WordPress: Appearance → Themes → Add New → Upload Theme, select the ZIP, and activate.
3. Or upload the unzipped `dezinux/` folder to `wp-content/themes/` and activate.

## Automatic Updates
Dezinux includes a built‑in updater. When a new version is available, WordPress will show an update in Dashboard → Updates and Appearance → Themes.

- Manifest: `https://releases.dezinux.com/update.json`
- ZIP downloads: `https://releases.dezinux.com/dezinux-<version>.zip`

Override the manifest URL via `wp-config.php`:
```php
define('DEZINUX_UPDATE_URL', 'https://releases.dezinux.com/update.json');
```

## Development
- Make changes in the theme directory.
- Update the version in `style.css` when you prepare a release.
- Package as a ZIP with a top-level `dezinux/` folder.
- Publish the ZIP to `https://releases.dezinux.com/` and update `update.json`.

## License
GPL-3.0-or-later. See `LICENSE`.

© Dezinux LLP.

