<?php 

use \Dev\Page;
use \Dev\PageAdmin;
use \Dev\Model\User;


$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl("index");


});

$app->get('/admin', function() {
    
	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("index");

});

$app->get('/admin/login', function(){

	$page = new PageAdmin([
		'header'=>false,
		'footer'=>false
	]);

	$page->setTpl("login", [
		'createError'=>User::getError()
	]);

});

$app->post('/admin/login', function(){

	try {
		User::login($_POST['login'], $_POST['password']);

		header("Location: /admin");
		exit;
	} catch(Exception $e) {

		User::setError($e->getMessage());

		header("Location: /admin/login");
		exit;
	}


});

$app->get('/admin/logout', function(){

	User::logout();

	header("Location: /admin/login");
	exit;
});

$app->get('/admin/forgot', function(){

	$page = new PageAdmin([
		'header'=>false,
		'footer'=>false
	]);

	$page->setTpl("forgot");
});

$app->post('/admin/forgot', function(){

	$user = User::getForgot($_POST['email']);

	header("Location: /admin/forgot/sent");
	exit;
});

$app->get('/admin/forgot/sent', function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-sent");
});

$app->get('/admin/forgot/reset', function(){

	$code = $_GET['code'];

	$user = User::validForgotDescrypt($code);

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-reset", array(
		"name"=>$user["name"],
		"code"=>$_GET["code"]
	));
});

$app->post("/admin/forgot/reset", function(){

	$forgot = User::validForgotDescrypt($_POST["code"]);	

 	User::setForgotUsed($forgot["idRecovery"]);

 	$user = new User();

 	$user->get((int)$forgot["idUser"]);

 	$password = User::getPasswordHash($_POST["password"]);

 	$user->updatePassword($password);

 	$page = new PageAdmin([
 		"header"=>false,
 		"footer"=>false
 	]);

 	$page->setTpl("forgot-reset-success");

 });



?>