<?php 

use \Dev\Model\User;
use \Dev\PageAdmin;

$app->get('/admin/users', function(){

	User::verifyLogin();

	$users = User::listAll();

	$users = encodeData($users);

	$page = new PageAdmin();

	$page->setTpl("users", [
		'users'=>$users
	]);

});

$app->get('/admin/users/create', function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-create", [
		'createError'=>User::getError(),
		'registerError'=>(isset($_SESSION['registerValues'])) ? $_SESSION['registerValues'] : ['name'=>'', 'surname'=>'', 'login'=>'', 'password'=>'', 'phone'=>'', 'email'=>'', 'inadmin'=>false]
	]);
});

$app->post('/admin/users/create', function(){

	User::verifyLogin();

	$user = new User();

	$_SESSION['registerValues'] = $_POST;

	$_POST["inadmin"] = (isset($_POST["inadmin"]))? 1 : 0;

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

	if (!isset($_POST['password']) || $_POST['password'] === '') {
		User::setError('Informe uma senha ao usuário!');
		header("Location: /admin/users/create");
		exit;
	}

	if (!isset($_POST['email']) || $_POST['email'] === '') {
		User::setError('Informe um email ao usuário!');
		header("Location: /admin/users/create");
		exit;
	}

	if (User::verifyEmail($_POST['email'])) {
		User::setError('Email já cadastrado no sistema!');
		header("Location: /admin/users/create");
		exit;
	}

	if (strlen($_POST['password']) < 5) {
		User::setError('A senha deve ter ao menos 5 caracteres!');
		header("Location: /admin/users/create");
		exit;
	}

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

	$_POST['password'] = User::getPasswordHash($_POST['password']);

	$user->setData($_POST);

	$user->save();

	$_SESSION['registerValues'] = NULL;

	header("Location: /admin/users");
	exit;
});



$app->get('/admin/users/:idUser', function($idUser){

	User::verifyLogin();

	$page = new PageAdmin();
	$user = new User();

	$user->getUser((int)$idUser);

	$page->setTpl("users-update", [
		'user'=>$user->getValues(),
		'createError'=>User::getError()
	]);
});

$app->post('/admin/users/:idUser', function($idUser){

	User::verifyLogin();

	$user = new User();

	$user->getUser((int)$idUser);

	$_POST["inadmin"] = (isset($_POST["inadmin"]))? 1 : 0;

	if (!isset($_POST['name']) || $_POST['name'] === '') {
		User::setError('Informe um nome ao usuário!');
		header("Location: /admin/users/$idUser");
		exit;
	}

	if (!isset($_POST['surname']) || $_POST['surname'] === '') {
		User::setError('Informe um sobrenome ao usuário!');
		header("Location: /admin/users/$idUser");
		exit;
	}

	if (!isset($_POST['login']) || $_POST['login'] === '') {
		User::setError('Informe um login ao usuário!');
		header("Location: /admin/users/$idUser");
		exit;
	}

	if (!isset($_POST['email']) || $_POST['email'] === '') {
		User::setError('Informe um email ao usuário!');
		header("Location: /admin/users/$idUser");
		exit;
	}

	if($_POST['email'] !== $user->getemail()){

		if (User::verifyEmail($_POST['email'])) {
			User::setError('Email já cadastrado no sistema!');
			header("Location: /admin/users/$idUser");
			exit;
		}
	}

	$user->setData($_POST);

	$user->update();

	header("Location: /admin/users");
	exit;
});


?>