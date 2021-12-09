# Cookies

* [Introduction](#introduction)
* [Create a Cookie object](#create-a-cookie-object)
* [Add Cookie to Collection](#add-cookie-to-collection)
* [Get value from CookieCollection](#get-value-from-cookiecollection)
* [Delete cookie](#delete-cookie)

## Introduction

AVOLUTIONS provides helper classes to handle HTTP-cookies. There are two main components, the Cookie class and the CookieCollection.

## Create a Cookie object

To create a new cookie use the [cookie() helper](helper.md#cookie). This helper returns an `Cookie` object representing an HTTP Cookie. The objects know the same parameters as the PHP native `setcookie` method.

```php
use Avolutions\Http\Cookie;

$Cookie = cookie('name', 'value', time() + 3600);
```

This example will create a cookie called "name" with the value "value" which will be expired after 3600 seconds (=1 hour).
For more parameters see the [API docs](https://api.avolutions.org/classes/Avolutions-Http-Cookie.html).


Please note that we only created a PHP object but not save the HTTP cookie so far. To do so, we have to use the `CookieCollection`.

## Add Cookie to Collection

To set a real HTTP cookie, we have to add the `Cookie` object to the `CookieCollection`.

```php
use Avolutions\Http\Cookie;
use Avolutions\Http\CookieCollection;

$Cookie = cookie('name', 'value', time() + 3600);

CookieCollection::add($Cookie);
```

The `add()` method will call the PHP native `setcookie` method.

## Get value from CookieCollection

To get the value of a cookie we have to use the `get()` method of the `CookieCollection` and pass the name of the cookie.

```php
use Avolutions\Http\CookieCollection;

print CookieCollection::get('name'); // value
```

## Delete cookie

To delete a cookie we have to use `delete()` method of the `CookieCollection` and pass the name of the Cookie.

```php
use Avolutions\Http\CookieCollection;

CookieCollection::delete('name');
CookieCollection::get('name') // null
```