<?php 

use \Dev\DB\Sql;
use \Dev\Model;
use \Dev\PageAdmin;
use \Dev\Model\Difficult;
use \Dev\Model\User;

$app->get("/admin/difficults", function(){

	User::verifyLogin();

	$page = new PageAdmin();
	$difficults = Difficult::listAll();

	$difficults = encodeData($difficults);

	$page->setTpl("difficult", [
		'createError'=>'',
		'createSuccess'=>'',
		'difficults'=>$difficults
	]);

});

$app->get("/admin/difficults/create", function(){

	$page = new PageAdmin();

	$page->setTpl("difficult-create", [
		'createError'=>Difficult::getError(),
		'difficultRegisterValues'=>(isset($_SESSION['difficultRegisterValues'])) ? $_SESSION['difficultRegisterValues'] : ['difficultLevel'=>'']
	]);

});

$app->post("/admin/difficults/create", function(){

	User::verifyLogin();

	$difficult = new Difficult();

	$_SESSION['difficultRegisterValues'] = $_POST;

	if (!isset($_POST['difficultLevel']) || $_POST['difficultLevel'] === '') {
		Difficult::setError("Informe a dificuldade!");
		header("Location: /admin/difficults/create");
		exit;
	}

	if(Difficult::verifyDifficult($_POST['difficultLevel'])){
		Difficult::setError("Dificuldade já cadastrada!");
		header("Location: /admin/difficults/create");
		exit;
	}

	$difficult->setData($_POST);

	$difficult->save();

	$_SESSION['difficultRegisterValues'] = NULL;

	header("Location: /admin/difficults");
	exit;
});

$app->get("/admin/difficults/:IDDIFFICULT", function($idDifficult){

	User::verifyLogin();

	$page = new PageAdmin();
	$difficult = new Difficult();

	$difficult->getDifficult((int)$idDifficult);

	$page->setTpl("difficult-update", [
		'createError'=>Difficult::getError(),
		'createSuccess'=>Difficult::getSuccess(),
		'difficult'=>$difficult->getValues()
	]);

});

$app->post("/admin/difficults/:IDDIFFICULT", function($idDifficult){

	User::verifyLogin();

	$difficult = new Difficult();

	$page = new PageAdmin();

	$difficult->getDifficult((int)$idDifficult);

	if (!isset($_POST['difficultLevel']) || $_POST['difficultLevel'] === '') {
		Difficult::setError("Informe o nome da dificuldade!");
		header("Location: /admin/difficults/$idDifficult");
		exit;
	}

	if($_POST['difficultLevel'] != $difficult->getdifficultLevel()) {
		if(Difficult::verifyDifficult($_POST['difficultLevel'])){
			Difficult::setError("Dificuldade já cadastrada!");
			header("Location: /admin/difficults/$idDifficult");
			exit;
		}
	}

	$difficult->setData($_POST);

	$difficult->update();

	Difficult::setSuccess("Alterações feitas com sucesso!");
	header("Location: /admin/difficults/$idDifficult");
	exit;
});

$app->get("/admin/difficults/:IDDIFFICULT/des-active", function($idDifficult){

	User::verifyLogin();

	$difficult = new Difficult();

	$difficult->getDifficult((int)$idDifficult);

	$difficult->des_active();

	header("Location: /admin/difficults");
	exit;
});
?>