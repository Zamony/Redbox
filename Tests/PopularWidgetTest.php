<?php
require_once('../Bundles/PopularWidgetBundle/PopularWidget.php');
class PopularWidgetTest extends PHPUnit_Framework_TestCase{
	protected $services = array();
	function setUp(){
		$this->services['db'] = new Redis();
		$this->services['db']->connect('localhost', 6379);
	}
	function testVisit(){
		$pw = new PopularWidget($this->services);
		$_SERVER['HTTP_REFERER'] = 'http://www.google.com.pk/url?sa=t&rct=';
		$this->assertInternalType('float', $pw->visit(2));
		$pw->visit(1);
		$pw->visit(2);
		$pw->visit(5);
		$pw->visit(1);
		$pw->visit(2);
		$_SERVER['HTTP_REFERER'] = 'http://www.yandex.ru/url?sa=t&rct=';
		$pw->visit(5);
		$pw->visit(2);
		$pw->visit(3);
		$_SERVER['HTTP_REFERER'] = 'http://www.sdd.com.ua/';
		$pw->visit(3);
		$pw->visit(4);
		$pw->visit(4);
		$pw->visit(4);
		$this->assertEquals(4, sizeof($pw->getMostVisited(-1)));
		$this->assertEquals(4.0, $this->services['db']->zScore('posts:visitors', 1));
	}
	function tearDown(){
		$this->services['db']->close();
	}
}