# UI

Reusable Blade UI primitives for Laravel applications.

`yekta-kalantary/ui` is the base presentation package for shared UI. It contains generic Blade components, package translations, and a small Tailwind CSS layer. It intentionally has no Livewire dependency and no application/domain logic.

- Packagist: https://packagist.org/packages/yekta-kalantary/ui
- Source: https://github.com/yekta-kalantary/ui
- Issues: https://github.com/yekta-kalantary/ui/issues

## Requirements

- PHP 8.3+
- Laravel 13
- Tailwind CSS 4 when using the bundled styling

## Installation

The package is available through Packagist, so no custom Composer repository is required.

Until the first stable tag is published, install the development branch explicitly:

```bash
composer require yekta-kalantary/ui:dev-main
```

The `main` branch is aliased to `1.0.x-dev` for Composer version resolution.

After a stable `1.x` release is tagged, installation becomes:

```bash
composer require yekta-kalantary/ui
```

Laravel package discovery registers `Yekta\Ui\UiServiceProvider` automatically.

## Tailwind CSS 4 setup

Add the package stylesheet and Blade sources to the consuming application's main stylesheet, usually `resources/css/app.css`:

```css
@import 'tailwindcss';
@import '../../vendor/yekta-kalantary/ui/resources/css/ui.css';

@source '../../vendor/yekta-kalantary/ui/resources/views/**/*.blade.php';
```

The `@source` directive is required because most component classes live directly inside package Blade views. Without it, Tailwind may omit those classes from the generated CSS.

The package does not force:

- a font family
- RTL or LTR direction
- application locale
- application color tokens
- JavaScript framework
- Livewire

Those remain application concerns.

See [Styling and Tailwind](docs/styling.md) for the complete integration notes.

## Quick start

```blade
<x-ui::card>
    <x-slot:header>
        اطلاعات مخاطب
    </x-slot:header>

    <div class="space-y-4">
        <x-ui::input
            name="first_name"
            label="نام"
            required
        />

        <x-ui::input
            name="mobile"
            label="موبایل"
            required
        />

        <x-ui::textarea
            name="description"
            label="توضیحات"
        />

        <div class="flex justify-end">
            <x-ui::button type="submit">
                ذخیره
            </x-ui::button>
        </div>
    </div>
</x-ui::card>
```

## Components

The package currently ships these Blade components:

| Component | Purpose |
| --- | --- |
| `<x-ui::button>` | Buttons with variant, size, disabled state and attribute forwarding |
| `<x-ui::input>` | Text-like inputs with label, value, hint and validation error presentation |
| `<x-ui::textarea>` | Multiline input with label, rows, hint and validation error presentation |
| `<x-ui::select>` | Native select wrapper with label, hint and validation error presentation |
| `<x-ui::checkbox>` | Checkbox with label, checked state and validation error presentation |
| `<x-ui::card>` | Container with optional header and footer slots |
| `<x-ui::alert>` | Alert message with semantic visual variants |
| `<x-ui::badge>` | Compact status badge with visual variants |
| `<x-ui::table>` | Responsive table shell and shared table classes |
| `<x-ui::empty-state>` | Empty-state message with localization, description and action slot |

For every prop, default, variant, slot and example, see [Component reference](docs/components.md).

## Attribute forwarding

Unknown attributes are forwarded to the underlying element wherever possible. This allows the base package to remain independent while consumers attach framework behavior themselves.

```blade
<x-ui::input
    name="search"
    wire:model.live="search"
    x-on:focus="open = true"
    data-testid="search-input"
/>
```

`ui` does not need Livewire or Alpine to support these attributes.

## Validation errors

Form components can resolve Laravel's default validation error bag by field name:

```blade
<x-ui::input
    name="email"
    label="ایمیل"
    hint="ایمیل کاری را وارد کنید."
/>
```

If `$errors->first('email')` has a value, the component displays the error and suppresses the hint.

An explicit error can also be passed:

```blade
<x-ui::input
    name="email"
    label="ایمیل"
    error="این ایمیل قابل استفاده نیست."
/>
```

## Localization

English and Persian translations are included. The active Laravel locale controls built-in package copy.

```php
app()->setLocale('fa');
```

Publish translations only when an application needs to override them:

```bash
php artisan vendor:publish --tag=ui-translations
```

Published location:

```text
lang/vendor/ui
```

See [Localization](docs/localization.md) for details.

## Publishing package resources

Publishing is optional. Prefer package-owned resources until the application genuinely needs an override.

### Views

```bash
php artisan vendor:publish --tag=ui-views
```

Destination:

```text
resources/views/vendor/ui
```

### CSS

```bash
php artisan vendor:publish --tag=ui-css
```

Destination:

```text
resources/css/vendor/ui.css
```

### Translations

```bash
php artisan vendor:publish --tag=ui-translations
```

Destination:

```text
lang/vendor/ui
```

## Package boundaries

This package is intentionally presentation-only.

Belongs in `ui`:

- generic Blade primitives
- generic visual states
- reusable form presentation
- generic layout containers
- translation strings owned by those primitives
- Tailwind helpers used by those primitives

Does not belong in `ui`:

- Eloquent models
- database queries
- routes
- authorization policies
- permissions
- business terms such as contacts, clients, tickets or projects
- Livewire components
- application-specific workflows

Interactive Livewire components belong in `yekta-kalantary/ui-livewire`.

See [Architecture and package development](docs/development.md).

## Development

```bash
git clone https://github.com/yekta-kalantary/ui.git
cd ui
composer update
composer test
```

Validate package metadata separately with:

```bash
composer validate --strict
```

The CI matrix covers:

- PHP 8.3
- PHP 8.4
- lowest supported dependency versions
- highest matching dependency versions

## Documentation

- [Component reference](docs/components.md)
- [Styling and Tailwind](docs/styling.md)
- [Localization](docs/localization.md)
- [Architecture, testing and development](docs/development.md)

## License

MIT
