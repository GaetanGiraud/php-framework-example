Light Weight PHP Framework
==========================

1. Goal
----
The goal of this framework is to demonstrate important Web Development concepts in a simple (yet ully functional) way.

The concepts demonstrated in this framework are:
* MVC
* OOP - Inheritance, Abstract classes
* Design patterns: Factory
* Lazy Load
* Database - Abstraction, PDO


2. How to use
----------

This framework implements a traditional MVC framework.

There are a small set of rules that need to be followed: 

* 	The folder structure as defined must be respected.

	Controllers in the Controllers directory etc ...
  
*	Models and Controllers should have the same names.
*	Namespaces: 

	Models should belong to the namespace **Models**.
	Controller to the namespace **Controllers**.
	
*	Files should be named after the Controller / Model class


#### 2.1 Create and set up a Controller

##### 2.1.1 Create a controler

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




## Concepts




### MVC

#### Model

#### View


#### Controller



### Lazy loading



### Object Oriented Programming

####Inheritance


#### Abstract classes



#### Design Patterns

##### Singleton


##### Registry

##### Front Controller


##### Factory


### Database

#### Abstraction


#### PDO Prepared statements


### Misc

#### Config file

#### View helpers


