# Forms

_Convenient way to generate HTML forms_

[Since 0.5.0]

<i class="fa fa-wrench fa-2x" aria-hidden="true"></i> Not implemented yet! - Planned release: 0.6.3

- [Introduction](#introduction)
- [Form Building](#building)
    - [Available Methods](#available-methods)
- [Form Validation](#validation)

<a name="introduction"></a>
## Introduction

Sicherheit:
- Cross-Site Request Forgery (CSRF)
- Cross-Site Scripting (XSS)
- URL attack, control codes, invalid UTF-8
- validate sent data both client-side (JavaScript) and server-side

<a name="building"></a>
## Form Building

### Opening A Form

	{{ Form::open(array('url' => 'foo/bar')) }}
		//
	{{ Form::close() }}

By default, a `POST` method will be assumed; however, you are free to specify another method:

	echo Form::open(array('url' => 'foo/bar', 'method' => 'put'))

> **Note:** Since HTML forms only support `POST` and `GET`, `PUT` and `DELETE` methods will be spoofed by automatically 
adding a `_method` hidden field to your form.

You may also open forms that point to named routes or controller actions:

	echo Form::open(array('route' => 'route.name'))

	echo Form::open(array('action' => 'Controller@method'))

You may pass in route parameters as well:

	echo Form::open(array('route' => array('route.name', $user->id)))

	echo Form::open(array('action' => array('Controller@method', $user->id)))

Often, you will want to populate a form based on the contents of a model. To do so, use the `Form::model` method:

	echo Form::model($user, array('route' => array('user.update', $user->id)))

Now, when you generate a form element, like a text input, the model's value matching the field's name will automatically 
be set as the field value. So, for example, for a text input named `email`, the user model's `email` attribute would be 
set as the value. 

<a name="available-methods"></a>
### Available Methods

The Forms object has these methods:

<div class="method-list" markdown="1">

[button](#method-button)
[checkbox](#method-checkbox)
[email](#method-email)
[file](#method-file)
[hidden](#method-hidden)
[label](#method-label)
[number](#method-number)
[password](#method-password)
[radio](#method-radio)
[submit](#method-submit)
[select](#method-select)
[textarea](#method-textarea)
[text](#method-text)

</div>

<a name="method-listing"></a>
### Method Listing

<a name="method-button"></a>
#### `button()` {.method .first-method}

	echo Form::button('Click Me!');


<a name="method-checkbox"></a>
#### `checkbox()` {.method}

	echo Form::radio('name', 'value');

Checkbox that is checked

	echo Form::checkbox('name', 'value', true);


<a name="method-email"></a>
#### `email()` {.method}	

	echo Form::text('email', 'example@gmail.com');
	
	echo Form::email($name, $value = null, $attributes = array());


<a name="method-file"></a>
#### `file()` {.method}

	echo Form::file('image');

	echo Form::file($name, $attributes = array());
	
    <!--
    (s. FuelPHP, https://fuelphp.com/docs/classes/upload/usage.html)
    -->


<a name="method-hidden"></a>
#### `hidden()` {.method}	

	echo Form::hidden('email', 'example@gmail.com');


<a name="method-label"></a>
#### `label()` {.method}

	echo Form::label('email', 'E-Mail Address');

Specifying Extra HTML Attributes

	echo Form::label('email', 'E-Mail Address', array('class' => 'awesome'));


<a name="method-number"></a>
#### `number()` {.method}

	echo Form::number('name', 'value');


<a name="method-password"></a>
#### `password()` {.method}

	echo Form::password('password');


<a name="method-radio"></a>
#### `radio()` {.method}

	echo Form::radio('name', 'value');

Radio that is checked

	echo Form::radio('name', 'value', true);


<a name="method-submit"></a>
#### `submit()` {.method}

	echo Form::submit('Click Me!');


<a name="method-select"></a>
#### `select()` {.method}

	echo Form::select('size', array('L' => 'Large', 'S' => 'Small'));

Drop-Down List with selected default:

	echo Form::select('size', array('L' => 'Large', 'S' => 'Small'), 'S');

Grouped List:

	echo Form::select('animal', array(
		'Cats' => array('leopard' => 'Leopard'),
		'Dogs' => array('spaniel' => 'Spaniel'),
	));

Drop-Down List with a range:

    echo Form::selectRange('number', 10, 20);


<a name="method-textarea"></a>
#### `textarea()` {.method}	

	echo Form::textarea('comment');
	
	
<a name="method-text"></a>
#### `text()` {.method}

	echo Form::text('username');

	
<a name="validation"></a>
## Form Validation

<i class="fa fa-wrench fa-2x" aria-hidden="true"></i> Not implemented yet! - Planned release: 0.6.7

- validate sent data both client-side (JavaScript) and server-side

[jQuery Form Validator](http://www.formvalidator.net/index.html), licensed under [MIT License](http://www.formvalidator.net/index.html#license).

TODO
