<?php

namespace Libs\Bundle;

class Bundle{
	public $bundle = NULL;
	protected $db = NULL;
	public function install(){}
	public function uninstall(){}
	public function activate(){
		return $this->db->sAdd('app:bundles', $this->bundle);
	}
	public function deactivate(){
		return $this->db->sRem('app:bundles', $this->bundle);
	}
}