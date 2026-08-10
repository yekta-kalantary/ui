<?php

declare(strict_types=1);

namespace Yekta\Ui\Tests;

use Illuminate\Support\Facades\Blade;

final class UiComponentsTest extends TestCase
{
    public function test_button_renders_variant_size_and_html_attributes(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-ui::button
                type="submit"
                variant="danger"
                size="lg"
                data-testid="delete-button"
            >
                Delete
            </x-ui::button>
        BLADE);

        $this->assertStringContainsString('type="submit"', $html);
        $this->assertStringContainsString('bg-red-600', $html);
        $this->assertStringContainsString('px-5 py-2.5 text-base', $html);
        $this->assertStringContainsString('data-testid="delete-button"', $html);
        $this->assertStringContainsString('Delete', $html);
    }

    public function test_button_falls_back_to_default_variant_and_size(): void
    {
        $html = Blade::render('<x-ui::button variant="unknown" size="unknown" disabled>Save</x-ui::button>');

        $this->assertStringContainsString('bg-slate-900', $html);
        $this->assertStringContainsString('px-4 py-2 text-sm', $html);
        $this->assertStringContainsString('disabled', $html);
    }

    public function test_alert_and_badge_render_supported_variants(): void
    {
        $alert = Blade::render('<x-ui::alert variant="warning">Warning</x-ui::alert>');
        $badge = Blade::render('<x-ui::badge variant="success">Active</x-ui::badge>');

        $this->assertStringContainsString('role="alert"', $alert);
        $this->assertStringContainsString('bg-amber-50', $alert);
        $this->assertStringContainsString('Warning', $alert);

        $this->assertStringContainsString('bg-emerald-50', $badge);
        $this->assertStringContainsString('Active', $badge);
    }

    public function test_alert_and_badge_fall_back_to_their_default_variants(): void
    {
        $alert = Blade::render('<x-ui::alert variant="unknown">Alert</x-ui::alert>');
        $badge = Blade::render('<x-ui::badge variant="unknown">Badge</x-ui::badge>');

        $this->assertStringContainsString('bg-sky-50', $alert);
        $this->assertStringContainsString('bg-slate-100', $badge);
    }

    public function test_card_renders_header_body_footer_and_attributes(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-ui::card data-testid="profile-card">
                <x-slot:header>Profile</x-slot:header>
                Body
                <x-slot:footer>Actions</x-slot:footer>
            </x-ui::card>
        BLADE);

        $this->assertStringContainsString('data-testid="profile-card"', $html);
        $this->assertStringContainsString('<header', $html);
        $this->assertStringContainsString('Profile', $html);
        $this->assertStringContainsString('Body', $html);
        $this->assertStringContainsString('<footer', $html);
        $this->assertStringContainsString('Actions', $html);
    }

    public function test_table_renders_wrapper_table_classes_and_attributes(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-ui::table data-testid="users-table">
                <tbody><tr><td>Row</td></tr></tbody>
            </x-ui::table>
        BLADE);

        $this->assertStringContainsString('ui-table-shell', $html);
        $this->assertStringContainsString('ui-table', $html);
        $this->assertStringContainsString('data-testid="users-table"', $html);
        $this->assertStringContainsString('Row', $html);
    }

    public function test_empty_state_uses_translated_default_title(): void
    {
        $this->app->setLocale('en');

        $html = Blade::render('<x-ui::empty-state />');

        $this->assertStringContainsString('No items found.', $html);
    }

    public function test_empty_state_accepts_title_description_slot_and_attributes(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-ui::empty-state
                title="Nothing here"
                description="Create the first record."
                data-testid="empty-state"
            >
                <button type="button">Create</button>
            </x-ui::empty-state>
        BLADE);

        $this->assertStringContainsString('Nothing here', $html);
        $this->assertStringContainsString('Create the first record.', $html);
        $this->assertStringContainsString('data-testid="empty-state"', $html);
        $this->assertStringContainsString('Create', $html);
    }
}
