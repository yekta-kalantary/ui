# Localization

The package ships its own translation namespace so built-in UI copy does not collide with application translations.

## Supported locales

Currently included:

- English: `en`
- Persian: `fa`

The active Laravel application locale determines which package translation is used.

```php
app()->setLocale('fa');
```

## Translation namespace

Package translations use the `ui` namespace.

Example:

```php
__('ui::ui.empty')
```

The empty-state component uses this key when no explicit title is supplied.

```blade
<x-ui::empty-state />
```

With English locale it renders the English package string; with Persian locale it renders the Persian package string.

## Passing explicit copy

Application-specific copy should usually be passed as a prop instead of added to package translations.

```blade
<x-ui::empty-state
    title="هیچ مخاطبی ثبت نشده"
    description="برای شروع اولین مخاطب را ایجاد کنید."
/>
```

The package translation files should contain only generic copy owned by reusable package components.

## Publishing translations

Publish translations when the application needs to override built-in wording:

```bash
php artisan vendor:publish --tag=ui-translations
```

Laravel writes them to:

```text
lang/vendor/ui
```

After publishing, application copies take precedence over vendor translation files.

## Adding a new locale to the package

Add a matching translation file under:

```text
resources/lang/<locale>/ui.php
```

For example:

```text
resources/lang/de/ui.php
```

Keep the same translation keys across locales.

```php
<?php

return [
    'empty' => 'Keine Einträge gefunden.',
];
```

Add or update tests whenever a built-in translation key changes.

## Translation ownership

Belongs in this package:

- generic empty-state wording
- generic reusable component copy

Does not belong in this package:

- contact terminology
- ticket statuses
- client-specific labels
- project names
- authorization messages
- business validation messages

Those translations belong to the consuming application or the package that owns that business concept.
