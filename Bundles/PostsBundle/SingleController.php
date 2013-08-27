<?php

use Libs\Rendering\Render;
use Libs\Route\Route;
use Libs\Cache\Cache;

class SingleController{
	public $view = NULL;
	public $posts = NULL;
	private $cache = NULL;
	private $hooks = NULL;
	public function __construct($services){
		$this->view = $services['render'];
		$this->cache = $services['cache'];
		$this->hooks = $services['hooks'];
		$this->posts = new PostsBundle($services);
	}
	public function view($option){
		$id = $this->posts->checkTitle($option);
		if (!is_null($option) and $id){
			$this->hooks->call('post_view', array($id));
			$this->cache->enable = False;
			$this->view->page = 'single';
			$this->view->data = $this->posts->getPosts(
				array($id),
				array('title', 'content', 'time', 'tags')
			)[0];
			$this->view->data['tags'] = explode(', ', $this->view->data['tags']);
			$this->view->data['tags_url'] = array();
			foreach ($this->view->data['tags'] as $tag)
				$this->view->data['tags_url'][$tag] = $this->posts->rusToLat($tag);
			$this->hooks->call('single_render', array(&$this->view->data));
			$this->view->inject($this->view->data['title']);
		} else Route::notFound();
	}
}