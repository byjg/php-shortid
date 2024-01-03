# ShortID PHP

[![Build Status](https://github.com/byjg/php-shortid/actions/workflows/phpunit.yml/badge.svg?branch=master)](https://github.com/byjg/php-shortid/actions/workflows/phpunit.yml)
[![Opensource ByJG](https://img.shields.io/badge/opensource-byjg-success.svg)](http://opensource.byjg.com)
[![GitHub source](https://img.shields.io/badge/Github-source-informational?logo=github)](https://github.com/byjg/php-shortid/)
[![GitHub license](https://img.shields.io/github/license/byjg/php-shortid.svg)](https://opensource.byjg.com/opensource/licensing.html)
[![GitHub release](https://img.shields.io/github/release/byjg/php-shortid.svg)](https://github.com/byjg/php-shortid/releases/)

Create short string IDs from numbers

## Description

This library enables you to create a very short string from
integer numbers.

The basic usage is:

```php
<?php
$shortid = \ByJG\Utils\ShortId::fromNumber(81717788171667188198);

// Will write: Qi0yuM2uKwJb
```

## Methods

- fromNumber($number, $map = null): Return a short id from a number
- fromHex($hex, $map = null): Return a short id from a Hex value
- fromUuid($uuid, $map = null): Return a short id from a UUID
- fromRandom($min, $max, $map = null): Return a short id from a random number
- get($shortid, $map = null): Return the Unique Integer Number from the short id (does not work with UUIDs)

## Specify your own map

The base of the short id is in the map definition.

Basically, you can create your own sequence here.

The library defines four by default:

- $MAP_DEFAULT
- $MAP_ALTERNATE
- $MAP_NUMBERS_FIRST
- $MAP_RANDOM

The basic usage is:

```php
<?php
$shortid = \ByJG\Utils\ShortId::fromNumber(
    81717788171667188198,
    \ByJG\Utils\ShortId::$MAP_NUMBERS_FIRST
);

// Will write: G8QokCSkAmz1
```

## Installation

```php
composer require "byjg/php-shortid=4.9.*"
```

## Tests

```php
vendor/bin/phpunit
```

## Dependencies

```mermaid  
flowchart TD  
    byjg/shortid  
```

----
[Open source ByJG](http://opensource.byjg.com)
