# Sessions

* [Introduction](#introduction)
* [Start a session](#start-a-session)
* [Store and retrieve values to the session](#store-and-retrieve-values-to-the-session)
* [Delete values from the session](#delete-values-from-the-session)

## Introduction

AVOLUTIONS provides a helper class to handle PHP sessions.

## Start a session

Before storing or retrieve session values the session has to be started.
By default, the session will be started automatically by AVOLUTIONS whenever you use one of the Session methods.
In case a session needs to started manually the `start()` method can be used.
```php
$Session->start() // will start the session
```

The `start()` method will only start a new session if none is started already.
To check if a session is started already you can use `isStarted()` method.
```php
if ($Session->isStarted()) {
  // session is started
} else {
  // session is not started
}
```

## Store and retrieve values to the session

To store a value to the session the `set()` method can be used. Just pass the key and the value as parameters.
This can also be used to update an existing value.
To retrieve a value from the session just use the `get()` method and pass the key of the value.
```php
$Session->set('userId', 1);
print $Session->get('userId') // 1

$Session->set('userId', 2);
print $Session->get('userId'); // 2
```

## Delete values from the session

To delete a value from the session just use `delete()` method and pass the key.
```php
$Session->delete('userId');

print $Session->get('userId') // null
```

To delete all values and destroy the session use `destroy()` method.
```php
$Session->destroy()
```