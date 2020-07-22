<?php 

use \Dev\PageAdmin;
use \Dev\Model\Ingredient;
use \Dev\DB\Sql;
use \Dev\Model;
use \Dev\Model\User;

$app->get("/admin/ingredients", function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$ingredients = Ingredient::listAll();

	$ingredients = encodeData($ingredients);

	$page->setTpl("ingredients", [
		'ingredients'=>$ingredients
	]);
});

$app->get("/admin/ingredients/create", function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("ingredients-create", [
		'createError'=>Ingredient::getError()
		]);
});

$app->post("/admin/ingredients/create", function(){

	User::verifyLogin();

	if(!isset($_POST['singularName']) || $_POST['singularName'] === '') {
		Ingredient::setError('Informe o singular do ingrediente!');
		header("Location: /admin/ingredients/create");
		exit;
	}

	if(!isset($_POST['pluralName']) || $_POST['pluralName'] === '') {
		Ingredient::setError('Informe o plural do ingrediente!');
		header("Location: /admin/ingredients/create");
		exit;
	}

	if(Ingredient::verifySingularName($_POST['singularName'])){
		Ingredient::setError('Ingrediente singular já cadastrado!');
		header("Location: /admin/ingredients/create");
		exit;
	}


	if(Ingredient::verifyPluralName($_POST['pluralName'])){
		Ingredient::setError('Ingrediente no plural já cadastrado!');
		header("Location: /admin/ingredients/create");
		exit;
	}

	$ingredient = new Ingredient();

	$ingredient->setData($_POST);

	$ingredient->save();

	$_SESSION['registerValues'] = NULL;

	header("Location: /admin/ingredients");
	exit;
});

$app->get("/admin/ingredients/:idIngredient", function($idIngredient){

	User::verifyLogin();

	$page = new PageAdmin();
	$ingredient = new Ingredient();

	$ingredient->getIngredient((int)$idIngredient);

	$page->setTpl("ingredients-update", [
		'ingredient'=>$ingredient->getValues(),
		'createError'=>Ingredient::getError(),
		'createSuccess'=>Ingredient::getSuccess()
	]);
});

$app->post("/admin/ingredients/:idIngredient", function($idIngredient){

	try{
		User::verifyLogin();

		$page = new PageAdmin();
		$ingredient = new Ingredient();

		$ingredient->getIngredient((int)$idIngredient);

		if(!isset($_POST['singularName']) || $_POST['singularName'] === '') {
			Ingredient::setError('Informe o nome singular do ingrediente!');
			header("Location: /admin/ingredients/$idIngredient");
			exit;
		}

		if(!isset($_POST['pluralName']) || $_POST['pluralName'] === '') {
			Ingredient::setError('Informe o plural do ingrediente!');
			header("Location: /admin/ingredients/$idIngredient");
			exit;
		}

		if($_POST['singularName'] != $ingredient->getsingularName()){

			if(Ingredient::verifySingularName($_POST['name'])){
			
				Ingredient::setError('Ingrediente plural já cadastrado!');
				header("Location: /admin/ingredients/$idIngredient");
				exit;
			}
		}

		if($_POST['pluralName'] != $ingredient->getpluralName()){

			if(Ingredient::verifyPluralName($_POST['name'])){
			
				Ingredient::setError('Ingrediente já cadastrado!');
				header("Location: /admin/ingredients/$idIngredient");
				exit;
			}
		}

		$ingredient->setData($_POST);

		$ingredient->update();

		if($_FILES['file']['name'] !== '') $ingredient->setPhoto($_FILES["file"]);

		Ingredient::setSuccess("Alterações salvas com sucesso!");
		header("Location: /admin/ingredients/$idIngredient");
		exit;
	} catch (Exception $ex){
		Ingredient::setError($ex->getMessage());
		header("Location: /admin/ingredients/$idIngredient");
		exit;
	}
	
});

$app->get("/admin/ingredients/:idIngredient/delete", function($idIngredient){

	User::verifyLogin();

	$ingredient = new Ingredient();

	$ingredient->getIngredient((int)$idIngredient);

	$ingredient->des_active();

	header("Location: /admin/ingredients");
	exit;
});


?>