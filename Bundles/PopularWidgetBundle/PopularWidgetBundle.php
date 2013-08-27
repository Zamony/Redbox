<?php

use Libs\Bundle\Bundle;

class PopularWidgetBundle extends Bundle{
	public $db = NULL;
	private $se = array('google', 'yandex');
	public function __construct($services){
		$this->db = $services['db'];
	}
	public function visit($post_id){
		$referer = $_SERVER['HTTP_REFERER'];
		foreach ($this->se as $se){
			if (strpos($referer, $se) !== False)
				return $this->incr($post_id);
		}
	}
	public function incr($post_id){
		$id = (int) $post_id; 
		if ($id === 0)
			$id = $this->db->hGet("posts:url", $post_id);
		return $this->db->zIncrBy("posts:visitors", 1, $id);
	}
	public function getMostVisited(&$data, $limit = 3){
		$posts_ids = $this->db->zRangeByScore('posts:visitors', '-inf', '+inf',
											 array('limit' => array(0, $limit)));
		$posts = array();
		foreach ($posts_ids as $id)
			$posts [] = $this->db->hMGet("post:$id", array('title', 'content', 'preview', 'category_url', 'url'));
		$data['popular'] = $posts;
	}
}