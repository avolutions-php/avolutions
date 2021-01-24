# Validation

* [Introduction](#introduction)
* [Entity validation](#entity-validation)
  * [Built in validators](#built-in-validators)
    * [CompareValidator](#comparevalidator)
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

## Introduction



## Entity validation

### Add validation to Entity

### Built in validators

There are several built in validators in the AVOLUTIONS framework which can be used to validate values.

#### CompareValidator

The *CompareValidator* can be used to perform validations using the common comparison validators.

*Options*:
* `operator`: a comparison operator. Default value: `==`.  Valid operators: `==`, `===`, `!=`, `!==`, `>`, `>=`, `<`, `<=`
* `value`: a static value to compare your value to.
* `attribute`: the name of an Entity attribute to compare you value to.

Either *value* or *attribute* must be set. If both are passed, *attribute* will be used.

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
* `type`: a data type to compare. Valid data types: `int`/`integer`, `string`, `bool`/`boolean`, `array`

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
    print $Validator->getMessage();
}
```

## Error messages