<?php
function loader(){
	$vendor = array('Libs' => scandir('Libs'), 'Bundles' => scandir('Bundles'),
	 'Themes' => scandir('Themes'));
	foreach ($vendor as $vendor_name => $bundles){
		foreach ($bundles as $bundle){
			if ($bundle !== '.' and $bundle !== '..' and is_dir("$vendor_name/$bundle")){
				foreach (scandir("$vendor_name/$bundle") as $class){
					if ($class === ucfirst($class) and $class !== '.' and $class !== '..'){
						require_once("$vendor_name/$bundle/$class");
					}
				}
			}
		}
	}
}
spl_autoload_register('loader');