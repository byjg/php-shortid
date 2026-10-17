---
sidebar_key: shortid
tags: [php]
---

# ShortID

Create short string IDs from numbers

[![Sponsor](https://img.shields.io/badge/Sponsor-%23ea4aaa?logo=githubsponsors&logoColor=white&labelColor=0d1117)](https://github.com/sponsors/byjg)
[![Build Status](https://github.com/byjg/php-shortid/actions/workflows/phpunit.yml/badge.svg?branch=master)](https://github.com/byjg/php-shortid/actions/workflows/phpunit.yml)
[![Opensource ByJG](https://img.shields.io/badge/opensource-byjg-success.svg)](https://opensource.byjg.com)
[![Install MCP Server](https://img.shields.io/badge/Install-MCP_Server-8A2BE2?logo=modelcontextprotocol&logoColor=white)](https://opensource.byjg.com/docs/ai/mcpserver-byjg-docs/)
[![GitHub source](https://img.shields.io/badge/Github-source-informational?logo=github)](https://github.com/byjg/php-shortid/)
[![GitHub license](https://img.shields.io/github/license/byjg/php-shortid.svg)](https://opensource.byjg.com/license/)
[![GitHub release](https://img.shields.io/github/release/byjg/php-shortid.svg)](https://github.com/byjg/php-shortid/releases/)

## Description

This library enables you to create a very short string from integer numbers.

The basic usage is:

```php
<?php
$shortid = \ByJG\ShortId\ShortId::fromNumber(9223372036854775807);

// Will write: hSifIaXiv9k
```

## Documentation

- [Getting Started](docs/getting-started.md)
- [Methods](docs/methods.md)
- [Custom Maps](docs/custom-maps.md)

## Installation

```bash
composer require "byjg/shortid"
```

## Quick Start

```php
<?php
use ByJG\ShortId\ShortId;

// Create short ID from number
$shortid = ShortId::fromNumber(1234567890);

// Get the number back
$number = ShortId::get($shortid);

// Create from UUID
$shortid = ShortId::fromUuid('092395A6-BC87-11ED-8CA9-0242AC120002');

// Create from hex
$shortid = ShortId::fromHex('3e');

// Generate random short ID
$shortid = ShortId::fromRandom();
```

## Running Tests

```bash
composer test
```

----
[Open source ByJG](https://opensource.byjg.com)
