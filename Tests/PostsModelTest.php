<?php
require_once('../Bundles/PostsBundle/PostsModel.php');
class PostsBundleTest extends PHPUnit_Framework_TestCase{
	protected $services = array();
	protected $posts;
	function setUp(){
		$this->services['db'] = new Redis();
		$this->services['db']->connect('localhost', 6379);
		$this->services['db']->select(1);
		$this->posts = new PostsBundle($this->services);
		$this->posts->id = 1;
	}
}