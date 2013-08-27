<?php

use Libs\Rendering\Render;

class DashboardBMController{
	private $services;
	public function __construct($services){
		$this->services = $services;
		$this->services['render']->theme = $this->services['db']->hGet('app:info', 'admin_theme');
		$this->services['render']->data['dashboard-menu'] = $this->services['db']->hGet('app:menus', 'dashboard-menu');
	}

	//Controllers that generates pages
	public function bundleList(){
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$this->services['render']->page = 'bundles/BMBundle/bundleList';
		$activated = $this->services['db']->sMembers('app:bundles:activated');
		$this->services['render']->data['activated'] = array();
		foreach ($activated as $active){
			$info_path = "./Bundles/$active/info.ini";
			if (file_exists($info_path))
				$this->services['render']->data['activated'][$active] = parse_ini_file($info_path);
		}
		$deactivated = $this->services['db']->sMembers('app:bundles:deactivated');
		$this->services['render']->data['deactivated'] = array();
		foreach ($deactivated as $deactive){
			$info_path = "./Bundles/$deactive/info.ini";
			if (file_exists($info_path))
				$this->services['render']->data['deactivated'][$deactive] = parse_ini_file($info_path);
		}
		$this->services['render']->inject("Bundle list");
	}
	public function installBundle(){
		$this->services['render']->page = 'bundles/BMBundle/installBundle';
		if (isset($_FILES['bundle']) and $_FILES['bundle']['size'] > 0){
			$path = './Bundles/'.basename($_FILES['bundle']['name']);
			if(copy($_FILES['bundle']['tmp_name'], $path)){
				$bundle_archive = new ZipArchive();
				if ($bundle_archive->open($path) === True){
					$dir_name = substr($_FILES['bundle']['name'], 0, -4);
					if (in_array($dir_name, scandir('./Bundles'))) $msg = "Bundle already installed";
					$bundle_archive->extractTo('./Bundles');
					$bundle_archive->close();
					if (in_array($dir_name, scandir("./Bundles/$dir_name"))){
						if (!mkdir("Themes/{$this->services['render']->theme}/bundles/$dir_name")) $msg = "Error when linking bundle to admin panel";
						$files = scandir("./Bundles/$dir_name/$dir_name");
						foreach ($files as $file){
							if ($file !== '.' and $file !== '..')
								rename("./Bundles/$dir_name/$dir_name/$file", "Themes/RedcontrolAdmin/bundles/$dir_name/$file");
						}
					}else $msg = "Error opening archive!";
					unlink($path);
				}else $msg = "Error trying open archive: $path";
			}else $msg = "Error copying file!";
		}
		if (isset($msg)) $this->services['render']->data['msg'] = $msg;
		$this->services['render']->inject("Install bundle");
	}
	public function uninstall($bundle_name){
		$this->rrmDir("./Bundles/$bundle_name");
		$this->rrmDir("./Themes/{$this->admin_theme}/bundles/$bundle_name");
		$this->deactivate($bundle_name);
	}
	public function activate($bundle_name){
		$bundle_name = $this->searchBundle($bundle_name);
		$this->services['db']->sRem('app:bundles:deactivated', $bundle_name);
		$this->services['db']->sAdd('app:bundles:activated', $bundle_name);
		require("Bundles/$bundle_name/configure.php");
		activate($this->services);
		echo "Activated";
	}
	public function deactivate($bundle_name){
		$bundle_name = $this->searchBundle($bundle_name);
		$this->services['db']->sRem('app:bundles:activated', $bundle_name);
		$this->services['db']->sAdd('app:bundles:deactivated', $bundle_name);
		require("Bundles/$bundle_name/configure.php");
		deactivate($this->services);
		echo "Deactivated";
	}
	private function rrmDir($dir_path){
		$files = scandir($dir_path);
		foreach ($files as $file){
			if ($file !== '.' and $file !== '..'){
				if (!is_dir($file))
					unlink($dir_path.'/'.$file);
				else $this->rrmDir($dir_path.'/'.$file);
			}
		}
		rmdir($dir_path);
	}
	private function searchBundle($bundle_name){
		$bundles = scandir('./Bundles/');
		foreach ($bundles as $bundle)
			if ($bundle_name === strtolower($bundle)) return $bundle;
	}
}