# Laravel WebP Turbo ⚡🖼️

**PHP 8.2+ | Laravel 10/11 | Core Web Vitals Optimized | MIT License**

Zero-configuration **WebP image conversion**, `<picture>` fallback generation, and **Google Core Web Vitals (LCP/CLS)** optimization plugin for Laravel websites and e-commerce platforms.

### ✨ Key Capabilities
* **On-the-Fly WebP Conversion:** Automatically converts `.jpg`, `.jpeg`, and `.png` assets to compressed `.webp` format and caches them in `public/`.
* **LCP Priority Hinting:** Supports `fetchpriority="high"` and `loading="eager"` for above-the-fold hero banners, while defaulting to native `loading="lazy"` and `decoding="async"` for offscreen images.
* **Drop-in Blade Directive:** Render semantic `<picture>` tags with a single `@webp()` directive.

### 📦 Installation
```bash
composer require hirdeshvashishtha/laravel-webp-turbo
php artisan vendor:publish --tag="webp-turbo-config"
```

### 🚀 Usage in Blade Templates
```blade
@webp('images/products/item.jpg', 'Product Image', false, 'product-card-img')
@webp('images/banners/hero.png', 'Enterprise Banner', true, 'w-full hero-banner')
```
