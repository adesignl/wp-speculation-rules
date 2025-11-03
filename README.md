# WordPress Speculation Rules API

This PHP code implements the **Speculation Rules API** for WordPress, which improves website performance by intelligently prefetching and prerendering pages before users navigate to them.

## Overview

The Speculation Rules API is a modern web standard that allows browsers to automatically load resources in advance based on user behavior patterns. This implementation adds the necessary configuration to your WordPress site's frontend to take advantage of this performance optimization.

## What It Does

The code defines two types of speculative loading:

### Prefetch
- **Purpose**: Browsers download the HTML document in the background without rendering it
- **Eagerness**: `moderate` – Balances performance with resource usage
- **Use Case**: Good for pages users are likely to visit

### Prerender
- **Purpose**: Browsers not only download but also fully render the page in the background
- **Eagerness**: `conservative` – Only activates for high-confidence predictions
- **Use Case**: Best for pages users are very likely to visit (e.g., next article in a series)

## How It Works

1. The function scans all links on your WordPress site
2. It identifies which links are good candidates for prefetching/prerendering
3. It excludes URLs that shouldn't be preloaded (admin pages, login, downloads, etc.)
4. It outputs a `<script type="speculationrules">` tag with the configuration in your site's `<head>`

## Exclusions

The code automatically excludes the following from prefetching/prerendering:

- WordPress admin pages (`/wp-admin/*`)
- WordPress login page (`/wp-login.php`)
- ZIP files (`*.zip`)
- PDF files (`*.pdf`)
- Links with the `.no-prefetch` CSS class (prefetch only)
- Links with the `.no-prerender` CSS class (prerender only)

## Installation

1. Add this code to your WordPress theme's `functions.php` file, or
2. Create a custom plugin and add this code to it

## Usage

### Basic Usage

The code works automatically once installed. No additional configuration needed.

### Prevent Specific Links from Prefetching

Add the `no-prefetch` class to any link you want to exclude from prefetching:

```html
<a href="/some-page" class="no-prefetch">Don't prefetch this</a>
```

### Prevent Specific Links from Prerendering

Add the `no-prerender` class to any link you want to exclude from prerendering:

```html
<a href="/some-page" class="no-prerender">Don't prerender this</a>
```

## Browser Support

The Speculation Rules API is supported in:
- Chrome/Chromium-based browsers (version 121+)
- Edge (version 121+)
- Other Chromium browsers

Browsers that don't support it safely ignore the script tag.

## Performance Benefits

- **Faster perceived page loads** for users who click prefetched/prerendered links
- **Reduced bounce rates** by improving user experience
- **Better Core Web Vitals** scores
- **Smart resource management** through eagerness levels

## Notes

- The function only runs on the frontend (`is_admin()` check prevents it from running in WordPress admin)
- The script is injected into `wp_head` with priority 2
- The speculation rules are output as JSON for browser interpretation
- Invalid URLs and file downloads are automatically excluded to prevent wasted resources

## Browser Behavior

Browsers decide when to act on these rules based on:
- Available network bandwidth
- Device battery level
- User preferences
- Current device load

This ensures prefetching/prerendering won't negatively impact device performance.

## References

- [MDN: Speculation Rules API](https://developer.mozilla.org/en-US/docs/Web/API/Speculation_Rules_API)
- [W3C Specification](https://wicg.github.io/nav-speculation/speculation-rules.html)
- [Chrome DevTools Guide](https://developer.chrome.com/docs/devtools/performance/speculation-rules-api)

## Troubleshooting

**Speculation rules not showing**: Check that the code is in your `functions.php` or active plugin, and verify you're viewing the frontend (not admin).

**Links not being prefetched**: Check browser console to ensure no JavaScript errors. Verify the links don't have exclusion classes and aren't in the excluded URL patterns.

**Performance issues**: If you notice slowdowns, adjust eagerness levels from `moderate`/`conservative` to something lower, or add `no-prefetch` classes to high-traffic pages that shouldn't be preloaded.
