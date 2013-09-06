Light Weight PHP Framework
==========================

---------------------------------------

1. Goal
-------
The goal of this framework is to demonstrate important (Web) Development concepts in a simple (yet fully functional) way.

The concepts demonstrated in this framework are:
* Model View Controllers
* Oject Relational Mapping
* OOP - Inheritance, Abstract classes
* Design patterns: Singleton, Registry, Factory
* Lazy Loading
* Database - Abstraction, PDO


2. How to use
-------------

This framework implements a traditional MVC framework.

All filenames are given related the `BASE_PATH` of the framework.

#### 2.1 Formating Rules

There are a small set of rules that need to be followed: 

* 	The folder structure as defined must be respected.

	*	Controllers in the `controllers/` directory.
	
	*	Models in the `models/` directory.
	
	* 	Views in the `views/` directory.
	
	*	Helpers in the `helpers/` directory.
	
	
  
*	Models and Controllers should have the same names.
*	Namespaces: 

	Models should belong to the namespace **Models**.
	
	Controller to the namespace **Controllers**.
	
*	Files should be named after the Controller / Model class


#### 2.2 Controllers

##### 2.2.1 Create a controller

To create a controller, create a php file. 

```php
controllers/resource.php:

namespace Controllers;

class Resource extends \Core\Controller {
	
	public function index() {
		// action
	}
}
```

##### 2.2.2 Create an action

To create an action, simply create a `public function` named after the action
	

##### 2.2.3 Available methods

Protected properties (only reachable inside the controller): 
* _controller: The name of the controller

* _action: The action name

* _recordId: The id of the record (if defined in the route)

Public functions (To use in the view for example):
* getController: Returns controller name
* getAction: Returns action name

#### 2.3 Models

In Object Relationship Mapping fashion, each table row gets represented by an object instance of the corresponding model.

As default the framework assumes that the datable model and the model class share the same name.

##### 2.3.1 Create a model

To create a controller, create a php file. 

```php
controllers/resource.php:

namespace Models;

class myModel extends \Core\Model {
	
	} 
```
##### 2.3.2 Operations

 CRUD operations are available on the models as follow:
 
* Static `ModelName::get(order, limit)`: returns an array of objects corresponding to the content of the database table.

* Static `ModelName::find($id)`: returns an object corresponding to the content of the data row identified by `$id`.

* `$object->set($data)` : Set the object properties to the ones provided.

* `$object->save($data)`: Update database with the changes. For new objects insert a new row.

* `$object->delete()`: Delete the object in the database.


##### 2.3.3 Validation

##### Set up validation

Define validation rules in the `rules` array

```php
protected $_rules = array (
		'property1' => 'comma separated list of validation rules',
		'property2' => 'comma separated list of validation rules'
);
```
At the point of writing, only the **required** has been defined. 

##### Create custom validation names

Create custom validation rules by creating a method of the same name as the custom validation rule.
The method should take as arguments:
* `$property` : the name of the property to which the rule apply
* `$data`: the data set to validate against

Validation errors are recorded using the `_addValidationError($property, $errMsg)` method taking as arguments:
* `$property`: property under scrutiny
* `$errMsg`: error message message


```php
public function _rule($property, $data) 
{
	
	if ( ! test ) { // define the test to be performed
	
		// record a validation error using the model `_addValidationError` mthod
		$this->_addValidationError($property, ucfirst($property) . ' should be not Null');
	}
}
```
		
##### 2.3.4 Options

###### Custom primary key 

To change the default ( `id` ), add to your model the following declaration:
	
```php	
protected $_primaryKey = 'myPrimaryKey';
```

###### Custom table name

To change the default ( set to the model class name ), add to your model the following declaration:
	
```php	
protected $_table = 'myTable';
```


To create an action, simply create a `public function` named after the action
	

##### 2.3.3 Available methods

Protected properties (only reachable inside the controller): 
* `_controller`: The name of the controller

* `_action`: The action name

* `_recordId`: The id of the record (if defined in the route)

Public functions (To use in the view for example):
* `getController`: Returns controller name
* `getAction`: Returns action name


#### 2.4 Views

##### 2.4.1 Caling a view

Calling a view inside a controller:

```php
class MyResource extends Controller {

	public function index()
	{
		$this->view('index');
	}

}
```
You can also call subview inside a view:

```php
<html>
[ ... ]
<body>

	<?php $this->view('components/subview'); ?>

</body>

<html>
```

You can define as many subviews as necessary without limitations.


##### 2.4.2 Passing Data

You can pass data to a view by passing an associative array as argument to the method call:

```php
// The $ressource variable is made available to the view
$this->view($view, $data = array( 'ressource'= > $myRessource ));
```

##### 2.4.3 Layout file

The `_layout.php` file always gets loaded first.

The original call gets passed through the `$view` variable, and data through `data`:
```
<?php $this->view($view, $data); ?>
```

Do not change the name of these variables!

3. Concepts
-----------

### 3.1 MVC

#### 3.2 Model

#### 3.3 View

#### 3.4 Controller

### 3.2 Lazy loading


### 3.3 Object Oriented Programming

#### 3.3.1 Inheritance


#### 3.3.2 Abstract classes


### 3.3 Design Patterns

##### 3.3.1 Singleton


##### 3.3.2 Registry

##### 3.3.3 Front Controller


##### 3.3.4 Factory


### 3.4 Database

#### 3.4.1 Abstraction


#### 3.4.2 PDO Prepared statements


### 4 Misc

#### 4.1 Config file

#### 4.2 View helpers


