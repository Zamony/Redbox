<?php

use Libs\Rendering\Render;
use Libs\Route\Route;

class CategoryController{
	public $view = NULL;
	public $posts = NULL;
	private $hooks = NULL;
	const ON_PAGE = 8;
	public function __construct($services){
		$this->view = $services['render'];
		$this->posts = $services['PostsBundle'];
		$this->hooks = $services['hooks'];
	}
	public function view($option){
		if (!$option){
			$this->view->page = 'category';
			$this->view->data['posts'] = $this->posts->getPosts(
				$this->posts->getAll(array(0, self::ON_PAGE)),
				array('title', 'content', 'category', 'category_url', 'url', 'preview', 'time')
			);
			$this->view->data['total'] = $this->posts->getTotalPublish();
			$this->hooks->call('index_render', array(&$this->view->data));
			$_GET['page'] = 1;
			$this->view->inject('Главная');
		} else if ($this->posts->checkCategory($option)){
			$this->view->page = 'category';
			$this->view->data['posts'] = $this->posts->getPosts(
				$this->posts->getAllFromCategory($option, array(0, self::ON_PAGE)),
				array('title', 'content', 'category', 'category_url', 'url', 'preview', 'time')
			);
			$this->view->data['total'] = $this->posts->getTotalByCategory($option);
			$this->hooks->call('category_render', array(&$this->view->data));
			$_GET['page'] = 1;
			$this->view->inject($this->view->data['posts'][0]['category']);
		} else Route::notFound();
	}
}