<?php

namespace HirdeshVashishtha\WebpTurbo\Services;

class WebpConverter
{
    public function convertAndCache(string $sourcePath, ?int $quality = null): string
    {
        $quality ??= (int) config('webp-turbo.quality', 82);
        $webpPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', $sourcePath);

        if (file_exists(public_path($webpPath))) {
            return asset($webpPath);
        }

        $fullSource = public_path($sourcePath);
        if (! file_exists($fullSource)) {
            return asset($sourcePath);
        }

        $info = @getimagesize($fullSource);
        $image = match ($info['mime'] ?? '') {
            'image/jpeg' => @imagecreatefromjpeg($fullSource),
            'image/png'  => $this->preparePng($fullSource),
            default      => null,
        };

        if (! $image) {
            return asset($sourcePath);
        }

        imagewebp($image, public_path($webpPath), $quality);
        imagedestroy($image);

        return asset($webpPath);
    }

    protected function preparePng(string $path)
    {
        $img = @imagecreatefrompng($path);
        if (! $img) {
            return null;
        }
        imagepalettetotruecolor($img);
        imagealphablending($img, true);
        imagesavealpha($img, true);
        return $img;
    }

    public function renderHtml(string $src, string $alt = '', bool $priority = false, string $class = ''): string
    {
        $webpUrl = $this->convertAndCache($src);
        $fallbackUrl = asset($src);
        $loading = $priority ? 'eager' : 'lazy';
        $fetchPriority = $priority ? 'high' : 'auto';

        return sprintf(
            '<picture><source srcset="%s" type="image/webp"><img src="%s" alt="%s" class="%s" loading="%s" fetchpriority="%s" decoding="async"></picture>',
            htmlspecialchars($webpUrl, ENT_QUOTES),
            htmlspecialchars($fallbackUrl, ENT_QUOTES),
            htmlspecialchars($alt, ENT_QUOTES),
            htmlspecialchars($class, ENT_QUOTES),
            $loading,
            $fetchPriority
        );
    }
}
