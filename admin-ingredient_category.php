<?php 

use \Dev\DB\Sql;
use \Dev\Model;
use \Dev\PageAdmin;
use \Dev\Model\IngredientCategory;
use \Dev\Model\User;

$app->get("/admin/ingredient-category", function(){

	User::verifyLogin();

	$page = new PageAdmin();
	$categories = IngredientCategory::listAll();

	$categories = encodeData($categories);

	$page->setTpl("ingredient-category", [
		'createError'=>'',
		'createSuccess'=>'',
		'categories'=>$categories
	]);

});

$app->get("/admin/ingredient-category/create", function(){

	$page = new PageAdmin();

	$page->setTpl("ingredient-category-create", [
		'createError'=>IngredientCategory::getError(),
		'ingredientCategoryregisterValues'=>(isset($_SESSION['ingredientCategoryregisterValues'])) ? $_SESSION['ingredientCategoryregisterValues'] : ['name'=>'']
	]);

});

$app->post("/admin/ingredient-category/create", function(){

	User::verifyLogin();

	$category = new IngredientCategory();

	$_SESSION['ingredientCategoryregisterValues'] = $_POST;

	if (!isset($_POST['name']) || $_POST['name'] === '') {
		IngredientCategory::setError("Informe o nome da categoria!");
		header("Location: /admin/ingredient-category/create");
		exit;
	}

	if(IngredientCategory::verifyIngredientCategory($_POST['name'])){
		IngredientCategory::setError("Categoria já cadastrada!");
		header("Location: /admin/ingredient-category/create");
		exit;
	}

	$category->setData($_POST);

	$category->save();

	$_SESSION['ingredientCategoryregisterValues'] = NULL;

	header("Location: /admin/ingredient-category");
	exit;
});

$app->get("/admin/ingredient-category/:IDCATEGORY", function($idCategory){

	User::verifyLogin();

	$page = new PageAdmin();
	$category = new IngredientCategory();

	$category->getIngredientCategory((int)$idCategory);

	$page->setTpl("ingredient-category-update", [
		'createError'=>IngredientCategory::getError(),
		'createSuccess'=>IngredientCategory::getSuccess(),
		'category'=>$category->getValues()
	]);

});

$app->post("/admin/ingredient-category/:IDCATEGORY", function($idCategory){

	User::verifyLogin();

	$category = new IngredientCategory();

	$page = new PageAdmin();

	$category->getIngredientCategory((int)$idCategory);

	if (!isset($_POST['name']) || $_POST['name'] === '') {
		IngredientCategory::setError("Informe o nome da categoria!");
		header("Location: /admin/ingredient-category/$idCategory");
		exit;
	}

	if($_POST['name'] != $category->getname()) {
		if(IngredientCategory::verifyIngredientCategory($_POST['name'])){
			IngredientCategory::setError("Categoria já cadastrada!");
			header("Location: /admin/ingredient-category/$idCategory");
			exit;
		}
	}

	$category->setData($_POST);

	$category->update();

	IngredientCategory::setSuccess("Alterações feitas com sucesso!");
	header("Location: /admin/ingredient-category/$idCategory");
	exit;
});


$app->get("/admin/ingrendient-category/:IDCATEGORY/des-active", function($idCategory){

	User::verifyLogin();

	$category = new IngredientCategory();

	$category->getIngredientCategory((int)$idCategory);

	$category->des_active();

	header("Location: /admin/ingredient-category");
	exit;
});
?>