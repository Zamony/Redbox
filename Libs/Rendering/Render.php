<?php

namespace Libs\Rendering;

use Libs\Route\Route;

class Render{
	public $data = NULL;
	public $page = NULL;
	public $theme = NULL;
	public $combine = NULL;
	private $redis = NULL;

	public function __construct($services){
		$this->redis = $services['db'];
		$this->theme = $this->redis->hGet('app:info', 'theme');
	}
	public function loadHelpers(){
		require_once("Themes/{$this->theme}/wizard.php");
		require_once("Themes/{$this->theme}/functions.php");
	}
	public function inject($title){
		$this->loadHelpers();
		$template_parts = init($this->page);
		$options = array();
		foreach ($template_parts as $part){
			if (function_exists($part)){
				$depends = call_user_func($part);
				$options['title'] = $title;
				foreach ($depends as $d_name => $d_from)
					$options[$d_name] = $this->redis->hGet($d_from, $d_name);
			}else if ($part == $this->page) {
				$options = $this->data;
				$options['home'] = $this->redis->hGet('app:info', 'home');
			}
			ob_start();
			require_once("Themes/{$this->theme}/$part.php");
			$this->combine [] = ob_get_clean();
		}
	}
	public function join(){
		if (is_array($this->combine))
			return implode('', $this->combine);
		else return NULL;
	}
}