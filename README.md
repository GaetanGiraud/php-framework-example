Light Weight PHP Framework
==========================

Table of content 

1. Goal
-------
1. Goal
-------
1. Goal
-------
1. Goal
-------
1. Goal
-------



---------------------------------------

1. Goal
-------
The goal of this framework is to demonstrate important (Web) Development concepts in a simple (yet fully functional) way.

The concepts demonstrated in this framework are:
* Model View Controllers
* Object Relational Mapping
* OOP - Inheritance, Abstract classes
* Design patterns: Singleton, Registry, Factory, Front Controller
* Lazy Loading
* Database - Abstraction, PDO


2. How to use
-------------

This framework implements a traditional MVC framework.

All filenames are given related the `BASE_PATH` of the framework.

#### 2.1 Naming Conventions

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
	
*	Files should be named after the Controller / Model class.


#### 2.2 Controllers

##### 2.2.1 Create a controller

To create a controller, create a class that extends the \Core\Controller class.
Make sure the filename match the class name (case insensitive).
Don't forget the namespace declaration. 

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
* `_controller`: The name of the controller

* `_action`: The action name

* `_recordId`: The id of the record (if defined in the route)

Public functions (To use in the view for example):
* `getController`: Returns controller name
* `getAction`: Returns action name

#### 2.3 Models

In Object Relational Mapping fashion, each table row gets represented by an object instance of the corresponding model.

As default the framework assumes that the database model and the model class share the same name.

##### 2.3.1 Create a model

To create a nodel, create a class that extends the \Core\Model class.
Make sure the filename match the class name (case insensitive).
Don't forget the namespace declaration. 

```php
models/resource.php:

namespace Models;

class Ressource extends \Core\Model {
	
} 
```
##### 2.3.2 Operations

 CRUD operations are available on the models as follow:
 
* Static `ModelName::get(order, limit)`: returns an array of objects corresponding to the content of the database table.

* Static `ModelName::find($id)`: returns an object corresponding to the content of the data row identified by `$id`.

* `$object->set($data)` : Set the object properties to the ones provided.

* `$object->save()`: Update database with the changes. For new objects insert a new row in the database.

* `$object->delete()`: Delete the object in the database.


##### 2.3.3 Validation

##### Set up validation

Define validation rules in the `$_rules` array property of the model.

```php
protected $_rules = array (
		'property1' => 'required,email,unique',
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
* `$errMsg`: error message


```php
public function _rule($property, $data) 
{
	
	if ( ! test ) { // define the test to be performed
	
		// record a validation error
		$this->_addValidationError($property, 'Error message');
	}
}
```
		
##### 2.3.4 Options

###### Custom primary key 

To change the default primary key ( set to `id` ), add to your model the following declaration:
	
```php	
protected $_primaryKey = 'myPrimaryKey';
```

###### Custom table name

To change the default table name ( set to the model class name ), add to your model the following declaration:
	
```php	
protected $_table = 'myTable';
```



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
You can also call a subview inside a view:

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

The data is `exploded` and made avalable as separate variables.
In the example above, the `$ressource` variable is made avaible in the view.

##### 2.4.3 Layout file

The `_layout.php` file always gets loaded first.

The original call gets passed through the `$view` variable, and data through `data`:
```
<?php $this->view($view, $data); ?>
```

Do not change the name of the `$view` and `$data` variables!

3. Concepts
-----------

The MVC and ORM concepts are covered in chapter 2.

### 3.1 Lazy loading

#### Loading classes

Class files are loaded only when needed using the magic method `__autoload`.

It relies on respecting the following naming conventions (all case insensitive):
	> * Namespace = folder name
	> * file name = class name

##### Connecting to the database

The database connection is created only if a query needs to be prepared, and thus the database actually used.

If a page doesn't need access to the database, no connection is made.

### 3.2 Object Oriented Programming

#### 3.2.1 Inheritance

Controllers and Models inherit from higher `Core\Controller` and `Core\Model` classes.

Actual controllers and models require a minimal amount of coding to work.

#### 3.2.2 Abstract classes

The `Core\Controller` and `Core\Model` classes are declared abstract and connot be instantiated.

This ensure that no controller will instantiate these classes directly.

### 3.3 Design Patterns

##### 3.3.1 Singleton

Singleton is implemented in the `Core\Registry` class.

`__constructor` is private, and object unclonable.

Calling `Registry::$singleton()` actually retun the singleton instance of Registry.

##### 3.3.2 Registry

Registry is implemented in the `Core\Registry` class.

Classes are loaded by calling the static method `Core\Regisry::load('className')`.

The method checks if the class has alreary been loaded. In this case, it returns the stored object, 
otherwise it instantiates it, and save it into the registry singleton.

```php
public static function load($class) 
{	
	// get the registry singleton.
	$registry = Registry::singleton();
	
	if (!in_array($class, $registry->_isLoaded)) {
		
		// only Core class should be loaded in the Registry
		$className = '\Core\\' . $class; 
		
		try {
			if (class_exists($className, TRUE)) {
				$registry->_objects[ $class ] = new $className();
				$registry->_isLoaded[] = $class;
				
				return $registry->_objects[ $class ];
			}
		} catch (\Exception $e) {
			trigger_error('Error loading a class in the registry: 
					trying to load a non existent class or non Core class ' . $className , E_USER_ERROR);
		}
	} else {
		return $registry->_objects[ $class ];
	}
}
```

##### 3.3.3 Front Controller

Using `mod_rewrite` all transactions are routed to the `public/index.php` file;


```
file: public/.htaccess
<IfModule mod_rewrite.c>

    Options +FollowSymLinks
    RewriteEngine on

    # Send request via index.php
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]

</IfModule>
```

The `Core\Router` class then parse the URI, extrapolates the name of the controller, and calls it.

##### 3.3.4 Factory

The `Core\Model` class implement the factory pattern.

Inside the implementation class,  calling `\Models\MyModel::find($id)` static method returns an object which properties 
contain the database value corresponding with the provided primarey_key value;


### 3.4 Database

#### 3.4.1 Abstraction

The database interface has been abstracted into 5 methods as follow:
*	`query($query)`:  All purpose query functionality. To be used with caution when no other option is available!

	@param String $query the sql query to be performed
		 
	@return array of data fetched from database
	 
*	`select($table, $params = NULL)`: Select in a table with options.
	 
	 @param String $table to query
	 
	 @param Array $params 
	 
	  		Format: array(
	         	'fields' => array('field1, 'field2'),
	         	'where' => array(
	         		'field1' => 'value1',
	         		'field2' => 'value2'
	         	),
	         	'order' => array(
	        	 	'fields' => array('field1', 'field2'),
	      		   	'order' => 'ASC' // optional
	         	),
	         	'limit' => 1
	         	)
	         
	 @return array array of data feched inside the database
	
*	`insert($table, $insertData)`:Insert in a table a new record
	 
	 @param String $table to query
	 
	 @param Array $insertData
	        	
	        	Format: array(
	         	'field1' => 'value1',
	         	'field2' => 'value2'
	         	)
	         
	 @return TRUE || PDO Error information

*	`update($table, $recordId, $updateData)`: Update a record in a table
	 
	 @param String $table to query
	 @param Array $recordId - Format array('primary key' => 'value')
	 @param Array $updateData
	         	
	         	Format: array(
	         	'field1' => 'value1',
	         	'field2' => 'value2'
	         	)
	 @return TRUE || PDO Error information

*	`delete($table, $recordID)`: Delete a record in a table
	 
	 @param String $table to query
	 
	 @param Array $recordId - Format array('primary key' => 'value')
	 
	 @return TRUE || PDO Error information



#### 3.4.2 PDO Prepared statements

PDO is used as database library. Queries are performed exclusively using prepared statements, guarantying the integrity of the database.


4. Misc
-------

### 4.1 Configuration

The `ENVIRONMENT` is set up in the `public/index.php` file. It can be equal to `development`, 'testing` or `production`.

Error reporting otpions are set up as well in the `public/index.php`;

In the `config.php` you can set up the following:
*	Database Config (Specific config for each environment)
*	Root controller & action
*	Application root path
*	View helpers


### 4.2 Flash

A simple (static, no need to instantiate) flash mechanism is built in the framework.

```php
\Core\Flash::add($message, $severity = null); // to add to the flash

\Core\Flash::retrieve(); // retrieve (possible message in the flash

\Core\Flash::refresh(); // refresh the cash

```

A view helper is defined to help retrieve the content of the flash easily.

Just call `flash()` !;

### 4.2 View helpers

#### 4.2.1 Load view helpers libraries

View helpers are available to use in the views.

These are just regular functions.

Helpers libraries are loaded in the config file:

```php
file: `config.php`

// Add the name of the library you wish to load to the array(including custom libraries)
helpers(array('core', 'custom'));
```

The name of the helpers library need to match the one of the file where it resides.

#### 4.2.2 Helpers Definition

Following helpers are defined in the core library:

*	`flash()`: Return content of the flash (see above)
*	`link_to($url, $value, $title = null)`: Return anchor tag 
*	`validationErrors($object)`: Retrieve validation errors and format them for human viewing
* 	`input($name, $options = array())`: Return `input(type = 'text')` tag
*	`textarea($name, $value = null, $options = array())`: Return `textareas` tag
*	`submit($value, $options = array())`: Return `submit` tag
*	`base_url($uri)`: Return url from uri;

#### 4.2.3 Custom Helpers

You can create custom helpers very easily:
*	Create a new php file in the `helpers/` directory (And not the `core\helpers`, these are restricted !) ...
* 	... or edit an exiting one.
*	Load your library in the config file!


5. TODO
-----------

A few ideas to improve the framework:

* 	Improve error reporting and Exception handling

*	Introduce caching.

* 	Improve portability (Windows systems)m

*	Extend the database management facilities:
	* migrations
	* extended set of operations
	* ensure compatibility with other DBMS than MySQL.
	* add NoSQL compatibility

* Introduce localisation & Time Management.

* Extend Flash to accept more than just one message.

* And much more ...

