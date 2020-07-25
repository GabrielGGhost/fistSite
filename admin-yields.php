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
		'createError'=>'',
		'createSuccess'=>'',
		'yields'=>$yields
	]);

});

$app->get("/admin/yields/create", function(){

	$page = new PageAdmin();

	$page->setTpl("measure-create", [
		'createError'=>Yields::getError(),
		'measureRegisterValues'=>(isset($_SESSION['measureRegisterValues'])) ? $_SESSION['measureRegisterValues'] : ['name'=>'']
	]);

});

$app->post("/admin/yields/create", function(){

	User::verifyLogin();

	$measure = new Measure();

	$_SESSION['measureRegisterValues'] = $_POST;

	if (!isset($_POST['name']) || $_POST['name'] === '') {
		Yields::setError("Informe a medida!");
		header("Location: /admin/yields/create");
		exit;
	}

	if(Yields::verifyMeasure($_POST['name'])){
		Yields::setError("Medida já medida!");
		header("Location: /admin/yields/create");
		exit;
	}

	$measure->setData($_POST);

	$measure->save();

	$_SESSION['measureRegisterValues'] = NULL;

	Yields::setSuccess("Medida " . $_POST['name'] . "  foi incuído com sucesso");
	header("Location: /admin/yields");
	exit;
});

$app->get("/admin/yields/:IDDIFFICULT", function($idType){

	User::verifyLogin();

	$page = new PageAdmin();
	$measure = new Measure();

	$measure->getMeasure((int)$idType);

	$page->setTpl("measure-update", [
		'createError'=>Yields::getError(),
		'createSuccess'=>Yields::getSuccess(),
		'measure'=>$measure->getValues()
	]);

});

$app->post("/admin/yields/:IDDIFFICULT", function($idType){

	User::verifyLogin();

	$measure = new Measure();

	$page = new PageAdmin();

	$measure->getMeasure((int)$idType);

	if (!isset($_POST['name']) || $_POST['name'] === '') {
		Yields::setError("Informe o nome da medida!");
		header("Location: /admin/yields/$idType");
		exit;
	}

	if($_POST['name'] != $measure->getname()) {
		if(Yields::verifyMeasure($_POST['name'])){
			Yields::setError("Dificuldade já cadastrada!");
			header("Location: /admin/yields/$idType");
			exit;
		}
	}

	$measure->setData($_POST);

	$measure->update();

	Yields::setSuccess("Alterações feitas com sucesso!");
	header("Location: /admin/yields/$idType");
	exit;
});

$app->get("/admin/yields/:IDTYPE/des-active", function($idType){

	User::verifyLogin();

	$measure = new Measure();

	$measure->getMeasure((int)$idType);

	$measure->des_active();

	header("Location: /admin/yields");
	exit;
});
?>