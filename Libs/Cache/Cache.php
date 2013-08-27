<?php

namespace Libs\Cache;

use Libs\Pimple\Pimple;

class Cache{
	public $enable = False;
	public $cached = NULL;
	private $db = NULL;

	public function __construct(Pimple $services){
		$this->db = $services['db'];
	}
	public function addPage($url, $content, $expire){
		$url = md5($url);
		$this->db->set("app:cache:$url", $content);
		$this->db->expire("app:cache:$url", (int) $expire);
	}
	public function isCached($url){
		return $this->db->get("app:cache:".md5($url));
	}
}