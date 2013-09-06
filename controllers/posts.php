<?php
/**
 * GG Framework
 *
 * A lightweight example PHP framework
 *
 * @version 	0.1
 * @author 		Gaëtan Giraud
 * @copyright 	2013.
 * @license		Apache v2.0
 *
 */

/*===================================================================================*/

// All models should reside under the Controllers namespace
namespace Controllers;

/**
 * This is a skeleton controller demonstrating
 * a full CRUD application
 * 
 *
 */
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
			redirect('/posts');
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
		
		if($id) {
			redirect('/posts/' . $id, 'Successfully created post', 'success');
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
			redirect('/posts/' . $post->id, 'Successfully updated post', 'success');
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
			redirect('/posts/', 'Successfully delete post', 'success');
		}
	
	}
}	