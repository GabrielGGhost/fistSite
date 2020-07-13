<?php 

use \Dev\Model\User;
use \Dev\PageAdmin;

$app->get('/admin/users', function(){

	// User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users");

});

$app->get('/admin/users/create', function(){

	// User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-create", [
		'createError'=>User::getError(),
		'registerError'=>(isset($_SESSION['registerValues'])) ? $_SESSION['registerValues'] : ['name'=>'', 'email'=>'', 'phone'=>'']
	]);

});

$app->post('/admin/users/create', function(){

	// User::verifyLogin();

	$user = new User();

	$_SESSION['registerValues'] = $_POST;

	if (!isset($_POST['name']) || $_POST['name'] === '') {
		User::setError('Informe um nome ao usuário!');
		header("Location: /admin/users/create");
		exit;
	}

	if (!isset($_POST['surname']) || $_POST['surname'] === '') {
		User::setError('Informe um sobrenome ao usuário!');
		header("Location: /admin/users/create");
		exit;
	}

	if (!isset($_POST['login']) || $_POST['login'] === '') {
		User::setError('Informe um login ao usuário!');
		header("Location: /admin/users/create");
		exit;
	}

	if (!isset($_POST['phone']) || $_POST['phone'] === '') {
		User::setError('Informe um telefone ao usuário!');
		header("Location: /admin/users/create");
		exit;
	}

	if (!isset($_POST['email']) || $_POST['email'] === '') {
		User::setError('Informe um email ao usuário!');
		header("Location: /admin/users/create");
		exit;
	}

	if (!isset($_POST['password']) || $_POST['password'] === '') {
		User::setError('Informe uma senha ao usuário!');
		header("Location: /admin/users/create");
		exit;
	}

});

?>