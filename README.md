# Laravel Extra Validators

* DividesInto
* GreaterThan
* LessThan
* MinWords
* MaxWords
* MinDate
* MaxDate
* MinChecked

To install:

```shell
composer install
```

To run tests:

```shell
./vendor/bin/phpunit tests
```

## DividesInto

Checks to make sure that the number is a divisor of a gap between 2 other
numbers.

```php
$rules = [
    'number'        => 'divides_into:100',          // 1
    'anotherNumber' => 'divides_into:100,80',       // 2
    'lastNumber'    => 'divides_into:100,number',   // 3
];
```

### Example 1

This will check to see if `number` divides into `100` i.e. is one of the
following `1`, `2`, `4`, `5`, `10`, `20`, `25`, `50` or `100`.

### Example 2

This checks to see if `anotherNumber` divides into the difference between `80`
and `100` i.e. is one of the following `1`, `2`, `4`, `5`, `10` or `20`.

### Example 3

Checks to see if `lastNumber` divides into the difference between `number` and
`100`, so if `number` was `97` `lastNumber` would need to be `1` or `3`.

## GreaterThan

Checks to see if the value is greater or equal to the supplied number or field.

```php
$rules = [
    'number' => 'greater_than:10',
    'anotherNumber' => 'greater_than:number',
];
```

### Example 1

Is `number` greater than (or equal to) `10`.

### Example 2

Is `anotherNumber` greater than (or equal to) the value of `number`.

## LessThan

Checks to see if the value is less or equal to the supplied number or field.

```php
$rules = [
    'number' => 'less_than:10',
    'anotherNumber' => 'less_than:number',
];
```

### Example 1

Is `number` less than (or equal to) `10`.

### Example 2

Is `anotherNumber` less than (or equal to) the value of `number`.

## MinWords

Checks to see if the value has at least `min` words. This uses the PHP function
[str_word_count](http://php.net/manual/en/function.str-word-count.php).

```php
$rules = [
    'sentence' => 'min_words:10',
];
```

### Example

Does `sentence` have at least `10` words.

## MaxWords

Checks to see if the value has no more than `max` words. This uses the PHP
function [str_word_count](http://php.net/manual/en/function.str-word-count.php).

```php
$rules = [
    'sentence' => 'max_words:10',
];
```

### Example

Does `sentence` have no more than `10` words.

## MinDate

Checks to see if the value is on or after the `min_date`. Date values are passed
directly into a new [DateTime](http://php.net/manual/en/datetime.construct.php)
object.

```php
$rules = [
    'date' => 'min_date:1982-05-06',
];
```

### Example

Is `date` on or after `June 5th 1982`

## MaxDate

Checks to see if the value is on or before the `max_date`. Date values are
passed directly into a new
[DateTime](http://php.net/manual/en/datetime.construct.php) object.

```php
$rules = [
    'date' => 'max_date:2013-09-20',
];
```

### Example

Is `date` on or before `September 9th 2013`

## MinChecked

Check to see if at least `min_checked` values in an array are set to `true`.
Truthiness is tested by
[boolval](http://php.net/manual/en/function.boolval.php).

```php
$rules = [
    'checkbox' => 'min_checked:3',
];

$data = [
    'checkbox' => [1, 0, 1, 1, 0, 0, 0, 0, 1],
]
```

### Example

Check to see if at least `3` checkboxes within the `checkbox` group are checked.
