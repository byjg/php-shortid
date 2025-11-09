---
sidebar_position: 3
---

# Custom Maps

ShortID allows you to customize the character set used for encoding. This is useful when you want:

- Different character ordering for specific use cases
- To avoid confusion between similar-looking characters
- Custom encoding schemes for obfuscation

## Predefined Maps

The library provides four predefined character maps:

### MAP_DEFAULT

The default map with lowercase first, then uppercase, then numbers.

```php
ShortId::$MAP_DEFAULT = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"
```

**Example:**
```php
use ByJG\ShortId\ShortId;

$shortid = ShortId::fromNumber(999999);
echo $shortid; // Output: bjme
```

### MAP_ALTERNATE

Lowercase letters, then numbers, then uppercase letters.

```php
ShortId::$MAP_ALTERNATE = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"
```

**Example:**
```php
use ByJG\ShortId\ShortId;

$shortid = ShortId::fromNumber(999999, ShortId::$MAP_ALTERNATE);
echo $shortid; // Output: bjme (same as default for this number)
```

:::tip
`MAP_DEFAULT` and `MAP_ALTERNATE` produce identical results for numbers that only use lowercase letters in their encoding.
:::

### MAP_NUMBERS_FIRST

Numbers first, then lowercase, then uppercase letters.

```php
ShortId::$MAP_NUMBERS_FIRST = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"
```

**Example:**
```php
use ByJG\ShortId\ShortId;

$shortid = ShortId::fromNumber(999999, ShortId::$MAP_NUMBERS_FIRST);
echo $shortid; // Output: 19c4
```

### MAP_RANDOM

A randomized character order for obfuscation.

```php
ShortId::$MAP_RANDOM = "WPyHLMtE74KjUQvBqoS652uADFgZibO9RdznT1YIVsXwfkaxCNprJ3chmel0G8"
```

**Example:**
```php
use ByJG\ShortId\ShortId;

$shortid = ShortId::fromNumber(999999, ShortId::$MAP_RANDOM);
echo $shortid; // Output: P4UL
```

## Using Custom Maps

All ShortID methods accept an optional `$map` parameter:

```php
use ByJG\ShortId\ShortId;

// Create with custom map
$shortid = ShortId::fromNumber(12345, ShortId::$MAP_RANDOM);

// Decode with the SAME custom map
$number = ShortId::get($shortid, ShortId::$MAP_RANDOM);
```

:::danger Important
Always use the **same map** for encoding and decoding. Using different maps will produce incorrect results.
:::

## Creating Your Own Map

You can create a completely custom character map:

```php
use ByJG\ShortId\ShortId;

// Create a custom map (must be 62 characters for base-62 encoding)
$myMap = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

// Use it
$shortid = ShortId::fromNumber(12345, $myMap);
$number = ShortId::get($shortid, $myMap);
```

### Custom Map Requirements

- Must contain exactly 62 unique characters
- Each character must be unique (no duplicates)
- Can use any ASCII characters

### Generating Random Maps

You can use the included `randommap.php` utility to generate a randomized character map:

```bash
php randommap.php
```

This will output a shuffled version of the default character set that you can use as a custom map.

## Comparison of Maps

Here's how different maps encode the same number:

| Number | MAP_DEFAULT | MAP_NUMBERS_FIRST | MAP_RANDOM |
|--------|-------------|-------------------|------------|
| 0      | a           | 0                 | W          |
| 1      | b           | 1                 | P          |
| 62     | ab          | a0                | WP         |
| 999999 | bjme        | 19c4              | P4UL       |

## Use Cases

### URL Shortening
Use `MAP_DEFAULT` for readable, lowercase-first IDs.

### Database Obfuscation
Use `MAP_RANDOM` to make sequential IDs less predictable.

### Avoiding Confusion
Create a custom map that excludes confusing characters like `0/O` or `1/l/I`:

```php
$clearMap = "abcdefghjkmnpqrstuvwxyz23456789ABCDEFGHJKMNPQRSTUVWXYZ";
// Excludes: i, l, o, 0, 1, I, L, O
```

## Best Practices

1. **Store your map**: If using a custom map in production, store it securely and consistently
2. **Version your maps**: If you change maps, you'll need to migrate existing IDs
3. **Document which map is used**: Always document which map is used for each ID type
4. **Use the same map**: Encoding and decoding must use identical maps
