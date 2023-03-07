# ShortID PHP

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/byjg/shortid/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/byjg/shortid/?branch=master)
[![Build Status](https://travis-ci.com/byjg/shortid.svg?branch=master)](https://travis-ci.com/byjg/shortid)

Create short string IDs from numbers

## Description

This library enable you create a very short string from
integer numbers

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

Basically you can create your own sequence here.

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
composer require "byjg/shortid=1.0.*"
```

## Tests

```php
vendor/bin/phpunit
```
