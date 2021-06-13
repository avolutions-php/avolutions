# Form

* [Introduction](#introduction)
* [The manual way](#the-manual-way)
  * [A simple form](#a-simple-form)
  * [Configure a form](#configure-a-form)
  * [Passing a form from Controller/ViewModel](#passing-a-form-from-controllerviewmodel)
* [Generate forms for Entities](#generate-forms-for-entities)
* [Show validation errors](#show-validation-errors)
* [Input controls](#input-controls)

## Introduction

With the help of the *Form* class, forms can be easily created manually or generated automatically for Entities.

## The manual way

There are several methods in the *Form* class to create forms very easy and fast.
A HTML form consists of an opening *<form>* tag, one or multiple input controls and a closing *</form>* tag.

### A simple form
All these elements can be created with the help of the Form class, see the following example:
```php
use Avolutions\View\Form;

$Form = new Form();

print $Form->open();
print $Form->text();
print $Form->submit();
print $Form->close();
```
This will result in the following output:
```html
<form>
<input type="text" />
<input type="submit" />
</form>
```
A very simple but working form. A list with all input types can be found further down.

### Configure a form

In most cases, the HTML elements of an form needs to have attributes. Therefore nearly every *Form* method accepts an array of attributes (keys) and values (value):
```php
use Avolutions\View\Form;

$Form = new Form();

print $Form->open(['method' => 'POST']);
print $Form->text(['name' => 'username']);
print $Form->submit(['name' => 'submit', 'value' => 'save']);
print $Form->close();
```
This will result in the following output:
```html
<form method="POST">
<input type="text" name="username" />
<input type="submit" name="submit" value="save" />
</form>
```

### Passing a form from Controller/ViewModel

It is of course possible to initialize a *Form* in the ViewModel/Controller and pass it to the *View*.

*Controller:*
```php
namespace Application\Controller;

use Application\ViewModel\UserViewModel;
use Avolutions\Controller\Controller;

class UserController extends Controller {

  public function formAction($id)
  {
    $ViewModel = new ViewModel();
    $ViewModel->Form = new Form();

    return new View('form', $ViewModel);
  }
}
```
*View:*
```php
print $ViewModel->Form->open(['method' => 'POST']);
print $ViewModel->Form->text(['name' => 'username']);
print $ViewModel->Form->submit(['name' => 'submit', 'value' => 'save']);
print $ViewModel->Form->close();
```
## Generate forms for Entities

The easiest way to generate a form for an *Entity* is to use the *generate* method.
This method will generate a form depending on the fields and the *Mapping* of the *Entity*.

Let's say we have the following *Entity*:
```php
namespace Application\Model;

use Avolutions\Orm\Entity;

class User extends Entity
{
    public $firstname;
    public $lastname;
    public $hobbies;
    public $gender;
}
```
And *Mapping*:
```php
return [
    'id' => [
        'column' => 'UserID'
    ],
    'firstname' => [],
    'lastname' => [],
    'hobbies' => [
        'form' => [
            'type' => 'textarea'
        ]
    ],
    'gender' => [
        'column' => 'Gender',
        'form' => [
            'type' => 'select',
            'options' => ['1' => 'male', '2' => 'female', '3' => 'other'],
            'label' => 'Choose gender'
        ]
    ]
];
```

First we have to create a form with an *Entity* context and call the *generate* method:

```php
use Application\Model\User;
use Avolutions\View\Form;

$User = new User();
$Form = new Form($User);

print $Form->generate(['method' => 'POST']);
```
This will lead to the following output:
```html
<form method="POST">
  <input name="user[id]" type="hidden" />
  <label>firstname</label><input name="user[firstname]" type="text" />
  <label>lastname</label><input name="user[lastname]" type="text" />
  <label>hoobies</label><textarea name="user[lastname]"></textarea>
  <label>Choose gender</label>
  <select name="user[genderID]">
    <option value="1">male</option>
    <option value="2" selected>female</option>
    <option value="3">other</option>
  </select>
  <input type="submit" />
</form>
```

The *generate* method can only be used for very easy forms, because there is no opportunity to customize or configure it very much.
If a much more custom form is needed for an *Entity* the *inputFor* method can be used. This will generate an input control based on the *Entity* and *Mapping*.

```php
use Application\Model\User;
use Avolutions\View\Form;

$User = new User();
$Form = new Form($User);

print $Form->open(['method' => 'POST']);
print $ViewModel->entityForm->inputFor('firstname', false);
print $ViewModel->entityForm->inputFor('gender', false);
print $Form->submit(['name' => 'submit', 'value' => 'save']);
print $Form->close();
```
This will only create inputs for "firstname" and "gender" but still based on the *Mapping*:
```html
<form method="POST">
  <input name="user[firstname]" type="text" />
  <select name="user[genderID]">
    <option value="1">male</option>
    <option value="2" selected>female</option>
    <option value="3">other</option>
  </select>
  <input type="submit" name="submit" value="save" />
</form>
```

## Show validation errors

If you create a form for an *Entity*, validation errors will be automatically rendered as soon as the Entity was validated.
The message is rendered as a simple `div` tag after the input element. There is one `div` for every Validator message.
You can customize the message by using the automatically added CSS class `error`.

```html
<form method="POST">
  <label>firstname</label><input name="user[firstname]" type="text" />
  <div class="error">Firstname is required.</div>
  ...
</form>
```

If you want to pass custom error messages to a *Form*, this can be done by using the `error` parameter of the Form constructor:
```php
use Avolutions\View\Form;

$Form = new Form(null, ['firstname' => 'Firstname is required.']);

print $Form->open(['method' => 'POST']);
print $Form->inputFor('firstname', ['class' => 'my-input'], false);
print $Form->close();
```
```html
<form method="POST">
  <input name="user[firstname]" type="text" class="my-input" />
  <div class="error">Firstname is required.</div>
</form>
```

## Input controls

The following input control can be generated with the *Form* class:

Method | Output | Description</th>
--- | --- | ---
checkbox() | <input type="checkbox" /> | Creates a HTML input element of type checkbox.
color() | <input type="color" /> | Creates a HTML input element of type color.
date() | <input type="date" /> | Creates a HTML input element of type date.
datetime() | <input type="datetime-local" /> | Creates a HTML input element of type datetime-local.
email() | <input type="email" /> | Creates a HTML input element of type email.
file() | <input type="file" /> | Creates a HTML input element of type file.
hidden() | <input type="hidden" /> | Creates a HTML input element of type hidden.
image() | <input type="image" /> | Creates a HTML input element of type image.
label() | <label></label> | Creates a HTML label element.
month() | <input type="month" /> | Creates a HTML input element of type month.
number() | <input type="number" /> | Creates a HTML input element of type number.
password() | <input type="password" /> | Creates a HTML input element of type password.
radio()	 | <input type="radio" /> | Creates a HTML input element of type radio.
range() | <input type="range" /> | Creates a HTML input element of type range.
reset()	 | <input type="reset" /> | Creates a HTML input element of type reset.
search() | <input type="search" /> | Creates a HTML input element of type search.
submit() | <input type="submit" /> | Creates a HTML input element of type submit.
tel() | <input type="tel" /> | Creates a HTML input element of type tel.
text() | <input type="text" /> | Creates a HTML input element of type text.
time() | <input type="time" /> | Creates a HTML input element of type time.
url() | <input type="url" /> | Creates a HTML input element of type url.
week() | <input type="week" /> | Creates a HTML input element of type week.
input() | <input /> | Creates a HTML input element.
button() | <button></button> | Creates a HTML button element.
textarea() | <textarea></textarea> | Creates a HTML textarea element.
select() | <select></select> | Creates a HTML select element with the given options.