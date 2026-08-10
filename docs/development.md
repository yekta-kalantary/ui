# Architecture, testing and development

## Package responsibility

`yekta-kalantary/ui` is the lowest reusable presentation layer.

Its dependency direction should remain simple:

```text
Laravel application
      ↓
ui-livewire (optional)
      ↓
ui
```

`ui` must not depend on `ui-livewire`, Livewire, application models or application modules.

## What belongs in this package

A component belongs in `ui` when all of the following are true:

- it is reusable across multiple applications or domains;
- it can be expressed as presentation behavior without database access;
- it does not need a business-specific model or route;
- it does not need reusable Livewire state management;
- its API can be described using generic props, slots and HTML attributes.

Examples:

- button
- input
- textarea
- badge
- alert
- card
- empty state
- generic table shell

## What does not belong here

Examples that should remain outside this package:

- `ContactForm`
- `ClientCard`
- `TicketReply`
- `ProjectStatusBadge` when it embeds business status rules
- database-backed autocomplete
- permission-aware navigation tied to an application

Database-backed reusable interaction patterns can live in `ui-livewire` if their business query is injected through a generic contract.

## Local development

Clone the repository and install dependencies:

```bash
git clone https://github.com/yekta-kalantary/ui.git
cd ui
composer update
```

Run package validation:

```bash
composer validate --strict
```

Run tests:

```bash
composer test
```

## Test structure

The test suite uses Orchestra Testbench and PHPUnit.

Current responsibilities are split into:

```text
tests/
├── FormComponentsTest.php
├── TestCase.php
├── UiComponentsTest.php
└── UiServiceProviderTest.php
```

### Component tests

Component tests should verify public behavior rather than internal Blade implementation details.

Useful assertions include:

- expected semantic element is rendered;
- props affect output correctly;
- unknown variants use documented fallback behavior;
- custom HTML attributes are preserved;
- named slots render in the correct structural region;
- validation errors take precedence over hints;
- sensitive input types do not expose values;
- translation-backed defaults respect application locale.

Avoid tests that assert every Tailwind class unless the class itself represents part of the public visual contract such as a variant or table hook.

### Service provider tests

Service provider tests cover integration points that consuming applications depend on:

- package view namespace
- package translation namespace
- view publish group
- CSS publish group
- translation publish group

## CI matrix

GitHub Actions runs the suite against:

```text
PHP 8.3 + lowest dependencies
PHP 8.3 + highest dependencies
PHP 8.4 + lowest dependencies
PHP 8.4 + highest dependencies
```

The workflow also runs:

```bash
composer validate --strict
```

`COMPOSER_ROOT_VERSION=dev-main` is set in CI so Composer can resolve the package development line predictably in shallow checkouts.

## Adding a component

A new component should normally include all of these changes in the same pull request or commit series:

1. Blade component under `resources/views/components`;
2. tests for its public props, slots and fallback behavior;
3. component reference documentation;
4. Tailwind source compatibility;
5. translation keys if the component owns generic built-in copy.

Do not introduce a service class for a component that can remain an anonymous Blade component.

## Component API guidelines

Prefer small predictable APIs.

Good:

```blade
<x-ui::button variant="danger" size="sm">
    Delete
</x-ui::button>
```

Avoid business-specific props:

```blade
<x-ui::button :can-delete-ticket="$canDeleteTicket">
    Delete
</x-ui::button>
```

Authorization belongs in the consumer:

```blade
@can('delete', $ticket)
    <x-ui::button variant="danger">
        Delete
    </x-ui::button>
@endcan
```

## Backward compatibility

Once stable releases are tagged, treat these as public API:

- component names;
- documented prop names;
- documented variant names;
- named slots;
- translation keys intended for overrides;
- publish tag names;
- package namespaces.

Removing or renaming any of these should be treated as a breaking change.

Internal Tailwind implementation details can evolve when the visual contract remains equivalent, but consumers should avoid depending on undocumented internal classes.

## Versioning

The `main` branch currently represents the future `1.0` development line and is declared as:

```text
1.0.x-dev
```

through Composer's branch alias.

Before the first stable tag, consumers should require `dev-main` explicitly.

After stable releases begin, use semantic versioning:

- patch: bug fixes with compatible API;
- minor: backward-compatible components, props or capabilities;
- major: documented breaking changes.

## Publishing resources

Package resources are loaded directly from `vendor` by default. Publishing should remain optional.

Supported publish tags:

```text
ui-views
ui-css
ui-translations
```

If a change adds a new publishable resource category, add an integration test for the publish group and document the destination path.

## Coding style

Keep package code conventional and explicit:

- `declare(strict_types=1);` for PHP source and tests;
- final classes when extension is not part of the public API;
- small anonymous Blade components for presentation primitives;
- no application service locator calls from Blade components;
- no database access;
- no business-specific terminology;
- comments only when intent is not obvious from the code.
