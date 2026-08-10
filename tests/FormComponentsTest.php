<?php

declare(strict_types=1);

namespace Yekta\Ui\Tests;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

final class FormComponentsTest extends TestCase
{
    public function test_input_renders_label_generated_id_value_and_attributes(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-ui::input
                name="profile.email"
                type="email"
                label="Email"
                value="yekta@example.com"
                required
                data-testid="email-input"
            />
        BLADE);

        $this->assertStringContainsString('for="ui-profile-email"', $html);
        $this->assertStringContainsString('id="ui-profile-email"', $html);
        $this->assertStringContainsString('name="profile.email"', $html);
        $this->assertStringContainsString('type="email"', $html);
        $this->assertStringContainsString('value="yekta@example.com"', $html);
        $this->assertStringContainsString('required', $html);
        $this->assertStringContainsString('data-testid="email-input"', $html);
    }

    public function test_input_uses_validation_error_and_hides_hint(): void
    {
        $this->shareErrors(['email' => ['Email is required.']]);

        $html = Blade::render('<x-ui::input name="email" hint="We will not share it." />');

        $this->assertStringContainsString('Email is required.', $html);
        $this->assertStringContainsString('border-red-300', $html);
        $this->assertStringNotContainsString('We will not share it.', $html);
    }

    public function test_input_accepts_explicit_error_and_custom_id(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-ui::input
                id="login-email"
                name="email"
                label="Email"
                error="Invalid email."
            />
        BLADE);

        $this->assertStringContainsString('for="login-email"', $html);
        $this->assertStringContainsString('id="login-email"', $html);
        $this->assertStringContainsString('Invalid email.', $html);
    }

    public function test_password_input_does_not_render_a_value_attribute(): void
    {
        $html = Blade::render('<x-ui::input name="password" type="password" value="secret" />');

        $this->assertStringNotContainsString('value="secret"', $html);
    }

    public function test_input_forwards_livewire_and_alpine_attributes(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-ui::input
                name="search"
                wire:model.live="search"
                x-on:focus="open = true"
            />
        BLADE);

        $this->assertStringContainsString('wire:model.live="search"', $html);
        $this->assertStringContainsString('x-on:focus="open = true"', $html);
    }

    public function test_textarea_renders_value_rows_hint_and_attributes(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-ui::textarea
                name="description"
                label="Description"
                value="Current value"
                hint="Optional"
                :rows="6"
                data-testid="description"
            />
        BLADE);

        $this->assertStringContainsString('for="ui-description"', $html);
        $this->assertStringContainsString('rows="6"', $html);
        $this->assertStringContainsString('Current value', $html);
        $this->assertStringContainsString('Optional', $html);
        $this->assertStringContainsString('data-testid="description"', $html);
    }

    public function test_select_renders_slot_hint_and_attributes(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-ui::select name="status" label="Status" hint="Choose a status" required>
                <option value="active">Active</option>
            </x-ui::select>
        BLADE);

        $this->assertStringContainsString('for="ui-status"', $html);
        $this->assertStringContainsString('name="status"', $html);
        $this->assertStringContainsString('required', $html);
        $this->assertStringContainsString('<option value="active">Active</option>', $html);
        $this->assertStringContainsString('Choose a status', $html);
    }

    public function test_checkbox_renders_checked_state_label_and_attributes(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-ui::checkbox
                name="enabled"
                label="Enabled"
                value="yes"
                :checked="true"
                data-testid="enabled-checkbox"
            />
        BLADE);

        $this->assertStringContainsString('id="ui-enabled"', $html);
        $this->assertStringContainsString('name="enabled"', $html);
        $this->assertStringContainsString('value="yes"', $html);
        $this->assertStringContainsString('checked', $html);
        $this->assertStringContainsString('Enabled', $html);
        $this->assertStringContainsString('data-testid="enabled-checkbox"', $html);
    }

    public function test_checkbox_renders_validation_error(): void
    {
        $this->shareErrors(['terms' => ['You must accept the terms.']]);

        $html = Blade::render('<x-ui::checkbox name="terms" label="Terms" />');

        $this->assertStringContainsString('You must accept the terms.', $html);
    }

    private function shareErrors(array $messages): void
    {
        $errors = new ViewErrorBag();
        $errors->put('default', new MessageBag($messages));

        $this->app['view']->share('errors', $errors);
    }
}
