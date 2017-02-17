# Struct type for PHP

[![Latest Version](https://img.shields.io/github/release/odan/struct.svg)](https://github.com/loadsys/odan/struct/releases)
[![Build Status](https://travis-ci.org/odan/struct.svg?branch=master)](https://travis-ci.org/odan/struct)
[![Crutinizer](https://img.shields.io/scrutinizer/g/odan/struct.svg)](https://scrutinizer-ci.com/g/odan/struct)
[![Coverage Status](https://scrutinizer-ci.com/g/odan/struct/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/odan/struct/code-structure)
[![Total Downloads](https://img.shields.io/packagist/dt/odan/struct.svg)](https://packagist.org/packages/odan/struct)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)

## About structs

PHP has no built in struct type. This package tries to fill this gap.

Read more:
* https://msdn.microsoft.com/en-us/library/ah19swz4.aspx
* https://qafoo.com/blog/096_refactoring_extract_data_objects.html
* https://www.reddit.com/r/PHP/comments/5tui33/refactoring_extracting_data_objects/

## Installation

```
composer require odan/struct
```

## Why ?

What would struct offer over typed properties with accessors to most people?
A struct is more a "fixed" type, while PHP class properties are not fixed.
Example for a "wrong" struct.

```php
class Book
{
    public $price;
    public $title;
    public $author;
}
$book = new Book();
$book->price = 39;
$book->title = 'My book title';
$book->author = 'Me';

// Set a undefined property from "outside".
// This is possible by default in PHP, but not allowed for a struct.
// A struct would raise an Exception here, and this would be better
// because this property is not defined in the Book class.
$book->isbn = '1234567890';
```

## Usage

### Inheritance

```php
use Odan\ValueType\Struct;

class User extends Struct
{
    public $username;
    public $email;
}
```

### As trait

```php
use Odan\ValueType\StructTrait;

class User
{
    use StructTrait;
    
    public $username;
    public $email;
}
```

### Basic example

```php
$user = new User();
$user->username = 'John';
$user->email = 'john@example.com';

// Get undefined property
$value = $user->nada;   // -> Exception: Cannot get undefined property

// Set undefined property
$user->nada = 'test';  // -> Exception: Undefined property (nada)
```

## Using a struct as parameter

At one point or the other we have all seen a constructor like below:

```php
public function __construct($size, $cheese = true, $pepperoni = true, $tomato = false, $lettuce = true) { //... }
```
As you can see; the number of constructor parameters can quickly get out of hand and it might become difficult to understand the arrangement of parameters. Plus this parameter list could keep on growing if you would want to add more options in future. 

The sane alternative is to use a struct.

```php
use Odan\ValueType\Struct;

class PizzaSetting extends Struct
{
    public $size;
    public $cheese;
    public $pepperoni;
    public $tomato;
    public $lettuce;
}

class Pizza 
{
    public function __construct(PizzaSetting $settings) {
        // ...
    }
}
```

And then it can be used like this:

```php
$settings = new PizzaSetting();
$settings->size = 14;
$settings->tomato = true;
$settings->cheese = true;

$pizza = new Pizza($settings);
```

### Using a struct for database queries

You can query more strongly typed results like this:

```php
$pdo = new PDO('sqlite::memory:');
$rows = $pdo->query('SELECT username, email FROM user')->fetchAll(PDO::FETCH_CLASS, User::class);
var_dump($rows); // array of User struct objects
```
