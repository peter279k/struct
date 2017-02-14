# Struct type for PHP

[![Latest Version](https://img.shields.io/github/release/odan/struct.svg)](https://github.com/loadsys/odan/struct/releases)
[![Build Status](https://travis-ci.org/odan/struct.svg?branch=master)](https://travis-ci.org/odan/struct)
[![Crutinizer](https://img.shields.io/scrutinizer/g/odan/struct.svg)](https://scrutinizer-ci.com/g/odan/struct)
[![Coverage Status](https://scrutinizer-ci.com/g/odan/struct/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/odan/struct/code-structure)
[![Total Downloads](https://img.shields.io/packagist/dt/odan/struct.svg)](https://packagist.org/packages/odan/struct)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)

## Installation

```
composer require odan/struct
```

## Usage

```php

use Odan\ValueType\Struct;

class User extends Struct
{
    public $username;
    public $email;
}

$user = new User();
$user->username = 'John';
$user->email = 'john@example.com';

// Get undefined property
$value = $user->nada;   // -> Exception: Cannot get undefined property
// Set Get undefined property
$user->nada = 'test';  // -> Exception: Undefined property (nada)

```