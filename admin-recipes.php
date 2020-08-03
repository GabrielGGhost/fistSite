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
		'createError'=>'',
		'createSuccess'=>'',
		'recipes'=>$recipes
	]);

});

$app->get("/admin/recipes/create", function(){

	// $_SESSION[Recipes::INGREDIENTS_LISTED] = "";


	$yieldTypes = Recipes::getComboBox('yt');
	$yieldTypes = encodeData($yieldTypes);

	$page = new PageAdmin();

	$yieldTypes = Recipes::getComboBox('yt');
	$yieldTypes = encodeData($yieldTypes);

	$difficults = Recipes::getComboBox('diff');
	$difficults = encodeData($difficults);

	$measure = Recipes::getComboBox('meas');
	$measure = encodeData($measure);

	$ingredient = Recipes::getComboBox('ing');
	$ingredient = encodeData($ingredient);

	$page->setTpl("recipe-create", [
		'createError'=>Recipes::getError(),
		'recipeRegisterValues'=>(isset($_SESSION['recipeRegisterValues'])) ? $_SESSION['recipeRegisterValues'] : ['recipeName'=>'', 'yield'=>'', 'preparationTime'=>'', 'idAuthor'=>''],
		'yieldType'=>$yieldTypes,
		'difficult'=>$difficults,
		'measure'=>$measure,
		'ingredient'=>$ingredient,
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

	$ingredients = $_SESSION[Recipes::INGREDIENTS_LISTED];

	$recipe->checkIngredients($ingredients);

	$recipe->setData($_POST);

	if(!$recipe->checkAuthor()){

		Recipes::setError("Autor inexistente!");
		header("Location: /admin/recipes/create");
		exit;
	}

	$i = 0;
	while(true) {
		if($recipe->{"getingredient_" . ++$i}() === NULL) {
			break;
		}
	}
	
	$recipe->setIngredientQtd(--$i);

	$recipe->saveRecipe();

	$_SESSION[Recipes::INGREDIENTS_LISTED] = "";
	$_SESSION[Recipes::STEPS_LISTED] = "";

	$_SESSION['recipeRegisterValues'] = NULL;
	Recipes::setSuccess('Receita ' . $recipe->getrecipeName() . ' foi adicionada com sucesso!');
	header("Location: /admin/recipes");
	exit;
});


// $app->get("/admin/difficults/:IDDIFFICULT", function($idDifficult){

// 	User::verifyLogin();

// 	$page = new PageAdmin();
// 	$difficult = new Difficult();

// 	$difficult->getDifficult((int)$idDifficult);

// 	$page->setTpl("difficult-update", [
// 		'createError'=>Difficult::getError(),
// 		'createSuccess'=>Difficult::getSuccess(),
// 		'difficult'=>$difficult->getValues()
// 	]);

// });

// $app->post("/admin/difficults/:IDDIFFICULT", function($idDifficult){

// 	User::verifyLogin();

// 	$difficult = new Difficult();

// 	$page = new PageAdmin();

// 	$difficult->getDifficult((int)$idDifficult);

// 	if (!isset($_POST['difficultLevel']) || $_POST['difficultLevel'] === '') {
// 		Difficult::setError("Informe o nome da dificuldade!");
// 		header("Location: /admin/difficults/$idDifficult");
// 		exit;
// 	}

// 	if($_POST['difficultLevel'] != $difficult->getdifficultLevel()) {
// 		if(Difficult::verifyDifficult($_POST['difficultLevel'])){
// 			Difficult::setError("Dificuldade já cadastrada!");
// 			header("Location: /admin/difficults/$idDifficult");
// 			exit;
// 		}
// 	}

// 	$difficult->setData($_POST);

// 	$difficult->update();

// 	Difficult::setSuccess("Alterações feitas com sucesso!");
// 	header("Location: /admin/difficults/$idDifficult");
// 	exit;
// });

// $app->get("/admin/difficults/:IDDIFFICULT/des-active", function($idDifficult){

// 	User::verifyLogin();

// 	$difficult = new Difficult();

// 	$difficult->getDifficult((int)$idDifficult);

// 	$difficult->des_active();

// 	header("Location: /admin/difficults");
// 	exit;
// });


?>
