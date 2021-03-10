# Validation

* [Introduction](#introduction)
* [Entity validation](#entity-validation)
  * [Validate an Entity](#validate-an-entity)
  * [Add validation to Entity](#add-validation-to-entity)
  * [Built in validators](#built-in-validators)
    * [CompareValidator](#comparevalidator)
    * [DateTimeValidator](#datetimevalidator)
    * [FormatValidator](#formatvalidator)
    * [RangeValidator](#rangevalidator)
    * [RegexValidator](#regexvalidator)
    * [RequiredValidator](#requiredvalidator)
    * [SizeValidator](#sizevalidator)
    * [TypeValidator](#typevalidator)
    * [UniqueValidator](#uniquevalidator)
  * [Custom validators](#custom-validators)
* [AdHoc validation](#adhoc-validation)
* [Error messages](#error-messages)
  * [Default message](#default-message)
  * [Localized messages](#localized-messages)

## Introduction

The *Validation* module or *Validators* can be used to check either if properties of an *[Entity](#entity-validation)* are valid or to check any other [value](#adhoc-validation) in your application.
You can use the [built-in](#built-in-validators) *Validators* from *AVOLUTIONS* or write your [own](#custom-validators) *Validators*.

## Entity validation

The most common case to use *Validators* are the validation of an *Entity*.
This provides an easy way to check if your *Entity* properties are correct before storing it to database.
Also, you can ensure to have consistent data in your application and check the user input e.g. in forms.

### Validate an Entity

To validate your *Entity* just use the `validate()` method:
```php
$User = new User();
$User->validate();
```
This will automatically validate all properties and run the *Validators* like defined in [mapping](#add-validators-to-entity). 

In case everything is valid the method will return `true`, if one or more validations failed it will return `false`.
This information can also be received by the `isValid()` method:
```php
$User = new User();
$User->validate();
...
$User->isValid();
```
The `isValid()` will return same result as `validate()` but **without** executing the *Validation* again.

In case you *Entity* was not validated successfully you can get the occurred error message by calling `getErrors()` method:
```php
$User = new User();
if(!$User->validate()) {
  print_r($User->getErrors());
}
```
This method will return an multidimensional array with all errors from the last *Entity* validation.
Key of the first dimension is the property of the *Entity*, key of the second dimension is the name of the *Validator*. 
Value of second dimension contains the error message itself.

For more details check the [error message chapter](#error-messages).

### Add Validators to Entity

*Validation* or better said a *Validator* are bind to an *Entity* by using the *[Mapping](mapping.md)* file.
To do so, just add an array under the key `validation` to the property you want to validate.
Add an array under `validation` for every 'Validator' for this property. Use the name of the 'Validator' (without postfix "Validator") as key.
If you have to pass *options* to the *Validator* (see next chapters) add them as associative array.

Lets say we have an *Entity* with an property called *firstname*. And we want to have the firstname a max. length of 15 and as required, the *EntityMapping* will look like this:
```php
...
  'firstname' => [
    'validation' => [
      'size' => ['max' => 15],
      'required'
    ]
  ]
...
```

### Built in validators

There are several built in validators in the AVOLUTIONS framework which can be used to validate values.

#### CompareValidator

The *CompareValidator* can be used to perform validations using the common comparison validators.

*Options*:
* `operator`: a comparison operator. Default value: `==`.  Valid operators: `==`, `===`, `!=`, `!==`, `>`, `>=`, `<`, `<=`
* `value`: a static value to compare your value to.
* `attribute`: the name of an Entity attribute to compare you value to.

Either *value* or *attribute* must be set. If both are passed, *attribute* will be used.

#### DateTimeValidator

The *DateTimeValidator* can be used to check if a string is in a valid date/time format by using `DateTime::createFromFormat` method.

*Options*:
* `format`: a date/time format. Check [PHP docs](https://www.php.net/manual/en/datetime.format.php) for supported formats. 
* `type`: a predefined type to check the string against. Possible values: `date`, `time`, `datetime`. Default value `datetime`. If `type` is passed, the default formats from the [config](config.md#default-values) will be used to validate the input.

If `format` and `type` are passed, `format` will be used.

#### FormatValidator

The *FormatValidator* can be used to check if your value has a valid format.

*Options*:
* `format`: the format to check against. Valid formats: `ip`, `ip4`, `ip6`, `mail`, `url`, `json`

*format* is a mandatory option.

#### RangeValidator

The *RangeValidator* can be used to validate if your value is inside a specific range (array).

*Options*:
* `range`: a static array to check your value against
* `attribute`: the name of an Entity attribute to compare you value to
* `not`: a boolean to invert the result. Default value: `false`
* `strict`: a boolean to indicate if data type should be considered. Default value: `false`
  
Either *range* or *attribute* must be set. If both are passed, *attribute* will be used.

#### RegexValidator

The *RegexValidator* can be used to check your value against a regular expression via `preg_match`.

*Options*:
* `pattern`: the regular expression to validate.
* `not`: a boolean to invert the result. Default value: `false`

*pattern* is a mandatory option.

#### RequiredValidator

The *RequiredValidator* indicates that this value is mandatory. 
The value can not be null, or in case of a string has a length of 0, or in case of an array a count of 0.

There are not options for this validator.

#### SizeValidator

The *SizeValidator* can be used to check if your value has a specific size or is withing a min/max value. 
If the validated field is of type integer the size is just the value of this integer. If it is of type string the size will be the length of the string.
In case the field is of type array the size will be the count of elements.

* `size`: an integer representing the exact size of your value.
* `min`: an integer representing the minimum size (inclusive) of your value.
* `max`: an integer representing the maximum size (inclusive) of your value.

Either option *size*, *min* or *max* must be set. If *size* is passed the *Validator* will always use this.
If *min* and *max* are passed the *Validator* will check if the value is between (inclusive) these two values.

#### TypeValidator

The *TypeValidator* can be used to check the data type of your value.

*Options*:
* `type`: a data type to compare. Valid data types: `int`/`integer`, `string`, `bool`/`boolean`, `array`, `datetime`

*type* is a mandatory option.

#### UniqueValidator

The *UniqueValidator* can be used to check if the value of an Entity attribute is unique in database.

There are not options for this validator.

### Custom validators

Of course, you can also create custom validators for you application. 
Just add a new *Validator* to *application/Validation*, extend the base *Validator* and implement the *IsValid* method as you want.
You can also pass custom options to your validator, see the following example. Don't forget to call the *setOptions* method of the base *Validator*: 
```php
namespace Application\Validation;

use Avolutions\Validation\AbstractValidator;

class CustomValidator extends AbstractValidator
{
    private $foo;

    public function setOptions($options = [], $property = null, $Entity = null) {
        parent::setOptions($options, $property, $Entity);
        $this->foo = $options['foo'];
    }

    public function isValid($value)
    {
        return $value == $this->foo;
    }
}
```

Just add the *Validator* to your mapping file like default validators:
```php
...
'validation' => [
    'custom' => ['foo' => 'bar']
]
...
```

Your property will be valid if the value is *foo* or not if the value is not *foo*.

## AdHoc validation

*Validators* can also be used to validate variables/values not bound to a model/entity.

Just create a new instance of the needed *Validator* with all required options and pass your value to the *isValid* method:
```php
use Avolutions\Validation\FormatValidator;

$url = 'https://avolutions.org';
$Validator = new FormatValidator(['format' => 'url']);

if ($Validator->isValid($url)) {
    // is a valid URL
} else {
    // is not a valid URL
}
```

## Error messages

Every *Validator* have an own error message which can be retrieved by using the `getMessage()` method.
The message can be customized in multiple ways.

### Default message

By default, the error message looks like: `{property} is not valid`.
This message will not be translated.

To override the default message, every *Validator* accepts an option called `message` which can be defined in mapping file:
```php
return [
    'firstname' => [
        'validation' => [
            'type' => [..., 'message' => 'My custom message']
        ]
    ]
];
```

This way the default message looks like `My custom message` instead of `{property} is not valid`. 
To use variables in error messages see [Available variables](#available-variables).

### Localized messages

To use translated error messages for validation you have to add a new file called *validation.php* to the translation folders.
Add a new key for every *Validator* you want to have custom and translated error message:
```php
return [
    'type' => ..., // all messages for TypeValidator
    'custom' => ..., // all messages for CustomValidator
    ...
];
```

There are three ways to specifiy error message per validator:
1. Global error message for *Validator*:
```php
return [
    'type' => 'You are using an invalid type'
];
```
This error message will be displayed for every invalid attribute validated with TypeValidator.

2. Global error message for attribute:
```php
return [
        'type' => [
            'firstname' => 'Firstname must be of type string'
        ]
];
```
This error message will be displayed for every invalid attribute called "firstname" validated with TypeValidator.

3. Error message for attribute per *Entity*:
```php
return [
        'type' => [
            'User' => [
                'firstname' => 'Firstname of user must be of type string'
            ],
            'Person' => [
                'firstname' => 'Firstname of person must be of type string'
            ]
        ]
];
```
If configured like this, the error message is dependent on the *attribute* **and** the Entity context:  
If a *User* is validated, the *TypeValidator* will display `Firstname of user must be of type string` in case of invalid *firstname*.  
If a *Person* is validated, the *TypeValidator* will display `Firstname of person must be of type string` in case of invalid *firstname*.

### Priority of messages

The order on how messages are used is the following, from highest to lowest:
1. *message* option
2. Translated message for *Validator/Entity/attribute*
3. Translated message for *Validator/attribute*
4. Translated message for *Validator*
5. Default message

### Available variables

Every error message can use predefined variables. To use this just add the variable name in brackets to your message.
The following variables are available:
* `{property}`: The validated property. Not working in AdHoc validation.
* `{entity}`: The name of the validated Entity. Not working in AdHoc validation.
* All options of built in validators, e.g. `{operator}` in CompareValidator or `{min}` in SizeValidator