# Optimize WP (Lightweight)

Lightweight WordPress plugin that turns on a curated set of optimizations with **no settings screen**. Just activate the plugin and it will clean up and slightly harden a standard WordPress install without breaking core features like the block editor.

## What it does

- **Disables emojis**: Removes emoji scripts/styles and related filters on both front-end and admin.
- **Disables embeds**: Turns off oEmbed discovery, REST oEmbed endpoints, and auto-embeds on the front-end.
- **Cleans up `<head>`**:
  - Removes feed links (main and extra)
  - Removes RSD and Windows Live Writer links
  - Removes shortlink output
  - Hides the WordPress version generator tag
- **Disables feeds**: All feed endpoints (RSS, RSS2, RDF, Atom, and comments variants) return a simple message with a 404 status.
- **Improves asset cacheability**: Strips the `ver` query argument from script and style URLs.
- **Removes self-pingbacks**: Prevents WordPress from pinging its own URLs.
- **Disables dashicons for visitors**: Deregisters the `dashicons` style for non-logged-in users on the front-end.

## Installation

1. Copy this folder to your WordPress installation under `wp-content/plugins/optimize-wp`.
2. Ensure the main plugin file is named `optimize-wp.php`.
3. Activate **Optimize WP (Lightweight)** from the **Plugins → Installed Plugins** screen.

There is no settings page. Deactivate the plugin to restore the default WordPress behavior.

## Future enhancements

Potential future additions (behind an options screen) could include:

- Toggling each optimization individually.
- Controlling which feeds remain enabled (e.g. main posts feed only).
- More granular control over REST API hardening.
- Front-end-only script/style tweaks specific to your theme.

