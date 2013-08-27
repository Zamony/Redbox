<?php
function init($body){
	return array('head', $body, 'footer');
}

function head(){
	return array('name'=>'app:info', 'home'=>'app:info', 'top-menu'=>'app:menu');
}

function footer(){
	return array('copyright'=>'app:info', 'footer-menu'=>'app:menu');
}