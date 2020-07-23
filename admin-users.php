<?php 

use \Dev\Model\User;
use \Dev\PageAdmin;


$app->get('/admin/users', function(){

	User::verifyLogin();

	$users = User::listAll();

	$users = encodeData($users);

	$page = new PageAdmin();

	$page->setTpl("users", [
		'users'=>$users,
		'createSuccess'=>User::getSuccess()
	]);

});

$app->get('/admin/users/create', function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-create", [
		'createError'=>User::getError(),
		'UserRegisterError'=>(isset($_SESSION['UserRegisterError'])) ? $_SESSION['UserRegisterError'] : ['name'=>'', 'surname'=>'', 'login'=>'', 'password'=>'', 'phone'=>'', 'email'=>'', 'inadmin'=>false
		]
	]);
});

$app->post('/admin/users/create', function(){

	User::verifyLogin();

	$user = new User();

	$_SESSION['UserRegisterError'] = $_POST;

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

	$_SESSION['UserRegisterError'] = NULL;

	User::setSuccess("Usuário cadastrado com sucesso!");
	header("Location: /admin/users");
	exit;
});



$app->get('/admin/users/:idUser', function($idUser){

	User::verifyLogin();

	$user = new User();

	$page = new PageAdmin();

	$user->getUser((int)$idUser);

	$page->setTpl("users-update", [
		'createError'=>User::getError(),
		'user'=>$user->getValues(),
		'createSuccess'=>User::getSuccess()
	]);
});

$app->post('/admin/users/:idUser', function($idUser){

	try{

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

		if($_POST['login'] !== $user->getlogin()){
			if(User::checkExistentLogin($_POST['login'])){
				User::setError('Login já cadastrado no sistema!');
				header("Location: /admin/users/$idUser");
				exit;
			}
		}

		$user->setData($_POST);

		$user->update();

		if($_FILES['file']['name'] !== '') $user->setPhoto($_FILES["file"]);

		User::setSuccess("Alterações salvas com sucesso!");
		header("Location: /admin/users/$idUser");
		exit;
	} catch (Exception $ex) {
		User::setError($ex->getMessage());
		header("Location: /admin/users/$idUser");
		exit;
	}

});

$app->get('/admin/users/:idUser/des-active', function($idUser){

	User::verifyLogin();

	$user = new User();

	$user->get((int)$idUser);

	$user->des_active();

	header("Location: /admin/users");
	exit;
});

?>