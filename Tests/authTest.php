<?php
require_once('../Libs/Auth/Session.php');
require_once('../Libs/Auth/Auth.php');
class authTest extends PHPUnit_Framework_TestCase{
	private $services;
	function setUp(){
		$this->services['db'] = new Redis();
		$this->services['db']->connect('localhost', 6379);
		$this->services['session'] = NULL; //new Session();
	}
	function testCheck(){
		$auth = new Auth($this->services);
		$user = array('username'=>'zamony', 'password'=>'test');
		$this->assertTrue($auth->check($user));
	}
	function
}