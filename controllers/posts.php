<?php
namespace Controllers;

//use Models;
class Posts extends \Core\Controller {
	
	/**
	 * Index of all posts
	 */
	public function index() {
		$order = array ('fields' => array ('id'),
						'order' => 'DESC' );
		
		$posts = \Models\Posts::get($order, 10);
		
		$data = array('posts' => $posts );
		
		$this->view('posts/index', $data);
	}
	
	/**
	 * Edit action
	 */
	public function edit() {
		if (!$this->_recordId) {
			//TODO Flash mechanisme
			header('location: /posts');
			exit();
		} else {
			$post = \Models\Posts::find($this->_recordId);
		}
		
		$this->view('posts/edit', array('post' => $post));
	}
	
	/**
	 * Add a new post
	 */
	public function add() {
		// create empty post object
		$post = new \Models\Posts();
		
		$this->view('posts/add', array('post' => $post));
	}
	
	/**
	 * Create the post in the database
	 */
	public function create() {
		// create new post based on POST input
		$post = new \Models\Posts($_POST);
		
		$id = $post->save();
		
		//TODO redirect function
		if($id) {
			header('location: /posts/' . $id );
		} else {
			$this->view('posts/add', array('post' => $post ));
		} 
	}
	
	
	/**
	 * Show a post
	 */
	public function show() {
		$post = \Models\Posts::find($this->_recordId);
		
		if($post) {
			$this->view('posts/show', array('post' => $post));
		} else {
			header('location: /posts');
		}
	}
	
	
	/**
	 * Update a post
	 */
	public function update() {
		// retrieve the post record
		$post = \Models\Posts::find($_POST['id']);
		
		// update the post record object
		$post->set($_POST);
		
		// save in the database
		if ($post->save()) {
			header('location: /posts/' . $this->id);
		} else {
			$this->view('posts/edit', array('post' => $post));
		}
		
	}
	
	
	/**
	 * Delete a post
	 */
	public function delete() {
		// retrieve the post
		$post = \Models\Posts::find($this->_recordId);
	
		// delete the post
		if($post->delete()) {
			header('location: /posts');
		}
	
	}
}	