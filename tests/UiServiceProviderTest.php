<?php

declare(strict_types=1);

namespace Yekta\Ui\Tests;

use Yekta\Ui\UiServiceProvider;

final class UiServiceProviderTest extends TestCase
{
    public function test_package_views_are_registered(): void
    {
        $this->assertTrue(view()->exists('ui::components.button'));
        $this->assertTrue(view()->exists('ui::components.input'));
        $this->assertTrue(view()->exists('ui::components.empty-state'));
    }

    public function test_package_translations_are_registered(): void
    {
        $this->app->setLocale('en');
        $this->assertSame('No items found.', __('ui::ui.empty'));

        $this->app->setLocale('fa');
        $this->assertSame('موردی یافت نشد.', __('ui::ui.empty'));
    }

    public function test_view_publish_group_is_registered(): void
    {
        $paths = UiServiceProvider::pathsToPublish(UiServiceProvider::class, 'ui-views');

        $this->assertNotEmpty($paths);
        $this->assertContains(resource_path('views/vendor/ui'), array_values($paths));
    }

    public function test_css_publish_group_is_registered(): void
    {
        $paths = UiServiceProvider::pathsToPublish(UiServiceProvider::class, 'ui-css');

        $this->assertNotEmpty($paths);
        $this->assertContains(resource_path('css/vendor/ui.css'), array_values($paths));
    }

    public function test_translation_publish_group_is_registered(): void
    {
        $paths = UiServiceProvider::pathsToPublish(UiServiceProvider::class, 'ui-translations');

        $this->assertNotEmpty($paths);
        $this->assertContains(lang_path('vendor/ui'), array_values($paths));
    }
}
