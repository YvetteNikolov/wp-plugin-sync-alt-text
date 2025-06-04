=== Sync Alt Text ===
Contributors:      Yvette Nikolov
Tags:              alt text, image, media, gallery, Gutenberg, block
Tested up to:      6.7
Stable tag:        0.1.0
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:       sync-alt-text

== Description ==

Sync Alt Text automatically updates the alt text of images within `core/image`, `core/cover`, `core/media-text`, and `core/gallery` blocks. It syncs alt text from the block editor to the image metadata, improving accessibility and SEO.

The plugin works automatically when posts are saved, processing nested galleries and media blocks as well.

== Installation ==

1. Upload to `/wp-content/plugins/sync-alt-text` or install via the WordPress plugin screen.
2. Activate through the 'Plugins' menu.

== Frequently Asked Questions ==

= Which blocks are supported? =

Supported blocks include:
- `core/image`
- `core/cover`
- `core/media-text`
- `core/gallery` (due to nested `core/image` blocks)

= Does this overwrite existing alt text? =

Yes, it updates the image alt text in the database based on the block content.

== Changelog ==

= 0.1.0 =
* Initial release: syncs alt text for supported blocks.

