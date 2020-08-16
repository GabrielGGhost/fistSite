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

$app->get("/recipes/:IDRECIPE", function($idRecipe){

	$page = new Page();

	$recipes = Recipes::listAllActived();

	$recipes = encodeData($recipes);

	$recipes = Recipes::getPreviewImages($recipes);

	$page->setTpl("recipe-detail");
});


 ?>