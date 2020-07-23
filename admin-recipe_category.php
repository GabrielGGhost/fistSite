<?php 

use \Dev\DB\Sql;
use \Dev\Model;
use \Dev\PageAdmin;
use \Dev\Model\RecipeCategory;
use \Dev\Model\User;

$app->get("/admin/recipe-category", function(){

	User::verifyLogin();

	$page = new PageAdmin();
	$categories = RecipeCategory::listAll();

	$categories = encodeData($categories);

	$page->setTpl("recipe-category", [
		'createError'=>'',
		'createSuccess'=>'',
		'categories'=>$categories
	]);

});

$app->get("/admin/recipe-category/create", function(){

	$page = new PageAdmin();

	$page->setTpl("recipe-category-create", [
		'createError'=>RecipeCategory::getError(),
		'recipeCategoryRegisterValues'=>(isset($_SESSION['recipeCategoryRegisterValues'])) ? $_SESSION['recipeCategoryRegisterValues'] : ['name'=>'']
	]);

});

$app->post("/admin/recipe-category/create", function(){

	User::verifyLogin();

	$category = new RecipeCategory();

	$_SESSION['recipeCategoryRegisterValues'] = $_POST;

	if (!isset($_POST['name']) || $_POST['name'] === '') {
		RecipeCategory::setError("Informe o nome da categoria!");
		header("Location: /admin/recipe-category/create");
		exit;
	}

	if(RecipeCategory::verifyRecipeCategory($_POST['name'])){
		RecipeCategory::setError("Categoria já cadastrada!");
		header("Location: /admin/recipe-category/create");
		exit;
	}

	$category->setData($_POST);

	$category->save();

	$_SESSION['recipeCategoryRegisterValues'] = NULL;

	header("Location: /admin/recipe-category");
	exit;
});

$app->get("/admin/recipe-category/:IDCATEGORY", function($idCategory){

	User::verifyLogin();

	$page = new PageAdmin();
	$category = new RecipeCategory();

	$category->getRecipeCategory((int)$idCategory);

	$page->setTpl("recipe-category-update", [
		'createError'=>RecipeCategory::getError(),
		'createSuccess'=>RecipeCategory::getSuccess(),
		'category'=>$category->getValues()
	]);

});

$app->post("/admin/recipe-category/:IDCATEGORY", function($idCategory){

	User::verifyLogin();

	$category = new RecipeCategory();

	$page = new PageAdmin();

	$category->getRecipeCategory((int)$idCategory);

	if (!isset($_POST['name']) || $_POST['name'] === '') {
		RecipeCategory::setError("Informe o nome da categoria!");
		header("Location: /admin/recipe-category/$idCategory");
		exit;
	}

	if($_POST['name'] != $category->getname()) {
		if(RecipeCategory::verifyRecipeCategory($_POST['name'])){
			RecipeCategory::setError("Categoria já cadastrada!");
			header("Location: /admin/recipe-category/$idCategory");
			exit;
		}
	}

	$category->setData($_POST);

	$category->update();

	RecipeCategory::setSuccess("Alterações feitas com sucesso!");
	header("Location: /admin/recipe-category/$idCategory");
	exit;
});

$app->get("/admin/recipe-category/:IDCATEGORY/des-active", function($idCategory){

	User::verifyLogin();

	$category = new RecipeCategory();

	$category->getRecipeCategory((int)$idCategory);

	$category->des_active();

	header("Location: /admin/recipe-category");
	exit;
});
?>