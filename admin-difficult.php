<?php 

use \Dev\DB\Sql;
use \Dev\Model;
use \Dev\PageAdmin;
use \Dev\Model\Difficult;
use \Dev\Model\User;

$app->get("/admin/difficults", function(){

	User::verifyLogin();

	$page = new PageAdmin();
	$difficults = Difficult::listAll();

	$difficults = encodeData($difficults);

	$page->setTpl("difficult", [
		'createError'=>'',
		'createSuccess'=>'',
		'difficults'=>$difficults
	]);

});

$app->get("/admin/difficults/create", function(){

	$page = new PageAdmin();

	$page->setTpl("difficult-create", [
		'createError'=>Difficult::getError(),
		'difficultRegisterValues'=>(isset($_SESSION['difficultRegisterValues'])) ? $_SESSION['difficultRegisterValues'] : ['difficultLevel'=>'']
	]);

});

$app->post("/admin/difficults/create", function(){

	User::verifyLogin();

	$difficult = new Difficult();

	$_SESSION['difficultRegisterValues'] = $_POST;

	if (!isset($_POST['difficultLevel']) || $_POST['difficultLevel'] === '') {
		Difficult::setError("Informe a dificuldade!");
		header("Location: /admin/difficults/create");
		exit;
	}

	if(Difficult::verifyDifficult($_POST['difficultLevel'])){
		Difficult::setError("Dificuldade já cadastrada!");
		header("Location: /admin/difficults/create");
		exit;
	}

	$difficult->setData($_POST);

	$difficult->save();

	$_SESSION['difficultRegisterValues'] = NULL;

	header("Location: /admin/difficults");
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