<?php

declare(strict_types=1);

namespace Yekta\Ui;

use Illuminate\Support\ServiceProvider;

final class UiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ui');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ui');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/ui'),
        ], 'ui-views');

        $this->publishes([
            __DIR__.'/../resources/css/ui.css' => resource_path('css/vendor/ui.css'),
        ], 'ui-css');

        $this->publishes([
            __DIR__.'/../resources/lang' => lang_path('vendor/ui'),
        ], 'ui-translations');
    }
}
