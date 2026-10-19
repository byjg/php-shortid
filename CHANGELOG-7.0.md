# Changelog - Version 7.0

> **Status: in development.** This document tracks changes landing on the `7.0` branch.
> Nothing here is released yet, and the contents may still change.

## Bug Fixes

- **`fromHex()` now throws a clear `InvalidArgumentException` for a value that does not fit
  in an integer.** `hexdec()` returns a float above `7fffffffffffffff` (`PHP_INT_MAX`), and
  `fromNumber(int)` then failed with a `TypeError` ("must be of type int, float given") that
  did not say what was wrong. The message now names the limit and points to `fromUuid()` for
  longer values. `7fffffffffffffff` and below are unchanged.
- **`fromNumber()` and `get()` now use integer arithmetic, so every integer round-trips.** Both
  divided or multiplied through a float, which has 53 bits of precision: above 2^53
  `fromNumber()` produced a wrong short ID for many values (`fromNumber(PHP_INT_MAX)` returned
  `hSifIaXiv9k`, which is 9223372036854775559) and `get()` returned an imprecise float.
  `get(fromNumber(PHP_INT_MAX))` now returns `PHP_INT_MAX`, and `get()` always returns an `int`.
- `get()` throws `InvalidArgumentException` for a short ID whose value is greater than
  `PHP_INT_MAX`. It returned an imprecise float.

## Breaking Changes

- `fromHex()` throws `InvalidArgumentException` instead of `TypeError` for a hex value
  greater than `7fffffffffffffff`. Code catching `TypeError` (or `Error`) for that case must
  catch `InvalidArgumentException` instead.
- **`fromNumber()` returns a different short ID for some numbers greater than 2^53**
  (9007199254740992); numbers up to 2^53 are unchanged. The old ID was a wrong encoding — it did
  not decode back to the number — but a short ID stored by 6.x for such a number will not match
  the one 7.0 generates. `fromRandom()` is affected the same way, since its default range goes up
  to `PHP_INT_MAX`.
- `get()` is declared `: int` instead of `: float|int`, and throws `InvalidArgumentException`
  where it returned a float. A subclass overriding `get()` must narrow its return type to `int`.

## Requirements

- PHP 8.3, 8.4, 8.5 and 8.6 are now supported: `"php": ">=8.3 <8.7"`.
  The previous `<8.6` upper bound excluded PHP 8.6, since `<8.6` is exclusive.

## Toolchain

- PHPUnit updated to `^12.5`.
- Psalm is installed as `psalm/phar` (`^6.16`) instead of `vimeo/psalm`.

  `vimeo/psalm` lists the PHP versions it supports and no published release includes
  8.6, so as a dev dependency it made `composer install` fail on the 8.6 build job
  before any test ran. `psalm/phar` requires only `php ^8.2` and bundles its own
  dependencies, so it installs on every PHP version in the matrix and cannot conflict
  with the project's. Psalm itself still refuses to *run* on 8.6, which is why the
  Psalm job uses 8.5. `composer psalm` runs it.

  PHPUnit 13 is deliberately **not** used. It requires PHP `>=8.4.1`, which would
  break the 8.3 floor.

## Continuous Integration

- The build matrix now includes PHP 8.6.
- The Psalm job now runs on PHP 8.5. Psalm declares
  `~8.1.31 || ~8.2.27 || ~8.3.16 || ~8.4.3 || ~8.5.0` and therefore does not run on
  PHP 8.6.

## Housekeeping

- `phpunit.xml.dist` renamed to `phpunit.xml`.
- The `example.php` and `randommap.php` scripts were removed.
