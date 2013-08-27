<?php

use Libs\Rendering\Render;
use Libs\Route\Route;

class PageController{
	public $view = NULL;
	public $posts = NULL;
	private $hooks = NULL;
	const ON_PAGE = 8;
	public function __construct($services){
		$this->view = $services['render'];
		$this->hooks = $services['hooks'];
		$this->posts = new PostsBundle($services);
	}
	public function categoryView($category){
		$page_num = (int) $_GET['page'];
		$this->view->page = 'category';
		$start = self::ON_PAGE*($page_num-1);
		$this->view->data['posts'] = $this->posts->getPosts(
			$this->posts->getAllFromCategory($catebgory, array($start, self::ON_PAGE)),
			array('title', 'content', 'category', 'category_url', 'url', 'preview', 'time')
		);
		$this->view->data['total'] = $this->posts->getTotalByCategory($category);
		$this->hooks->call('page_render', array(&$this->view->data));
		$this->view->inject("{$this->view->data['posts'][0]['category']} - страница $page_num");
	}
	public function indexView(){
		$page_num = (int) $_GET['page'];
		$this->view->page = 'category';
		$start = self::ON_PAGE*($page_num-1);
		$this->view->data['posts'] = $this->posts->getPosts(
			$this->posts->getAll(array($start, self::ON_PAGE)),
			array('title', 'content', 'category', 'category_url', 'url', 'preview', 'time')
		);
		$this->view->data['total'] = $this->posts->getTotalPublish();
		$this->hooks->call('page_render', array(&$this->view->data));
		$this->view->inject("Главная - страница $page_num");
	}
	public function tagsView($tag){
		$page_num = (int) $_GET['page'];
		$this->view->page = 'category';
		$start = self::ON_PAGE*($page_num-1);
		$this->view->data['posts'] = $this->posts->getPosts(
			$this->posts->getAllFromTag($tag, array($start, self::ON_PAGE)),
			array('title', 'content', 'category', 'category_url', 'url', 'preview', 'time')
		);
		$this->view->data['total'] = $this->posts->getTotalByTag($tag);
		$this->hooks->call('page_render', array(&$this->view->data));
		$this->view->inject("Тег $tag - страница $page_num");
	}
}