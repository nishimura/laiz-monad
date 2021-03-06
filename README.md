Laiz Monad
==========



[![Build Status](https://travis-ci.org/nishimura/laiz-monad.svg?branch=master)](https://travis-ci.org/nishimura/laiz-monad)
[![Coverage Status](https://coveralls.io/repos/github/nishimura/laiz-monad/badge.svg?branch=master)](https://coveralls.io/github/nishimura/laiz-monad?branch=master)
[![Code Climate](https://codeclimate.com/github/nishimura/laiz-monad/badges/gpa.svg)](https://codeclimate.com/github/nishimura/laiz-monad)

[![Latest Stable Version](https://poser.pugx.org/laiz/laiz-monad/v/stable)](https://packagist.org/packages/laiz/laiz-monad)
[![License](https://poser.pugx.org/laiz/laiz-monad/license)](LICENSE)


## Curried Function

```php
require 'vendor/autoload.php';

use function Laiz\Func\f;

$f = f(function($a, $b, $c){
    return $a + $b + $c;
});
$f1 = $f(5);
$f2 = $f1(8);
var_dump($f2(200));
// 213

$f3 = $f1(9);
var_dump([$f2(200), $f3(200)]);
// [213, 214]

var_dump($f(1,2,3));
// 6
```

## Maybe Monad

```php
require 'vendor/autoload.php';

use function Laiz\Func\f;
use function Laiz\Func\Maybe\Just;
use function Laiz\Func\Maybe\Nothing;

$a = Just(3);
$f = f(function($limit, $a){
    return $limit > $a ? Just($a) : Nothing();
});
$f2 = $f(2);
$f4 = $f(4);

var_dump($a->bind($f2));
// Nothing
var_dump($a->bind($f4));
// Just 3
```

## Monoid, MonadPlus

```php
require 'vendor/autoload.php';

use function Laiz\Func\Monad\ret;
use function Laiz\Func\Maybe\Just;

$monad = ret("Foo");
var_dump($monad->mappend([]));
// ['Foo']
var_dump($monad->mappend("Bar"));
// 'FooBar'
var_dump($monad->mappend(Just("Baz")));
// Just 'FooBaz'
var_dump($monad->mplus(Just("Baz")));
// Just 'Foo'
```


## FizzBuzz

```php
require 'vendor/autoload.php';

use function Laiz\Func\f;
use function Laiz\Func\Functor\fmap;
use function Laiz\Func\Functor\fconst;
use function Laiz\Func\Monoid\mappend;
use function Laiz\Func\MonadZero\guard;
use function Laiz\Func\Maybe\fromMaybe;

// (integer d, Functor s, MonadPlus s) => d -> a -> d -> s a
function calc(...$args){
    return f(function($d, $s, $n){
        return fconst($s, guard($n % $d === 0));
    }, ...$args);
}

$fizzbuzz = fromMaybe()->ap(mappend(calc(3, "Fizz"), calc(5, "Buzz")));

function pr(...$args){
    return f(function($a){
        echo $a, "\n";
        return $a;
    }, ...$args);
}
$ret = fmap(pr()->compose($fizzbuzz), range(1, 100));
```
