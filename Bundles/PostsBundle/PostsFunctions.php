<?php

// Functions for providing page controllers

function isPage(&$url){
	if (strrpos($url, 'page')+5 === strlen($url)){
		$url = explode('/', $url);
		$url = findPageController($url);
		return True;
	}
}
function findPageController($url){
	$pnum = (int) substr(end($url), -1, 1);
	$controller = sizeof($url < 4) ? '/' : $url[1];
	$options = NULL;
	switch(sizeof($url)){
		case 4:
			$controller = 'tags';
			$option = $url[2];
			break;
		case 3:
			$controller = 'category';
			$option = $url[1];
			break;
		case 2:
			$controller = 'index';
			$option = 'index';
			break;
		default:
			Route::notFound();
		break;
	}
	$_GET['page'] = $pnum;
	return "/posts/page/{$controller}View/{$option}";
}

//Functions for displaying posts

function post_excerpt($content, $length = 150){
	$content = strip_tags($content);
	$content = mb_substr($content, 0, $length);
	$pos = mb_strrpos($content, ' ');
	$content = mb_substr($content, 0, $pos);
	return "$content...";
}