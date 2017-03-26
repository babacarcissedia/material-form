MaterialForm
========

[![Code Climate](https://codeclimate.com/github/bcdbuddy/material-form/badges/gpa.svg)](https://codeclimate.com/github/bcdbuddy/material-form)
[![Coverage Status](https://coveralls.io/repos/bcdbuddy/material-form/badge.svg?branch=master)](https://coveralls.io/r/bcdbuddy/material-form?branch=master)

- [Installation](#installation)
- [Basic Usage](#basic-usage)
- [Using material icons](#using-material-icons)
- [Automatic Validation State](#automatic-validation-state)
- [Model Binding](#model-binding)
- [Advance usages](#advance-usages)
- [Licence](#licence)

## Installation

You can install this package via Composer by running this command in your terminal in the root of your project:

```bash
composer require bcdbuddy/material-form
```

### Laravel

> This package works great as a replacement Form Builder that was removed in Laravel 5. The API is different but all of the features are there.

If you are using Laravel 4 or 5, you can register the FormServiceProvider to automatically gain access to the Old Input and Error Message functionality.

To do so, just update the `providers` array in your `config/app.php`:

```php
'providers' => [
    //...
    'bcdbuddy\MaterialForm\ServiceProvider'
],
```

You can also choose to use the Facade by adding an alias in `config/app.php`:

```php
'aliases' => [
    //...
    'MaterialForm' => 'bcdbuddy\MaterialForm\Facades\MaterialForm',
],
```

You can now start using MaterialForms by calling methods directly on the `MaterialForm` facade:

```php
MaterialForm::email('Email', 'email');
MaterialForm::text('First name', 'first_name');
MaterialForm::password('Password', 'password');
```

### Outside of Laravel

Usage outside of Laravel is a little trickier since there's a bit of a dependency stack you need to build up, but it's not too tricky.

```php
$formBuilder = new bcdbuddy\MaterialForm\FormBuilder;

$formBuilder->setOldInputProvider($myOldInputProvider);
$formBuilder->setErrorStore($myErrorStore);
$formBuilder->setToken($myCsrfToken);

$basicMaterialFormsBuilder = new bcdbuddy\MaterialForms\BasicFormBuilder($formBuilder);
$horizontalMaterialFormsBuilder = new bcdbuddy\MaterialForms\HorizontalFormBuilder($formBuilder);

$bootForm = new bcdbuddy\MaterialForms\MaterialForm($basicMaterialFormsBuilder, $horizontalMaterialFormsBuilder);
```

> Note: You must provide your own implementations of `bcdbuddy\Form\OldInputInterface` and `bcdbuddy\Form\ErrorStoreInterface` when not using the implementations meant for Laravel.

## Basic Usage

MaterialForms lets you create a label and form control and wrap it all in a form group in one call.

```php
//  <form method="POST">
//    <div class="input-field">
//      <label for="field_name">Field Label</label>
//      <input type="text" id="field_name" name="field_name">
//    </div>
//  </form>
{!! MaterialForm::open() !!}
    {!! MaterialForm::text('Field Label', 'field_name') !!}
{!! MaterialForm::close() !!}
```

> Note: Don't forget to `open()` forms before trying to create fields!

### Customizing Elements

If you need to customize your form elements in any way (such as adding a default value or placeholder to a text element), simply chain the calls you need to make and they will fall through to the underlying form element.

Attributes can be added either via the `attribute` method, or by simply using the attribute name as the method name.

```php
// <div class="input-field">
//    <input type="text" id="first_name" name="first_name" placeholder="John Doe">
//    <label for="first_name">First Name</label>
// </div>
MaterialForm::text('First Name', 'first_name')->placeholder('John Doe');

// <div class="input-field">
//   <select  id="color" name="color">
//     <option value="red">Red</option>
//     <option value="green" selected>Green</option>
//   </select>
//   <label for="color">Color</label>
// </div>
MaterialForm::select('Color', 'color')->options(['red' => 'Red', 'green' => 'Green'])->select('green');

// <form method="GET" action="/users">
MaterialForm::open()->get()->action('/users');

// <div class="input-field">
//    <label for="first_name">First Name</label>
//    <input type="text" id="first_name" name="first_name" value="John Doe">
// </div>
MaterialForm::text('First Name', 'first_name')->defaultValue('John Doe');
```

## Using material icons
```php
MaterialForm::open()->post()->action('/posts/'. $post->id);
    MaterialForm::bind($post)
    MaterialForm::text("Title", "title")
    MaterialForm::textarea("Content", "content")
    MaterialForm::submit("Save")->icon('save')
MaterialForm::close()
```

or

```php
MaterialForm::open()->post()->action('/user/login');
    MaterialForm::text("Login", "login")->icon("account_circle")
    MaterialForm::password("Password", "password")->icon("security")
    MaterialForm::submit("Login")->icon('')
MaterialForm::close()
```


### Reduced Boilerplate

Typical Materialize form boilerplate might look something like this:

```html
<form>
  <div class="input-field">
    <input type="text" name="first_name" id="first_name">
    <label for="first_name">First Name</label>
  </div>
  <div class="input-field">
    <input type="text" name="last_name" id="last_name">
    <label for="last_name">Last Name</label>
  </div>
  <div class="input-field">
    <input type="date" name="date_of_birth" id="date_of_birth">
    <label for="date_of_birth">Date of Birth</label>
  </div>
  <div class="input-field">
    <input type="email" name="email" id="email">
    <label for="email">Email address</label>
  </div>
  <div class="input-field">
    <input type="password" name="password" id="password">
    <label for="password">Password</label>
  </div>
  <button type="submit" class="btn waves-effect waves-light">Submit</button>
</form>
```

MaterialForms makes a few decisions for you and allows you to pare it down a bit more:

```php
{!! MaterialForm::open() !!}
  {!! MaterialForm::text('First Name', 'first_name') !!}
  {!! MaterialForm::text('Last Name', 'last_name') !!}
  {!! MaterialForm::date('Date of Birth', 'date_of_birth') !!}
  {!! MaterialForm::email('Email', 'email') !!}
  {!! MaterialForm::password('Password', 'password') !!}
  {!! MaterialForm::submit('Submit') !!}
{!! MaterialForm::close() !!}
```

### Automatic Validation State

Another nice thing about MaterialForms is that it will automatically add error states and error messages to your controls if it sees an error for that control in the error store.

Essentially, this takes code that would normally look like this:

```php
<div class="input-field">
  <input type="text" id="first_name" data-error="{!! $errors->first('first_name')"/>
  <label for="first_name">First Name</label>
</div>
```

And reduces it to this:

```php
{!! MaterialForm::text('First Name', 'first_name') !!}
```

...with the `data-error` class being added automatically if there is an error in the session.


### Model Binding

MaterialForms makes it easy to bind an object to a form to provide default values. Read more about it [here](https://github.com/bcdbuddy/form#model-binding).

```php
MaterialForm::open()->action( route('users.update', $user) )->put()
MaterialForm::bind($user)
MaterialForm::close()
```

## Advance usages
```php
{!! MaterialForm::open() !!}
    {!! MaterialForm::text("Last name", "last_name")->data("length", 10) !!}
    {!! MaterialForm::email("Email", "email") !!}
    {!! MaterialForm::password("Password", "password") !!}
    {!! MaterialForm::file("File", "file")->placeholder("some file to upload") !!}
    {!! MaterialForm::checkbox("Remember", "remember")->checked() !!}
    {!! MaterialForm::checkbox("HTML", "html")->disabled()->checked() !!}
    {!! MaterialForm::checkbox("Remember filled-in", "remember filled-in")->addClass("filled-in")->checked() !!}
    {!! MaterialForm::checkbox("Safe", "safe")->addClass("filled-in")->disabled()->checked() !!}
    {!! MaterialForm::checkbox("Save", "save")->addClass("filled-in")->disabled()!!}
    {!! MaterialForm::switchCheck("On", "Off", "state") !!}
    {!! MaterialForm::select("One Select", "one_select", ["1", "2", "5", "10"]) !!}
    {!! MaterialForm::select("One icon Select", "one_icon_select", ["1", "2", "5", "10"], ["http://lorempicsum.com/futurama/350/200/1", "http://lorempicsum.com/futurama/350/200/2", "http://lorempicsum.com/futurama/350/200/5", "http://lorempicsum.com/futurama/350/200/6"])->left() !!} // or right()
    {!! MaterialForm::submit("Send")->icon("send") !!}
{!! MaterialForm::close() !!}
```

## Output
![result](output.png)


## Credits

- [Adam Wathan BootForms](https://github.com/adamwathan/bootforms)


## Licence 
[MIT](LICENSE)