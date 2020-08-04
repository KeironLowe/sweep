# Sweep
Sweep is a simple library for WordPress which removes a lot of the cruft that's included by default, including jQuery, Emojis, DNS Prefetches and more.

## Installation
Installation is done through composer `composer require keironlowe/sweep`.
 
## Usage
Just create a new instance of Sweep and then chain the available methods to remove what you wish.
```
use Sweep\Sweep;

Sweep::create()->removeAll();
```

## Methods

### `removeAll()`

Executes all the removal methods available within the library.

### `removeEmojis()`
Removes the emoji scripts and styles.

### `removeAdminBar()`
Removes the admin bar from the page.

### `removeBlockEditorCss()`
Removes the block editor styles,

### `removeWpDnsPrefetch()` 
Removes the DNS prefetch for https://s.w.org.

### `removeXmlRpcLink()`
Removes the XML-RPC link.

### `removeWordPressVersion()`
Removes the WordPress version number.

### `removeWindowsLiveWriterLink()`
Removes the Windows Live Writer link.

### `removeWpJsonLink()`
Removes the api.w.org WP-JSON link.

### `removeRecentCommentsCSS()`
Removes the CSS for the recent comment's widget.

### `removeJQuery()`
Removes jQuery and in turn, jQuery Migrate. This is probably the most dangerous method, you should onlu use this if you're absolutely sure you and any plugins aren't using jQuery.

### `removeBlockEditor()`
Disables the block editor.

### `removeOEmbed()`
Removes any oEmbed functionality.