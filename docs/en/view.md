# Views

* [Introduction](#introduction)
* [Examples](#examples)
  * [Create a simple view](#create-a-simple-view)
  * [Create a view with variable content](#create-a-view-with-variable-content)

## Introduction

Views are files that contains any representation of the application. This allows the separation from the application logic.
Views normally contains HTML, CSS and PHP and can also contain variable content that will be passed from the [Controller](controller.md) via [ViewModels](viewmodel.md).

Every View file has to be stored into *application/View* and its subdirectories.

## Examples
### Create a simple view

To create a View that will be returned by the first example above, just create a new file in *application/View/user/* named *show.php*:
```html
<html>
  <head>
    <title>Show user</title>
  </head>
  <body>
    Hello world
  </body>
</html>
```
This example will result in the following output:
```
Hello world
```

### Create a view with variable content

As mentioned above, Views can also contains variable content, that will be filled with data from the [Controller](controller.md) and [ViewModel](viewmodel.md). The following example shows how to display the data passed by the [ViewModel](viewmodel.md) in the third [Controller](controller.md) example:
```html
<html>
  <head>
    <title>Show user</title>
  </head>
  <body>
     Hello <?php print $ViewModel->username; ?>
  </body>
</html>
```
This example will result in the following output:
```
Hello Alex
```
