---
sidebar_position: 2
---

# Methods Reference

This page describes all available methods in the ShortID library.

## fromNumber()

Convert an integer number to a short ID string.

```php
public static function fromNumber(int $number, ?string $map = null): string
```

### Parameters

- `$number` (int): The number to convert
- `$map` (string|null): Optional custom character map (defaults to `$MAP_DEFAULT`)

### Returns

- (string): The short ID representation

### Example

```php
use ByJG\ShortId\ShortId;

$shortid = ShortId::fromNumber(1234567890);
echo $shortid; // Output: uFhIvb

// With custom map
$shortid = ShortId::fromNumber(1234567890, ShortId::$MAP_NUMBERS_FIRST);
echo $shortid; // Output: kv7yl1
```

## get()

Convert a short ID string back to its original number.

```php
public static function get(string $shortId, ?string $map = null): int
```

:::warning
This method does not work with UUIDs converted using `fromUuid()` because UUIDs are split into multiple parts during conversion.
:::

### Parameters

- `$shortId` (string): The short ID to decode
- `$map` (string|null): Optional custom character map (must match the one used for encoding)

### Returns

- (int): The original number

### Throws

- `InvalidArgumentException`: when the short ID decodes to a value greater than `PHP_INT_MAX`
  (for example a short ID made by hand, or one longer than any `fromNumber()` output).

### Example

```php
use ByJG\ShortId\ShortId;

$number = ShortId::get('uFhIvb');
echo $number; // Output: 1234567890

// With custom map
$number = ShortId::get('kv7yl1', ShortId::$MAP_NUMBERS_FIRST);
echo $number; // Output: 1234567890
```

## fromHex()

Convert a hexadecimal string to a short ID.

```php
public static function fromHex(string $hex, ?string $map = null): string
```

### Parameters

- `$hex` (string): Hexadecimal string (with or without dashes)
- `$map` (string|null): Optional custom character map

### Returns

- (string): The short ID representation

### Throws

- `InvalidArgumentException`: when the value does not fit in an integer, i.e. it is greater
  than `7fffffffffffffff` (`PHP_INT_MAX` on 64-bit). Use `fromUuid()` for longer values such as
  a UUID.

### Example

```php
use ByJG\ShortId\ShortId;

$shortid = ShortId::fromHex('3e');
echo $shortid; // Output: ab

$shortid = ShortId::fromHex('f04');
echo $shortid; // Output: aab
```

## fromUuid()

Convert a UUID to a short ID string.

```php
public static function fromUuid(string $hex, ?string $map = null): string
```

:::info
The UUID is split into multiple parts and each part is converted separately. This means you cannot use `get()` to reverse this conversion.
:::

### Parameters

- `$hex` (string): UUID string (with or without dashes)
- `$map` (string|null): Optional custom character map

### Returns

- (string): The short ID representation

### Example

```php
use ByJG\ShortId\ShortId;

$shortid = ShortId::fromUuid('092395A6-BC87-11ED-8CA9-0242AC120002');
echo $shortid; // Output: a2BU6bLxLieeALmbPW3QuK

$shortid = ShortId::fromUuid('092609DD-BC87-11ED-8CA9-0242AC120002');
echo $shortid; // Output: OKgJdeLxLieeALmbPW3QuK
```

## fromRandom()

Generate a random short ID.

```php
public static function fromRandom(
    int $min = 2147483647,
    int $max = 9223372036854775807,
    ?string $map = null
): string
```

### Parameters

- `$min` (int): Minimum random value (default: 2147483647)
- `$max` (int): Maximum random value (default: 9223372036854775807)
- `$map` (string|null): Optional custom character map

### Returns

- (string): A random short ID

### Example

```php
use ByJG\ShortId\ShortId;

$shortid = ShortId::fromRandom();
echo $shortid; // Output: random string, e.g., "aBc123"

// With custom range
$shortid = ShortId::fromRandom(1000, 9999);
echo $shortid; // Output: random short ID from smaller range
```

## Summary Table

| Method         | Input       | Output   | Reversible          |
|----------------|-------------|----------|---------------------|
| `fromNumber()` | Integer     | Short ID | ✅ Yes (via `get()`) |
| `fromHex()`    | Hexadecimal | Short ID | ✅ Yes (via `dechex(get())`)¹ |
| `fromUuid()`   | UUID        | Short ID | ❌ No                |
| `fromRandom()` | Range       | Short ID | ✅ Yes (via `get()`) |
| `get()`        | Short ID    | Integer  | N/A                 |

¹ `get()` returns the number, so `dechex()` gives the hex back without dashes or leading zeros.
Only values up to `7fffffffffffffff` are accepted by `fromHex()`.
