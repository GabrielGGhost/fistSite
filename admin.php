<?php 

use \Dev\PageAdmin;
use \Dev\Model\User;

$app->get('/admin', function() {
    
	$page = new PageAdmin();

	$page->setTpl("index");


});

$app->get('/admin/login', function(){

	$page = new PageAdmin([
		'header'=>false,
		'footer'=>false
	]);

	$page->setTpl("login");

});

$app->post('/admin/login', function(){

	User::login($_POST['login'], $_POST['password']);

});


?>