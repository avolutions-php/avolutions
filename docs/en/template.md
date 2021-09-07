# Template Engine

* [Introduction](#introduction)

## Introduction

## Variables

```html
{{ $foo }}
{{ $foo.bar }}
```

## If

```html
{{ if }}
{{ elseif }}
{{ else }}
{{ /if }} 
```
// alternativ: {{ endif }}

## Loop

```html
<ul>
{{ for user in $users }}
  <li>{{ user.name }}</li>
{{ /for }}  
</ul>
```
// alternativ: {{ endfor }}

## inlucde

## inheritance