<?php 

use \Dev\PageAdmin;
use \Dev\Model\Ingredient;
use \Dev\Model\IngredientCategory;
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

	$_SESSION['ingredientsRegisterValues'] = NULL;

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

		if($_POST['singularName'] != $ingredient->getsingularName()){

			if(Ingredient::verifySingularName($_POST['pluralName'])){
			
				Ingredient::setError('Ingrediente plural já cadastrado!');
				header("Location: /admin/ingredients/$idIngredient");
				exit;
			}
		}

		if($_POST['pluralName'] != $ingredient->getpluralName()){

			if(Ingredient::verifyPluralName($_POST['pluralName'])){
			
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

$app->get("/admin/ingredients/:idIngredient/des_active", function($idIngredient){

	User::verifyLogin();

	$ingredient = new Ingredient();

	$ingredient->getIngredient((int)$idIngredient);

	$ingredient->des_active();

	header("Location: /admin/ingredients");
	exit;
});

$app->get("/admin/ingredient-category/linkCategories/:IDCATEGORY", function($idIngredient){

	User::verifyLogin();

	$ingredient = new Ingredient();
	$page = new PageAdmin();
	$ingredient->getIngredient((int)$idIngredient);
	$relatedCategories = $ingredient->getCategories(true);
	$nonRelatedCategories = $ingredient->getCategories();

	$relatedCategories = encodeData($relatedCategories);
	$nonRelatedCategories = encodeData($nonRelatedCategories);

	$page->setTpl("ingredient-categories", [
		'ingredient'=>$ingredient->getValues(),
		'nonRelatedCategories'=>$nonRelatedCategories,
		'relatedCategories'=>$relatedCategories
	]);
});

$app->get("/admin/categories/:IDCATEGORY/ingredients/:IDINGREDIENT/add", function($idCategory, $idIngredient){

	User::verifyLogin();

	$ingredient = new Ingredient();
	$category = new IngredientCategory();

	$ingredient->getIngredient((int)$idIngredient);
	$category->getIngredientCategory((int)$idCategory);

	$ingredient->addCategory($category);

	header("Location: /admin/ingredient-category/linkCategories/$idIngredient");
	exit;
});

$app->get("/admin/categories/:IDCATEGORY/ingredients/:IDINGREDIENT/remove", function($idCategory, $idIngredient){

	User::verifyLogin();

	$ingredient = new Ingredient();
	$category = new IngredientCategory();

	$ingredient->getIngredient((int)$idIngredient);
	$category->getIngredientCategory((int)$idCategory);

	$ingredient->removeCategory($category);

	header("Location: /admin/ingredient-category/linkCategories/$idIngredient");
	exit;
});

?>