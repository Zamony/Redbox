<?php

use Libs\Rendering\Render;
use Libs\Route\Route;

class TagsController{
	public $view = NULL;
	public $posts = NULL;
	private $hooks = NULL;
	const ON_PAGE = 8;
	public function __construct($services){
		$this->view = $services['render'];
		$this->hooks = $services['hooks'];
		$this->posts = new PostsBundle($services);
	}
	public function view($option){
		if ($option){
			$this->view->page = 'category';
			$this->view->data['posts'] = $this->posts->getPosts(
				$this->posts->getAllFromTag($option, array(0, self::ON_PAGE)),
				array('title', 'content', 'category', 'category_url', 'url', 'preview', 'time')
			);
			$this->view->data['total'] = $this->posts->getTotalByTag($option);
			$this->hooks->call('tags_render', array(&$this->view->data));
			$_GET['page'] = 1;
			$this->view->inject("Тег $option");
		} else Route::notFound();
	}
}