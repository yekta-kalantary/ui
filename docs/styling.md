# Styling and Tailwind

The package is built for Tailwind CSS 4, but it does not own the consuming application's Tailwind entrypoint, font, direction, theme or build pipeline.

## Required Tailwind setup

In a typical Laravel application, add the package stylesheet and package Blade views to `resources/css/app.css`:

```css
@import 'tailwindcss';
@import '../../vendor/yekta-kalantary/ui/resources/css/ui.css';

@source '../../vendor/yekta-kalantary/ui/resources/views/**/*.blade.php';
```

If the application uses `ui-livewire`, scan that package too:

```css
@source '../../vendor/yekta-kalantary/ui-livewire/resources/views/**/*.blade.php';
```

Adjust relative paths if the application's CSS entrypoint is stored elsewhere.

## Why `@source` is required

Most styles are ordinary Tailwind utility classes written inside the package Blade templates. Tailwind must see those templates while building the application stylesheet.

Without the package `@source` path, markup may render correctly while the corresponding utility classes are absent from the final CSS bundle.

## Package CSS

The package stylesheet currently contains shared behavior that is better expressed once instead of repeated in every Blade component.

It includes:

- `[x-cloak]` hiding
- responsive table shell behavior
- shared `.ui-table` rules
- responsive table cell sizing

Import it after Tailwind:

```css
@import 'tailwindcss';
@import '../../vendor/yekta-kalantary/ui/resources/css/ui.css';
```

## Publishing the CSS

Publishing is optional:

```bash
php artisan vendor:publish --tag=ui-css
```

Destination:

```text
resources/css/vendor/ui.css
```

Use a published copy only when the application intentionally wants to fork package styling. Once published, the application owns that copy and package updates will not automatically modify it.

For most applications, importing the vendor stylesheet directly is the lower-maintenance option.

## Fonts

The package does not define a font family.

Set fonts in the consuming application:

```css
@theme {
    --font-sans: 'IRANYekanXVF', sans-serif;
}
```

Or with normal CSS:

```css
html {
    font-family: var(--font-sans);
}
```

Font files should remain application assets unless they are intentionally published as a separate reusable package.

## RTL and LTR

The package does not set `dir` on the document and avoids direction-specific alignment where practical.

Set direction at application level:

```html
<html lang="fa" dir="rtl">
```

or:

```html
<html lang="en" dir="ltr">
```

Table headers use logical alignment (`text-start`) so they follow document direction.

## Theme ownership

The current components use a neutral Slate-based visual language with semantic Tailwind colors for success, warning, danger and information states.

Application-specific brand colors should not be hardcoded into package business components because the package has no business layer.

When a project needs a different visual system, there are three options:

1. pass additional classes through component attributes for local adjustments;
2. publish package views when markup/classes genuinely need to diverge;
3. evolve the package itself if the change is generic and should apply to every consumer.

Prefer the first option for one-off changes and the third option for shared design-system changes.

## Adding classes to components

Blade attribute bags merge classes with the package defaults:

```blade
<x-ui::button class="w-full sm:w-auto">
    Save
</x-ui::button>
```

```blade
<x-ui::card class="mt-8">
    ...
</x-ui::card>
```

## JavaScript frameworks

`ui` does not ship a JavaScript dependency.

Alpine attributes can be attached directly:

```blade
<x-ui::button x-on:click="open = ! open">
    Toggle
</x-ui::button>
```

Livewire attributes can be attached the same way:

```blade
<x-ui::button wire:click="save" wire:loading.attr="disabled">
    Save
</x-ui::button>
```

Interactive components with reusable Livewire behavior should live in `yekta-kalantary/ui-livewire`, not in this package.

## Vite

No package-specific Vite plugin is required. The consuming Laravel application owns Vite and Tailwind compilation.

A normal application setup remains enough:

```bash
npm install
npm run build
```

The package is consumed as source by Tailwind through `@source` and as CSS through the vendor import.

## Troubleshooting

### Component renders without expected styling

Check that the package Blade directory is included with `@source` and rebuild assets.

```css
@source '../../vendor/yekta-kalantary/ui/resources/views/**/*.blade.php';
```

Then:

```bash
npm run build
```

### Table styles are missing

Make sure the package CSS itself is imported:

```css
@import '../../vendor/yekta-kalantary/ui/resources/css/ui.css';
```

### Published views do not receive package updates

This is expected. Laravel loads published overrides from `resources/views/vendor/ui` before vendor views. Remove or update the overridden view if you want to return to package behavior.
