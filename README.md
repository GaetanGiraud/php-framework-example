Light Weight PHP Framework
==========================

---------------------------------------

1. Goal
-------
The goal of this framework is to demonstrate important (Web) Development concepts in a simple (yet fully functional) way.

The concepts demonstrated in this framework are:
* Model View Controllers
* OOP - Inheritance, Abstract classes
* Design patterns: Singleton, Registry, Factory
* Lazy Loading
* Database - Abstraction, PDO

---------------------------------------

2. How to use
-------------

This framework implements a traditional MVC framework.

There are a small set of rules that need to be followed: 

* 	The folder structure as defined must be respected.

	*	Controllers in the Controllers directory.
	
	*	Models in the Models directory.
	
	* 	Views in the Views directory.
	
	*	Helpers in the Helpers directory.
	
	
  
*	Models and Controllers should have the same names.
*	Namespaces: 

	Models should belong to the namespace **Models**.
	
	Controller to the namespace **Controllers**.
	
*	Files should be named after the Controller / Model class


#### 2.1 Create and set up a Controller

##### 2.1.1 Create a controller

To create a controller, create a php file. 

```php
controllers/resource.php:

namespace Controllers;

class Resource extends \Core\Controller {
	
	public function index() {
		// action
	}
}```

##### 2.1.1 Create an action

To create an action, simply create a `public function` named after the action
	

##### 2.1.3 Available methods

Protected properties (only reachable inside the controller): 
* _controller: The name of the controller

* _action: The action name

* _recordId: The id of the record (if defined in the route)

Public functions (To use in the view for example):
* getController: Returns controller name
* getAction: Returns action name


#### Create and set up a Model




3. Concepts
-----------

---------------------------------------

### 3.1 MVC

#### 3.2 Model

#### 3.3 View

#### 3.4 Controller

---------------------------------------

### 3.2 Lazy loading

---------------------------------------

### 3.3 Object Oriented Programming

#### 3.3.1 Inheritance


#### 3.3.2 Abstract classes

---------------------------------------

### 3.3 Design Patterns

##### 3.3.1 Singleton


##### 3.3.2 Registry

##### 3.3.3 Front Controller


##### 3.3.4 Factory

---------------------------------------

### 3.4 Database

#### 3.4.1 Abstraction


#### 3.4.2 PDO Prepared statements

---------------------------------------

### 4 Misc

#### 4.1 Config file

#### 4.2 View helpers


