# Flavor Starter — WordPress Vape Store Theme

A bold, dark-themed WooCommerce WordPress theme built for vape & e-cigarette stores.

---

## Requirements

- WordPress 6.0 or higher
- WooCommerce 8.0 or higher
- PHP 8.0 or higher
- MySQL 5.7+ or MariaDB 10.3+

---

## Installation

### Local Development (with LocalWP — Recommended)

1. Download & install **LocalWP** from https://localwp.com
2. Create a new site in LocalWP (e.g., "Vape Store")
3. Copy the entire `flavor-starter` folder into:
   ```
   /app/public/wp-content/themes/
   ```
4. Log in to WordPress Admin
5. Go to **Appearance > Themes** — activate **Flavor Starter**
6. Install & activate **WooCommerce** from **Plugins > Add New**

### Local Development (with XAMPP / MAMP)

1. Install XAMPP (https://www.apachefriends.org/) or MAMP (https://www.mamp.info/)
2. Start Apache & MySQL
3. Create a database named `vape_store` via phpMyAdmin
4. Download WordPress from https://wordpress.org and extract to `htdocs/vape-store/`
5. Copy `flavor-starter` into `htdocs/vape-store/wp-content/themes/`
6. Visit `http://localhost/vape-store` and complete the WordPress install
7. Activate the theme and install WooCommerce

### Live Hosting

1. Purchase hosting (SiteGround, Cloudways, etc.)
2. Install WordPress via the hosting control panel (most have 1-click install)
3. Compress the `flavor-starter` folder into a `.zip` file
4. Go to **Appearance > Themes > Add New > Upload Theme**
5. Upload the `.zip` file and click **Install Now**
6. Click **Activate**
7. Install WooCommerce from **Plugins > Add New**

---

## Initial Setup

### 1. Set Up Your Homepage

1. Go to **Pages > Add New** — create a page called "Home" (leave content empty)
2. Go to **Pages > Add New** — create a page called "Blog"
3. Go to **Settings > Reading**:
   - Set "Your homepage displays" to **A static page**
   - Homepage: **Home**
   - Posts page: **Blog**
4. Save Changes

### 2. Set Up WooCommerce

1. Go to **WooCommerce > Settings** and complete the setup wizard
2. WooCommerce auto-creates required pages (Shop, Cart, Checkout, My Account)
3. Add products via **Products > Add New**
4. Mark products as **Featured** to appear on the homepage

### 3. Configure Menus

1. Go to **Appearance > Menus**
2. Create a menu named "Primary Menu"
   - Add pages: Home, Shop, product categories, etc.
   - Assign to **Primary Menu** location
3. Create a "Footer Menu" for footer links
4. Create a "Mobile Menu" for the mobile navigation

### 4. Add Widgets

1. Go to **Appearance > Widgets**
2. Configure the **Footer Column 1-4** widget areas
3. Configure the **Shop Sidebar** with WooCommerce filter widgets
4. Configure the **Blog Sidebar** with blog-related widgets

### 5. Customize the Theme

1. Go to **Appearance > Customize**
2. Open **Flavor Starter Options** panel
3. Available sections:
   - **Theme Colors** — Change all accent, background, and text colors
   - **Typography** — Select heading, body, and accent fonts
   - **Header** — Toggle top bar, change header layout, set promo text
   - **Hero Banner** — Edit hero title, subtitle, buttons, images
   - **Homepage Sections** — Customize section titles and product counts
   - **Promo Banners** — Edit the two promotional banner cards
   - **Footer** — Newsletter text, copyright, layout, back-to-top
   - **Social Media Links** — Add your social media URLs
   - **Contact Information** — Email, phone, address
   - **Age Verification** — Enable/disable, customize text, set cookie duration
   - **Store Notices** — Free shipping minimum amount

### 6. Set Up Product Categories

1. Go to **Products > Categories**
2. Create categories like: E-Liquids, Vape Kits, Mods, Coils, Accessories
3. Upload category thumbnail images
4. Categories will auto-appear on the homepage and in filters

---

## Features

### Product Cards
- Hover image swap (uses product gallery)
- Quick View button
- Wishlist toggle
- AJAX Add to Cart
- Custom badges: **New** (last 30 days), **Sale** (with % off), **Popular** (featured), **Sold Out**

### Cart Drawer
- Slide-out cart panel
- Update quantities without page reload
- Remove items
- Free shipping progress bar
- Quick link to checkout

### Age Verification
- Cookie-based popup
- Configurable age, text, and cookie duration
- Deny redirects to a configurable URL

### Quick View
- AJAX-loaded product modal
- Image gallery with thumbnails
- Add to cart without leaving the page
- Variable product support (links to product page)

### Wishlist
- Cookie-based (no plugin needed)
- Heart icon toggle on product cards
- Counter in header

---

## Creating a Child Theme

To make modifications that survive theme updates:

1. Create a folder: `wp-content/themes/flavor-starter-child/`
2. Create `style.css`:

```css
/*
Theme Name: Flavor Starter Child
Template: flavor-starter
Version: 1.0.0
*/
```

3. Create `functions.php`:

```php
<?php
function flavor_starter_child_enqueue() {
    wp_enqueue_style(
        'flavor-starter-child',
        get_stylesheet_uri(),
        array( 'flavor-starter-theme' ),
        '1.0.0'
    );
}
add_action( 'wp_enqueue_scripts', 'flavor_starter_child_enqueue' );
```

4. Activate the child theme from **Appearance > Themes**

---

## Theme File Structure

```
flavor-starter/
├── style.css                    # Theme header (required by WP)
├── functions.php                # Theme setup, enqueues, includes
├── index.php                    # Fallback template
├── header.php                   # Site header & navigation
├── footer.php                   # Site footer & modals
├── front-page.php               # Homepage
├── single.php                   # Single blog post
├── page.php                     # Static page
├── archive.php                  # Blog archive
├── search.php                   # Search results
├── 404.php                      # Not found page
├── sidebar.php                  # Sidebar loader
├── comments.php                 # Comments template
├── woocommerce.php              # WooCommerce fallback wrapper
├── screenshot.png               # Theme screenshot
│
├── assets/
│   ├── css/
│   │   ├── theme.css            # Main theme styles
│   │   └── woocommerce.css      # WooCommerce style overrides
│   ├── js/
│   │   ├── theme.js             # Core UI (menu, search, scroll)
│   │   ├── ajax-cart.js         # AJAX add-to-cart & cart drawer
│   │   ├── quick-view.js        # Product quick view modal
│   │   ├── age-verify.js        # Age verification popup
│   │   └── customizer.js        # Live preview in Customizer
│   └── images/
│
├── inc/
│   ├── customizer.php           # All Customizer panels/sections/settings
│   ├── template-tags.php        # Reusable display functions
│   ├── template-functions.php   # Hook-based modifications
│   ├── woocommerce.php          # WooCommerce integration & hooks
│   ├── ajax-handlers.php        # AJAX endpoints (cart, wishlist, quick view)
│   └── widgets.php              # Custom widgets
│
├── template-parts/
│   ├── hero-banner.php          # Hero section
│   ├── featured-categories.php  # Category grid
│   ├── featured-products.php    # Featured product grid
│   ├── new-arrivals.php         # New arrivals section
│   ├── promo-banner.php         # Twin promo cards
│   ├── trust-bar.php            # Features/trust bar
│   ├── latest-posts.php         # Blog posts on homepage
│   ├── cart-drawer.php          # Slide-out cart
│   ├── content.php              # Blog post card
│   ├── content-single.php       # Single post layout
│   ├── content-page.php         # Static page layout
│   └── content-none.php         # No results message
│
├── woocommerce/
│   ├── archive-product.php      # Shop page with sidebar & toolbar
│   ├── content-product.php      # Product card in loops
│   ├── single-product.php       # Single product wrapper
│   ├── cart/
│   │   └── mini-cart.php        # Mini-cart widget
│   └── single-product/
│       └── quick-view.php       # Quick view AJAX template
│
└── docs/
    └── README.md                # This file
```

---

## Customizer Options Reference

| Section | Setting | Default |
|---------|---------|---------|
| Colors | Accent Primary | `#8b5cf6` |
| Colors | Accent Secondary | `#06b6d4` |
| Colors | Accent Tertiary | `#ec4899` |
| Colors | Background Primary | `#0a0a0f` |
| Colors | Background Secondary | `#12121a` |
| Colors | Card Background | `#1a1a25` |
| Colors | Text Primary | `#f1f1f4` |
| Colors | Text Secondary | `#a1a1b5` |
| Typography | Heading Font | Outfit |
| Typography | Body Font | DM Sans |
| Typography | Accent Font | Space Mono |
| Header | Layout | Default (Logo Left) |
| Header | Show Top Bar | Yes |
| Age Verify | Enabled | Yes |
| Age Verify | Cookie Days | 30 |
| Store | Free Shipping Min | $50 |

---

## Performance Notes

- All CSS is loaded as two files (theme + woocommerce)
- All JS is loaded in the footer with `defer`
- Images use native `loading="lazy"` attributes
- Google Fonts use `display=swap` for FOIT prevention
- Fonts are preconnected in `<head>`
- Intersection Observer powers scroll animations (no heavy libraries)
- No jQuery dependency for age verification or main theme JS
- AJAX cart avoids full page reloads

---

## Security

- All AJAX handlers use `check_ajax_referer()` with nonces
- All user input is sanitized with appropriate WordPress functions
- All output is escaped with `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`
- Cookie-based wishlist uses `HttpOnly` flag
- No direct file access — all files check `defined('ABSPATH')`

---

## Browser Support

- Chrome 90+
- Firefox 90+
- Safari 14+
- Edge 90+
- Mobile Safari (iOS 14+)
- Chrome for Android

---

## Credits

- Fonts: Google Fonts (Outfit, DM Sans, Space Mono)
- Icons: Feather Icons (inline SVG)
- Framework: WordPress + WooCommerce

---

## License

GPL v2 or later — https://www.gnu.org/licenses/gpl-2.0.html
