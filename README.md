# UI

Reusable Blade UI components for Laravel 13 applications.

`yekta-kalantary/ui` is the presentation-layer package. It contains generic Blade components and Tailwind CSS helpers only. It has no Livewire dependency and no application/domain logic.

## Requirements

- PHP 8.3+
- Laravel 13
- Tailwind CSS 4 for the provided styles

## Installation

```bash
composer require yekta-kalantary/ui
```

If the package is not published on Packagist yet, add the GitHub repository to the consuming application's root `composer.json`:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/yekta-kalantary/ui"
        }
    ]
}
```

Then require the development branch:

```bash
composer require yekta-kalantary/ui:dev-main
```

Laravel package discovery registers `Yekta\\Ui\\UiServiceProvider` automatically.

## Tailwind CSS 4

Add the package views to Tailwind's source scan and import the optional package CSS from your application's `resources/css/app.css`:

```css
@import 'tailwindcss';
@import '../../vendor/yekta-kalantary/ui/resources/css/ui.css';

@source '../../vendor/yekta-kalantary/ui/resources/views/**/*.blade.php';
```

The package intentionally does not force a font, `dir="rtl"`, locale, or color theme. Those remain application concerns.

## Components

```blade
<x-ui::button>ذخیره</x-ui::button>

<x-ui::input
    name="first_name"
    label="نام"
    required
/>

<x-ui::textarea
    name="description"
    label="توضیحات"
/>

<x-ui::select name="status" label="وضعیت">
    <option value="active">فعال</option>
    <option value="inactive">غیرفعال</option>
</x-ui::select>

<x-ui::checkbox name="enabled" label="فعال" />

<x-ui::card>
    محتوا
</x-ui::card>

<x-ui::badge variant="success">فعال</x-ui::badge>

<x-ui::alert variant="danger">خطایی رخ داده است.</x-ui::alert>

<x-ui::table>
    <thead>...</thead>
    <tbody>...</tbody>
</x-ui::table>
```

All components forward unknown HTML attributes, so Alpine and Livewire directives can be passed by consuming applications without this package depending on either framework:

```blade
<x-ui::input wire:model.live="search" />
```

## Publishing

Publish views only when an application needs to override markup:

```bash
php artisan vendor:publish --tag=ui-views
```

Publish the CSS when you intentionally want an application-owned copy:

```bash
php artisan vendor:publish --tag=ui-css
```

## Development

```bash
composer install
composer test
```

## Architecture rule

This package must remain generic. Components such as `ContactForm`, `TicketReply`, database search providers, authorization rules, routes, and Eloquent models belong to the consuming application or to a higher-level package such as `ui-livewire`.

## License

MIT
