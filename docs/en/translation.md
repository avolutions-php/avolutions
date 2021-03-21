# Translations

* [Introduction](#introduction)
* [Create translation files](#create-translation-files)
* [Set language](#set-language)
* [Get translated string](#get-translated-string)
* [Use placeholders in translations](#use-placeholders-in-translations)

## Introduction

Whenever it comes to a multi language application, the AVOLUTIONS translation feature can be used to retrieve strings in multiple languages.

## Define translation files

All translatable strings are stored in translation files located in the *translation* folder.
Translation files are simple PHP files returning an associative array like [config](config.md) or [mapping](mapping.md) files.

For every supported language a subdirectory in the *translation* directory is needed. 
Every language can have multiple translation files, the name of the file is part of the unique identifier of the translation, see [Get translated string](#get-translated-string).

See the following example of translation folder:
```bash
/
  translation/
    de/
      example.php
    en/
      example.php
```

The translation files will look like the following.

*/translation/en/example.php*:
```php
return [
  'welcome' => 'Hello world',
  'name' => 'My name is {0}',
  'age' => 'I\'m {years} years old'
];
```
*/translation/de/example.php*:
```php
return [
  'welcome' => 'Hallo Welt',
  'name' => 'Mein Name ist {0}',
  'age' => 'Ich bin {years} Jahre alt'
];
```

## Set language

The default language of your application can be set in the application config by changing the value of *application/defaultLanguage*.
The default value is "en".

If you want to change the language for the current context (e.g. when user is switching language) this can be done by using the session key *language*:
```php
use Avolutions\Http\Session;

Session::set('language', 'de');
```

## Get translated string

To get a string in the wanted language the method *Translation::getTranslation()* is used.
To simplify the access we introduced a global [helper function](helper.md) called *translate()* for it. Just pass the key of your translation to this method.
The key is composed of the file name and the array key:
```php
print translate('example/welcome'); // Hello world
```

If no specific language is passed to the translate method it will check for the *language* key of *Session*. If this key is not specified the translation is returned in the [default language](#set-language):
```php
print translate('example/welcome'); // Hello world

Session::set('language', 'de');
print translate('example/welcome'); // Hallo Welt
```

If you want to receive the string in a specific language, just pass it as third parameter:
```php
print translate('example/welcome', null, 'de'); // Hallo Welt
```

The second parameter can be used to pass variables to the translation, see [next chapter](#use-placeholders-in-translations)

## Use placeholders in translations

You can define placeholders in your translation strings by using braces.
Placeholders can be numeric (e.g. {1}) or using a name (e.g. {years}).
To replace these placeholders, an array can be passed to the *translate* method as second parameter.

If you use numeric placeholders, pass an indexed array. The placeholder will be replaced by order.
```php
print translate('example/name', ['Alex']); // My name is Alex
```

If you use named placeholders, pass an associative array. The placeholder will be replaced by key.
```php
print translate('example/age', ['years' => 30]); // I'm 30 years old
```
