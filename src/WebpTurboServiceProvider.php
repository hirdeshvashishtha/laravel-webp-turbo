<?php

namespace HirdeshVashishtha\WebpTurbo;

use HirdeshVashishtha\WebpTurbo\Services\WebpConverter;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class WebpTurboServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/webp-turbo.php', 'webp-turbo');
        $this->app->singleton(WebpConverter::class, fn () => new WebpConverter());
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/webp-turbo.php' => config_path('webp-turbo.php'),
            ], 'webp-turbo-config');
        }

        Blade::directive('webp', function (string $expression) {
            return "<?php echo app(\HirdeshVashishtha\WebpTurbo\Services\WebpConverter::class)->renderHtml($expression); ?>";
        });
    }
}
