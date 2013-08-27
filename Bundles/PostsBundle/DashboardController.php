<?php

use Libs\Rendering\Render;

class DashboardController{
	private $services;
	private $posts;
	const ON_PAGE = 10;
	public function __construct($services){
		$this->services = $services;
		$this->posts = new PostsBundle($services);
		$this->services['render']->theme = $this->services['db']->hGet('app:info', 'admin_theme');
		$this->services['render']->data['dashboard-menu'] = $this->services['db']->hGet('app:menus', 'dashboard-menu');
	}

	//Controllers that generates pages
	public function postsView(){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$this->services['render']->page = 'bundles/PostsBundle/postsView';
		$this->services['render']->data['posts'] = $this->posts->getPosts(
			$this->posts->getAll(array($page-1, self::ON_PAGE)),
			array('title', 'category', 'category_url', 'url', 'content', 'id')
		);
		$this->services['render']->data['total'] = $this->posts->getTotalPublish();
		$this->services['render']->inject("Панель управления");
	}
	public function editPost($id = 0){
		$id = (int) $id;
		if (!$id){
			$this->addPost();
			return;
		}
		$this->services['render']->page = 'bundles/PostsBundle/editPost';
		$this->posts->id = $id;
		$this->services['render']->data += $this->posts->getPosts(
			array($id),
			array('content', 'title', 'tags', 'category', 'category_url')
			)[0];
		$cats = $this->posts->getAllCategories();
		$category = $this->services['render']->data['category'];
		unset($cats[array_search($category, $cats)]);
		array_unshift($cats, $category);
		$this->services['render']->data['cats'] = $cats;
		unset($cats, $category);

		$this->services['render']->inject("Edit post");
	}
	public function addPost(){
		$this->services['render']->page = 'bundles/PostsBundle/addPost';
		$this->services['render']->data['cats'] = $this->posts->getAllCategories();
		$this->services['render']->inject("Add new post");
	}
	public function catsTagsView($tag){
		$this->services['render']->page = 'bundles/PostsBundle/catsTagsView';
		$cats = $this->posts->getAllCategories();
		foreach ($cats as $cat)
			$this->services['render']->data['cats'][$cat] = $this->posts->getIdsByCategory($cat);
		$tags = $this->posts->getAllTags();
		foreach ($tags as $tag)
			$this->services['render']->data['tags'][$tag] = $this->posts->getIdsByTag($tag);
		$this->services['render']->inject("Панель управления");
	}

	//Helpers(Executing with Ajax)
	public function savePublish(){
		$valid = $this->validate();
		if ($valid) {echo $valid; return;}
		$_POST['publish'] = 1;
		$this->posts->addOne($_POST);
		$this->posts->publish();
		echo '<div class="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      	<strong>Done!</strong> Post successfully saved and published</div>';
	}
	public function saveDrafts(){
		$valid = $this->validate();
		if ($valid) {echo $valid; return;}
		$_POST['publish'] = 0;
		$this->posts->addOne($_POST);
		$this->posts->unpublish();
		echo '<div class="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      	<strong>Done!</strong> Post successfully unpublished and saved to drafts</div>';
	}
	public function publish($id){
		$this->posts->id = (int) $id;
		$this->posts->publish();
		echo '<div class="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      	<strong>Done!</strong> Post successfully published</div>';
	}
	public function unpublish($id){
		$this->posts->id = (int) $id;
		$this->posts->unpublish();
		echo '<div class="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      	<strong>Done!</strong> Post successfully unpublished</div>';
	}
	public function updatePublish(){
		$valid = $this->validate();
		if ($valid) {echo $valid; return;}
		$_POST['publish'] = 1;
		$this->posts->updateOne($_POST);
		$this->posts->publish();
		echo '<div class="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      	<strong>Done!</strong> Post successfully saved and published</div>';
	}
	public function updateUnpublish(){
		$valid = $this->validate();
		if ($valid) {echo $valid; return;}
		$_POST['publish'] = 0;
		$this->posts->updateOne($_POST);
		$this->posts->unpublish();
		echo '<div class="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      	<strong>Done!</strong> Post successfully saved to drafts</div>';
	}
	public function delete($id){
		$this->posts->id = (int) $id;
		$this->posts->deleteOne();
		echo '<div class="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      	<strong>Deleted!</strong> Post successfully deleted</div>';
	}

	// Functions for internal usage
	private function validate(){
		if (empty($_POST['title']))
			return '<div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      	<strong>Error!</strong> Title field is required</div>';
      	else return False;
	}
}