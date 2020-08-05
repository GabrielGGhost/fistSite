<?php 

use \Dev\DB\Sql;
use \Dev\Model;
use \Dev\PageAdmin;
use \Dev\Model\Measure;
use \Dev\Model\User;

$app->get("/admin/measures", function(){

	User::verifyLogin();

	$page = new PageAdmin();
	$measures = Measure::listAll();

	$measures = encodeData($measures);

	$page->setTpl("measure", [
		'createError'=>'',
		'createSuccess'=>'',
		'measures'=>$measures
	]);

});

$app->get("/admin/measures/create", function(){

	$page = new PageAdmin();

	$page->setTpl("measure-create", [
		'createError'=>Measure::getError(),
		'measureRegisterValues'=>(isset($_SESSION['measureRegisterValues'])) ? $_SESSION['measureRegisterValues'] : ['singularName'=>'', 'pluralName'=>'']
	]);

});

$app->post("/admin/measures/create", function(){

	User::verifyLogin();

	$measure = new Measure();

	$_SESSION['measureRegisterValues'] = $_POST;

	if (!isset($_POST['singularName']) || $_POST['singularName'] === '') {
		Measure::setError("Informe a medida!");
		header("Location: /admin/measures/create");
		exit;
	}

	if(Measure::verifyMeasure($_POST['singularName'])){
		Measure::setError("Medida já medida!");
		header("Location: /admin/measures/create");
		exit;
	}

	$measure->setData($_POST);

	$measure->save();

	$_SESSION['measureRegisterValues'] = NULL;

	Measure::setSuccess("Medida " . $_POST['singularName'] . "  foi incuído com sucesso");
	header("Location: /admin/measures");
	exit;
});

$app->get("/admin/measures/:IDMEASURE", function($idType){

	User::verifyLogin();

	$page = new PageAdmin();
	$measure = new Measure();

	$measure->getMeasure((int)$idType);

	$page->setTpl("measure-update", [
		'createError'=>Measure::getError(),
		'createSuccess'=>Measure::getSuccess(),
		'measure'=>$measure->getValues()
	]);

});

$app->post("/admin/measures/:IDMEASURE", function($idType){

	User::verifyLogin();

	$measure = new Measure();

	$page = new PageAdmin();

	$measure->getMeasure((int)$idType);

	if (!isset($_POST['singularName']) || $_POST['singularName'] === '') {
		Measure::setError("Informe o nome da medida!");
		header("Location: /admin/measures/$idType");
		exit;
	}

	if($_POST['singularName'] != $measure->getsingularName()) {
		if(Measure::verifyMeasure($_POST['singularName'])){
			Measure::setError("Dificuldade já cadastrada!");
			header("Location: /admin/measures/$idType");
			exit;
		}
	}

	$measure->setData($_POST);

	$measure->update();

	Measure::setSuccess("Alterações feitas com sucesso!");
	header("Location: /admin/measures/$idType");
	exit;
});

$app->get("/admin/measures/:IDTYPE/des-active", function($idType){

	User::verifyLogin();

	$measure = new Measure();

	$measure->getMeasure((int)$idType);

	$measure->des_active();

	header("Location: /admin/measures");
	exit;
});
?>