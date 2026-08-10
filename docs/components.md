# Component reference

All components are anonymous Blade components registered under the `ui` namespace.

```blade
<x-ui::button>Save</x-ui::button>
```

Unless a section says otherwise, unknown HTML attributes are forwarded to the component's main interactive element.

## Button

```blade
<x-ui::button
    type="submit"
    variant="primary"
    size="md"
    :disabled="false"
>
    Save
</x-ui::button>
```

### Props

| Prop | Type | Default | Notes |
| --- | --- | --- | --- |
| `type` | `string` | `button` | Rendered as the native button `type` |
| `variant` | `string` | `primary` | Unknown values fall back to `primary` |
| `size` | `string` | `md` | Unknown values fall back to `md` |
| `disabled` | `bool` | `false` | Renders the native disabled attribute |

### Variants

- `primary`
- `secondary`
- `danger`
- `ghost`

### Sizes

- `sm`
- `md`
- `lg`

### Examples

```blade
<x-ui::button>Default</x-ui::button>
<x-ui::button variant="secondary">Cancel</x-ui::button>
<x-ui::button variant="danger">Delete</x-ui::button>
<x-ui::button variant="ghost" size="sm">More</x-ui::button>
```

Extra attributes are applied to the `<button>` element:

```blade
<x-ui::button
    wire:click="save"
    wire:loading.attr="disabled"
    data-testid="save-button"
>
    Save
</x-ui::button>
```

## Input

```blade
<x-ui::input
    name="email"
    label="Email"
    type="email"
    value="person@example.com"
    hint="Use a work email."
/>
```

### Props

| Prop | Type | Default | Notes |
| --- | --- | --- | --- |
| `name` | `?string` | `null` | Used for `name`, generated `id`, old input and validation errors |
| `label` | `?string` | `null` | Optional label |
| `type` | `string` | `text` | Native input type |
| `value` | mixed | `null` | Used as fallback after Laravel old input |
| `error` | `?string` | `null` | Explicit error; takes precedence over validation bag |
| `hint` | `?string` | `null` | Shown only when no error exists |

### Generated id

When `name` is present and no explicit `id` is passed, the component generates an id prefixed with `ui-`.

```blade
<x-ui::input name="profile.email" />
```

Generates an id equivalent to:

```text
ui-profile-email
```

Bracket notation is normalized too:

```blade
<x-ui::input name="contacts[0][email]" />
```

An explicit `id` always wins:

```blade
<x-ui::input id="login-email" name="email" label="Email" />
```

### Value handling

For named inputs, Laravel's `old()` value is preferred over the provided value.

```blade
<x-ui::input name="first_name" :value="$contact->first_name" />
```

For security and browser behavior, `password` and `file` inputs do not render a `value` attribute from the component value prop.

### Validation

```blade
<x-ui::input
    name="email"
    label="Email"
    hint="Use a valid address."
/>
```

When the default validation error bag contains an error for `email`, the error replaces the hint and error styling is applied.

Explicit errors are also supported:

```blade
<x-ui::input
    name="email"
    error="This address cannot be used."
/>
```

### Livewire and Alpine

```blade
<x-ui::input
    name="search"
    wire:model.live.debounce.300ms="search"
    x-on:focus="open = true"
/>
```

The base package only forwards these attributes. It does not depend on either framework.

## Textarea

```blade
<x-ui::textarea
    name="description"
    label="Description"
    :rows="6"
    :value="$description"
    hint="Optional"
/>
```

### Props

| Prop | Type | Default | Notes |
| --- | --- | --- | --- |
| `name` | `?string` | `null` | Used for `name`, generated `id`, old input and validation errors |
| `label` | `?string` | `null` | Optional label |
| `value` | mixed | `null` | Textarea content fallback after old input |
| `error` | `?string` | `null` | Explicit error |
| `hint` | `?string` | `null` | Hidden when an error exists |
| `rows` | `int|string` | `4` | Native textarea rows |

Id generation and validation behavior match the input component.

## Select

```blade
<x-ui::select
    name="status"
    label="Status"
    hint="Choose the current status."
>
    <option value="active">Active</option>
    <option value="inactive">Inactive</option>
</x-ui::select>
```

### Props

| Prop | Type | Default | Notes |
| --- | --- | --- | --- |
| `name` | `?string` | `null` | Used for `name`, generated `id` and validation errors |
| `label` | `?string` | `null` | Optional label |
| `error` | `?string` | `null` | Explicit error |
| `hint` | `?string` | `null` | Hidden when an error exists |

Options are supplied through the default slot. Selection state is intentionally owned by the consuming Blade template or Livewire component.

```blade
<x-ui::select name="status">
    @foreach ($statuses as $status)
        <option
            value="{{ $status->value }}"
            @selected(old('status', $currentStatus) === $status->value)
        >
            {{ $status->label }}
        </option>
    @endforeach
</x-ui::select>
```

## Checkbox

```blade
<x-ui::checkbox
    name="enabled"
    label="Enabled"
    value="1"
    :checked="$enabled"
/>
```

### Props

| Prop | Type | Default | Notes |
| --- | --- | --- | --- |
| `name` | `?string` | `null` | Native checkbox name and generated id |
| `label` | `?string` | `null` | Optional text next to the checkbox |
| `value` | mixed | `1` | Native checkbox value |
| `checked` | bool-like | `false` | Controls native checked state |
| `error` | `?string` | `null` | Explicit error or fallback to Laravel validation bag |

For predictable unchecked submission behavior, add a hidden field in the consuming application when needed:

```blade
<input type="hidden" name="enabled" value="0">
<x-ui::checkbox name="enabled" value="1" :checked="$enabled" />
```

## Card

```blade
<x-ui::card>
    <x-slot:header>
        Contact details
    </x-slot:header>

    Main content

    <x-slot:footer>
        Actions
    </x-slot:footer>
</x-ui::card>
```

### Slots

| Slot | Required | Notes |
| --- | --- | --- |
| default | yes | Main card content |
| `header` | no | Adds a separated header section |
| `footer` | no | Adds a separated footer section |

Attributes are applied to the outer `<section>`:

```blade
<x-ui::card id="contact-card" class="mt-6">
    ...
</x-ui::card>
```

## Alert

```blade
<x-ui::alert variant="success">
    Saved successfully.
</x-ui::alert>
```

### Props

| Prop | Default | Supported values |
| --- | --- | --- |
| `variant` | `info` | `info`, `success`, `warning`, `danger` |

Unknown variants fall back to `info`.

The root element includes `role="alert"`.

## Badge

```blade
<x-ui::badge variant="success">
    Active
</x-ui::badge>
```

### Props

| Prop | Default | Supported values |
| --- | --- | --- |
| `variant` | `neutral` | `neutral`, `success`, `warning`, `danger`, `info` |

Unknown variants fall back to `neutral`.

## Table

```blade
<x-ui::table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Yekta</td>
            <td>yekta@example.com</td>
        </tr>
    </tbody>
</x-ui::table>
```

The component renders:

- a horizontally scrollable outer shell with `ui-table-shell`
- a native `<table>` with `ui-table`
- the supplied default slot inside the table

Additional attributes are applied to the `<table>` itself:

```blade
<x-ui::table aria-label="Contacts" data-testid="contacts-table">
    ...
</x-ui::table>
```

The package CSS defines shared responsive table behavior for these classes.

## Empty state

```blade
<x-ui::empty-state
    title="No contacts"
    description="Create the first contact to continue."
>
    <x-ui::button>Create contact</x-ui::button>
</x-ui::empty-state>
```

### Props

| Prop | Type | Default |
| --- | --- | --- |
| `title` | `?string` | translated `ui::ui.empty` string |
| `description` | `?string` | `null` |

The default slot is optional and is intended for actions or supporting content.

If no title is passed, the component uses the active Laravel locale.

## Error precedence

For form components that support both `error` and Laravel validation errors, precedence is:

1. explicit `error` prop
2. first error from the default Laravel error bag for `name`
3. `hint`

This keeps application-specific errors possible without giving up standard Laravel validation behavior.
