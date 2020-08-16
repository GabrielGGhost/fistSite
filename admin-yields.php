<?php 

use \Dev\DB\Sql;
use \Dev\Model;
use \Dev\PageAdmin;
use \Dev\Model\Yields;
use \Dev\Model\User;

$app->get("/admin/yields", function(){

	User::verifyLogin();

	$page = new PageAdmin();
	$yields = Yields::listAll();

	$yields = encodeData($yields);

	$page->setTpl("yield", [
		'createSuccess'=>Yields::getSuccess(),
		'yields'=>$yields
	]);
});

$app->get("/admin/yields/create", function(){

	$page = new PageAdmin();

	$page->setTpl("yield-create", [
		'createError'=>Yields::getError(),
		'yieldRegisterValues'=>(isset($_SESSION['yieldRegisterValues'])) ? $_SESSION['yieldRegisterValues'] : ['singularName'=>'', 'pluralName'=>'']
	]);

});

$app->post("/admin/yields/create", function(){

	User::verifyLogin();

	$yield = new Yields();

	$_SESSION['yieldRegisterValues'] = $_POST;

	if (!isset($_POST['singularName']) || $_POST['singularName'] === '') {
		Yields::setError("Informe o singular do rendimento!");
		header("Location: /admin/yields/create");
		exit;
	}

	if(Yields::verifySingularYield($_POST['singularName'])){
		Yields::setError("Singular de Rendimento já cadastrado!");
		header("Location: /admin/yields/create");
		exit;
	}

	if (!isset($_POST['pluralName']) || $_POST['pluralName'] === '') {
		Yields::setError("Informe o plural do rendimento!");
		header("Location: /admin/yields/create");
		exit;
	}

	$yield->setData($_POST);

	$yield->save();

	$_SESSION['yieldRegisterValues'] = NULL;

	Yields::setSuccess("Medida " . $_POST['singularName'] . "  foi incuído com sucesso");
	header("Location: /admin/yields");
	exit;
});

$app->get("/admin/yields/:IDDIFFICULT", function($idType){

	User::verifyLogin();

	$page = new PageAdmin();
	$yield = new Yields();

	$yield->getYield((int)$idType);

	$page->setTpl("yield-update", [
		'createError'=>Yields::getError(),
		'createSuccess'=>Yields::getSuccess(),
		'yield'=>$yield->getValues()
	]);

});

$app->post("/admin/yields/:IDDIFFICULT", function($idType){

	User::verifyLogin();

	$yield = new Yields();

	$page = new PageAdmin();

	$yield->getYield((int)$idType);

	if (!isset($_POST['singularName']) || $_POST['singularName'] === '') {
		Yields::setError("Informe o singular do rendimento!");
		header("Location: /admin/yields/create");
		exit;
	}

	if($_POST['singularName'] != $yield->getsingularName()){
		if(Yields::verifySingularYield($_POST['singularName'])){
			Yields::setError("Singular de Rendimento já cadastrado!");
			header("Location: /admin/yields/create");
			exit;
		}
	}

	if (!isset($_POST['pluralName']) || $_POST['pluralName'] === '') {
		Yields::setError("Informe o plural do rendimento!");
		header("Location: /admin/yields/create");
		exit;
	}

	$yield->setData($_POST);

	$yield->update();

	Yields::setSuccess("Alterações feitas com sucesso!");
	header("Location: /admin/yields/$idType");
	exit;
});

$app->get("/admin/yields/:IDTYPE/des-active", function($idType){

	User::verifyLogin();

	$yields = new Yields();

	$yields->getYield((int)$idType);

	$yields->des_active();

	header("Location: /admin/yields");
	exit;
});
?>