# Mapping

* [Introduction](#introduction)
* [Mapping attributes](#mapping-attributes)
* [Example](#example)

## Introduction

The mapping file contains a multidimensional array, where every key represents one property of the Entity.
Every property can have a multidimensional array of options as value.

## Mapping attributes

Attribute | Default value | Description
--- | --- | ---
[column] | The name of the property | Defines the name of database column which the property is connected to. Will be set to the name of the property if it is not sepcified.
[type] | | Defines the datatype of the property if it is of type Entity.
[form][type] | "text" | Defines the input type of the property in forms.
[form][label] | The name of the property | Defines the text for the label in forms.
[form][hidden] | false | If set to true this field will not be rendered into forms.
[form][options] | | An array of options if the form type is set to "select".
[validation] | | An array of *Validators*, see [Validation](validation.md)

## Example

*Example of a mapping file (application/Mapping/UserMapping.php*):
```php
return [
    'id' => [
        'column' => 'UserID'
    ],
    'firstname' => [
        'validation' => [
            'required',
            'size' => ['max' => 15]
        ]
    ],
    'lastname' => [],
    'hobbies' => [
        'form' => [
            'type' => 'textarea'
        ]
    ],
    'genderID' => [
        'column' => 'GenderID',
        'form' => [
            'type' => 'select',
            'options' => ['1' => 'male', '2' => 'female', '3' => 'other'],
            'label' => 'Choose gender'
        ]
    ],
    'Gender' => [
        'column' => 'GenderID',
        'type' => 'Gender',
        'form' => [
            'hidden' => true
        ]
    ]
];
```

This example will do the following:
1. Maps the Entity "User" to the database table "user" (by naming convention).
2. The property id (inherits from Entity class) will be mapped to the table field "UserID".
3. The properties "firstname", "lastname" and "hobbies" are mapped to the columns "firstname", "lastname" and "hobbies" by naming convention, because no "column" property is set.
4. The properties "firstname", "lastname" will be rendered as a input of type "text" (default value).
5. The property "firstname" is required and may not be longer than 15 characters.
5. The property "hobbies" will be rendered as a "textarea"
6. The property "genderID" will be mapped to the column "GenderID" and displayed as a select box with the options "male", "female" and "other". The label will show the text "Choose gender".
7. The property "Gender" will also be mapped to the column "GenderID" but will be of type "Gender (= Entity) in the User model automatically. The ORM framework will automatically join the defined column (GenderID) to the id column of the Gender entity. The field will not be displayed in generated forms.