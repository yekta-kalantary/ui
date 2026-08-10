# UI

Reusable Blade UI components for Laravel applications.

`yekta-kalantary/ui` is the base presentation package. It contains generic Blade components and Tailwind CSS helpers only. It has no Livewire dependency and no application or domain logic.

- Packagist: https://packagist.org/packages/yekta-kalantary/ui
- Source: https://github.com/yekta-kalantary/ui

## Requirements

- PHP 8.3+
- Laravel 13
- Tailwind CSS 4 when using the bundled styles

## Installation

The package is available on Packagist. No custom Composer repository is required.

Until the first stable release tag is published, install the development branch explicitly:

```bash
composer require yekta-kalantary/ui:dev-main
```

Laravel package discovery registers `Yekta\Ui\UiServiceProvider` automatically.

After a stable release is tagged, the version suffix can be omitted:

```bash
composer require yekta-kalantary/ui
```

## Tailwind CSS 4

The package ships Blade markup and a small Tailwind stylesheet. Add the package views to Tailwind's source scan and import the stylesheet from your application's `resources/css/app.css`:

```css
@import 'tailwindcss';
@import '../../vendor/yekta-kalantary/ui/resources/css/ui.css';

@source '../../vendor/yekta-kalantary/ui/resources/views/**/*.blade.php';
```

Adjust the relative paths if your main stylesheet is located elsewhere.

The package intentionally does not enforce a font, text direction, locale, or application theme. Those remain responsibilities of the consuming application.

## Components

All Blade components use the `ui` namespace.

### Button

```blade
<x-ui::button type="submit">
    ذخیره
</x-ui::button>
```

### Input

```blade
<x-ui::input
    name="first_name"
    label="نام"
    required
/>
```

Laravel validation errors are resolved automatically when a field has a `name`. An explicit error can also be passed when needed.

### Textarea

```blade
<x-ui::textarea
    name="description"
    label="توضیحات"
/>
```

### Select

```blade
<x-ui::select name="status" label="وضعیت">
    <option value="active">فعال</option>
    <option value="inactive">غیرفعال</option>
</x-ui::select>
```

### Checkbox

```blade
<x-ui::checkbox
    name="enabled"
    label="فعال"
    :checked="true"
/>
```

### Card

```blade
<x-ui::card>
    محتوا
</x-ui::card>
```

### Badge

```blade
<x-ui::badge variant="success">
    فعال
</x-ui::badge>
```

### Alert

```blade
<x-ui::alert variant="danger">
    خطایی رخ داده است.
</x-ui::alert>
```

### Table

```blade
<x-ui::table>
    <thead>
        <tr>
            <th>نام</th>
            <th>موبایل</th>
        </tr>
    </thead>
    <tbody>
        ...
    </tbody>
</x-ui::table>
```

### Empty state

```blade
<x-ui::empty-state
    title="موردی یافت نشد"
    description="برای شروع یک مورد جدید ایجاد کنید."
/>
```

## HTML, Alpine and Livewire attributes

Components forward unknown HTML attributes. This keeps the base package independent while allowing a consuming application to attach Alpine or Livewire behavior when needed.

```blade
<x-ui::input
    wire:model.live="search"
    x-on:focus="open = true"
/>
```

The `ui` package itself does not depend on Alpine or Livewire.

## Localization

The package currently includes English and Persian translation resources. Laravel's active locale determines which translation is used.

Publish translations only when the application needs to override package copy:

```bash
php artisan vendor:publish --tag=ui-translations
```

Published translations are written to:

```text
lang/vendor/ui
```

## Publishing views

Package views can be overridden by publishing them:

```bash
php artisan vendor:publish --tag=ui-views
```

Published views are written to:

```text
resources/views/vendor/ui
```

Publishing views is optional. Prefer using the package views directly unless an application-specific override is necessary.

## Publishing CSS

Publish the stylesheet only when the application intentionally needs to own and modify a local copy:

```bash
php artisan vendor:publish --tag=ui-css
```

The published file is written to:

```text
resources/css/vendor/ui.css
```

## Architecture

This package must stay generic and presentation-only.

The following belong here:

- Blade primitives
- visual states
- validation presentation
- reusable layout helpers
- generic Tailwind styles

The following do not belong here:

- Eloquent models
- database queries
- application routes
- authorization rules
- business terminology such as contacts, clients or tickets
- Livewire components

Interactive Livewire components belong in `yekta-kalantary/ui-livewire`.

## Development

Install dependencies and run the test suite:

```bash
composer install
composer test
```

Current development dependencies target Laravel 13 through Orchestra Testbench 11.

## License

MIT
