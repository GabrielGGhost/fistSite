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

	if(!isset($_POST['name']) || $_POST['name'] === '') {
		Ingredient::setError('Informe o nome do ingrediente!');
		header("Location: /admin/ingredients/create");
		exit;
	}

	if(Ingredient::verifyIngredient($_POST['name'])){
		Ingredient::setError('Ingrediente já cadastrado!');
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
		'createError'=>Ingredient::getError()
	]);
});

$app->post("/admin/ingredients/:idIngredient", function($idIngredient){

	User::verifyLogin();

	$page = new PageAdmin();
	$ingredient = new Ingredient();

	$ingredient->getIngredient((int)$idIngredient);

	if(!isset($_POST['name']) || $_POST['name'] === '') {
		Ingredient::setError('Informe o nome do ingrediente!');
		header("Location: /admin/ingredients/create");
		exit;
	}

	if($_POST['name'] != $ingredient->getname()){

		if(Ingredient::verifyIngredient($_POST['name'])){
		
			Ingredient::setError('Ingrediente já cadastrado!');
			header("Location: /admin/ingredients/$idIngredient");
			exit;
		}
	}

	$ingredient->setData($_POST);

	$ingredient->update();

	header("Location: /admin/ingredients");
	exit;
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