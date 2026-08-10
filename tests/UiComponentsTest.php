<?php

declare(strict_types=1);

namespace Yekta\Ui\Tests;

use Illuminate\Support\Facades\Blade;

final class UiComponentsTest extends TestCase
{
    public function test_button_component_renders(): void
    {
        $html = Blade::render('<x-ui::button variant="danger">Delete</x-ui::button>');

        $this->assertStringContainsString('Delete', $html);
        $this->assertStringContainsString('bg-red-600', $html);
    }

    public function test_input_forwards_attributes(): void
    {
        $html = Blade::render('<x-ui::input name="email" type="email" required data-testid="email" />');

        $this->assertStringContainsString('name="email"', $html);
        $this->assertStringContainsString('type="email"', $html);
        $this->assertStringContainsString('data-testid="email"', $html);
    }

    public function test_table_component_renders_package_classes(): void
    {
        $html = Blade::render('<x-ui::table><tbody><tr><td>Row</td></tr></tbody></x-ui::table>');

        $this->assertStringContainsString('ui-table-shell', $html);
        $this->assertStringContainsString('ui-table', $html);
    }
}
