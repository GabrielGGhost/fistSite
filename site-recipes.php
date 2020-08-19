<?php 

use \Dev\Page;
use \Dev\Model\Recipes;


$app->get("/recipes-list", function(){

	$page = new Page();

	$recipes = Recipes::listAllActived();

	$recipes = encodeData($recipes);

	$recipes = Recipes::getPreviewImages($recipes);

	$page->setTpl("recipes-list",[
		'recipes'=>$recipes
	]);

});

$app->get("/recipe-detail/:IDRECIPE", function($idRecipe){

	$page = new Page();

	$recipe = new Recipes();

	$page->setTpl("recipe-detail", [
		'recipe'=>$recipe->getRecipe((int)$idRecipe),
		'ingredients'=>$recipe->getRecipeIngredientes((int)$idRecipe)
	]);

});


// $app->get("", function($idRecipe){

// 	$page = new Page();

// 	$recipes = Recipes::listAllActived();

// 	$recipes = encodeData($recipes);

// 	$recipes = Recipes::getPreviewImages($recipes);

// 	$page->setTpl("index");
// });


 ?>