---
sidebar_position: 1
---

# Getting Started

ShortID is a PHP library that creates short string IDs from integer numbers. This is useful when you need to:

- Shorten numeric IDs for URLs
- Create compact representations of large numbers
- Convert UUIDs to shorter strings
- Generate random short identifiers

## Installation

Install the library using Composer:

```bash
composer require byjg/shortid
```

## Basic Usage

The simplest way to use ShortID is to convert a number to a short string:

```php
<?php
use ByJG\ShortId\ShortId;

// Convert number to short ID
$shortid = ShortId::fromNumber(1234567890);
echo $shortid; // Output: bjme

// Convert back to number
$number = ShortId::get($shortid);
echo $number; // Output: 1234567890
```

## How It Works

ShortID uses a base-62 encoding system by default, using the following character set:

- Lowercase letters: `a-z` (26 characters)
- Uppercase letters: `A-Z` (26 characters)
- Numbers: `0-9` (10 characters)

This means each character can represent 62 different values, making the resulting strings very compact compared to decimal representation.

### Example Conversions

| Number | Short ID |
|--------|----------|
| 0      | a        |
| 1      | b        |
| 62     | ab       |
| 1000   | qa       |
| 999999 | bjme     |

## Next Steps

- Learn about all available [methods](methods.md)
- Explore [custom maps](custom-maps.md) to create your own encoding schemes
