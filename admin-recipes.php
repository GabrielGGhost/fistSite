<?php 

use \Dev\DB\Sql;
use \Dev\Model;
use \Dev\PageAdmin;
use \Dev\Model\Recipes;
use \Dev\Model\User;

$app->get("/admin/recipes", function(){

	User::verifyLogin();

	$page = new PageAdmin();
	$recipes = Recipes::listAll();

	$recipes = encodeData($recipes);

	$page->setTpl("recipes", [
		'createError'=>Recipes::getError(),
		'createSuccess'=>Recipes::getSuccess(),
		'recipes'=>$recipes
	]);

});

$app->get("/admin/recipes/create", function(){

	User::verifyLogin();

	$yieldTypes = Recipes::getComboBox('yt');
	$yieldTypes = encodeData($yieldTypes);

	$page = new PageAdmin();

	$page->setTpl("recipe-create", [
		'createError'=>Recipes::getError(),
		'recipeRegisterValues'=>(isset($_SESSION['recipeRegisterValues'])) ? $_SESSION['recipeRegisterValues'] : ['recipeName'=>'', 'yield'=>'', 'preparationTime'=>'', 'idAuthor'=>''],
		'yieldType'=>encodeData(Recipes::getComboBox('yt')),
		'difficult'=>encodeData(Recipes::getComboBox('diff')),
		'measure'=>encodeData(Recipes::getComboBox('meas')),
		'ingredient'=>encodeData(Recipes::getComboBox('ing')),
		'listedIngredients'=>$_SESSION[Recipes::INGREDIENTS_LISTED],
		'listedSteps'=>$_SESSION[Recipes::STEPS_LISTED]
	]);

});

$app->post("/admin/recipes/create", function(){

	User::verifyLogin();

	$recipe = new Recipes();

	$_SESSION['recipeRegisterValues'] = $_POST;

	$recipe->setlistedIngredients($_POST);

	$recipe->setlistedSteps($_POST);

	if (!isset($_POST['recipeName']) || $_POST['recipeName'] === '') {
		Recipes::setError("Informe o nome da receita!");
		header("Location: /admin/recipes/create");
		exit;
	}

	if (!isset($_POST['yield']) || (int)$_POST['yield'] === 0) {
		Recipes::setError("A receita precisa de um rendimento maior que 0!");
		header("Location: /admin/recipes/create");
		exit;
	}

	if (!isset($_POST['idYield']) || (int)$_POST['idYield'] === 0 || $_POST['idYield'] === NULL) {
		Recipes::setError("É preciso informar o tipo do rendimento!");
		header("Location: /admin/recipes/create");
		exit;
	}

	if (!isset($_POST['preparationTime']) || strtotime($_POST['preparationTime']) === strtotime("00:00")) {
		Recipes::setError("O tempo da receita precisa ser maior que 00:00");
		header("Location: /admin/recipes/create");
		exit;
	}


	if (!isset($_POST['idDifficult']) || (int)$_POST['idDifficult'] === 0 || $_POST['idDifficult'] === NULL) {
		Recipes::setError("É preciso selecionar uma dificuldade para a receita!");
		header("Location: /admin/recipes/create");
		exit;
	}

	if (!isset($_POST['idAuthor']) || $_POST['idAuthor'] === '') {
		Recipes::setError("Informe o autor!");
		header("Location: /admin/recipes/create");
		exit;
	}

	$recipe->checkIngredients($_SESSION[Recipes::INGREDIENTS_LISTED]);
	$recipe->checkSteps($_SESSION[Recipes::STEPS_LISTED]);

	$recipe->setData($_POST);

	if(!$recipe->checkAuthor()){

		Recipes::setError("Autor inexistente!");
		header("Location: /admin/recipes/create");
		exit;
	}

	$recipe->saveRecipe();
	$recipe->saveIngredients();
	$recipe->saveSteps();

	$_SESSION[Recipes::INGREDIENTS_LISTED] = "";
	$_SESSION[Recipes::STEPS_LISTED] = "";
	$_SESSION['recipeRegisterValues'] = NULL;

	Recipes::setSuccess('Receita ' . $recipe->getrecipeName() . ' foi adicionada com sucesso!');
	header("Location: /admin/recipes");
	exit;
});


$app->get("/admin/recipes/:IDRECIPE", function($idRecipe){

	User::verifyLogin();

	$page = new PageAdmin();
	$recipe = new Recipes();

	$page->setTpl("recipe-update", [
		'createError'=>Recipes::getError(),
		'createSuccess'=>Recipes::getSuccess(),
		'yieldTypes'=>encodeData(Recipes::getComboBox('yt')),
		'difficults'=>encodeData(Recipes::getComboBox('diff')),
		'measures'=>encodeData(Recipes::getComboBox('meas')),
		'ingredients'=>encodeData(Recipes::getComboBox('ing')),
		'recipeData'=>Recipes::getRecipe((int)$idRecipe),
		'ingredientsList'=>Recipes::getRecipeIngredients((int)$idRecipe),
		'stepsList'=>Recipes::getRecipeSteps((int)$idRecipe)
	]);

});

$app->post("/admin/recipes/:IDRECIPE", function($idRecipe){

	User::verifyLogin();

	$recipe = new Recipes();

	$_SESSION['recipeRegisterValues'] = $_POST;

	$recipe->setlistedIngredients($_POST);
	$recipe->setlistedSteps($_POST);

	$recipe->getRecipe2((int)$idRecipe);

	if (!isset($_POST['recipeName']) || $_POST['recipeName'] === '') {
		Recipes::setError("Informe o nome da receita!");
		header("Location: /admin/recipes/$idRecipe");
		exit;
	}

	if (!isset($_POST['yield']) || (int)$_POST['yield'] === 0) {
		Recipes::setError("A receita precisa de um rendimento maior que 0!");
		header("Location: /admin/recipes/$idRecipe");
		exit;
	}

	if (!isset($_POST['idYield']) || (int)$_POST['idYield'] === 0 || $_POST['idYield'] === NULL) {
		Recipes::setError("É preciso informar o tipo do rendimento!");
		header("Location: /admin/recipes/$idRecipe");
		exit;
	}

	if (!isset($_POST['preparationTime']) || strtotime($_POST['preparationTime']) === strtotime("00:00")) {
		Recipes::setError("O tempo da receita precisa ser maior que 00:00");
		header("Location: /admin/recipes/$idRecipe");
		exit;
	}


	if (!isset($_POST['idDifficult']) || (int)$_POST['idDifficult'] === 0 || $_POST['idDifficult'] === NULL) {
		Recipes::setError("É preciso selecionar uma dificuldade para a receita!");
		header("Location: /admin/recipes/$idRecipe");
		exit;
	}

	if (!isset($_POST['idAuthor']) || $_POST['idAuthor'] === '') {
		Recipes::setError("Informe o autor!");
		header("Location: /admin/recipes/$idRecipe");
		exit;
	}

	$recipe->checkIngredients($_SESSION[Recipes::INGREDIENTS_LISTED], false);
	$recipe->checkSteps($_SESSION[Recipes::STEPS_LISTED], false);

	$recipe->setData($_POST);

	$recipe->updateRecipe();
	$recipe->saveIngredients();
	$recipe->saveSteps();

	$_SESSION[Recipes::INGREDIENTS_LISTED] = "";
	$_SESSION[Recipes::STEPS_LISTED] = "";
	$_SESSION['recipeRegisterValues'] = NULL;

	Recipes::setSuccess("Alterações feitas com sucesso!");
	header("Location: /admin/recipes/$idRecipe");
	exit;
});

// $app->get("/admin/difficults/:IDDIFFICULT/des-active", function($idDifficult){

// 	User::verifyLogin();

// 	$difficult = new Difficult();

// 	$difficult->getDifficult((int)$idDifficult);

// 	$difficult->des_active();

// 	header("Location: /admin/difficults");
// 	exit;
// });


?>
