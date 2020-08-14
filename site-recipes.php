<?php 

use \Dev\Page;
use \Dev\Model\Recipes;


$app->get("/recipes-list", function(){

	$page = new Page();

	$recipes = Recipes::listAllActived();

	$recipes = encodeData($recipes);

	$page->setTpl("recipes-list",[
		'recipes'=>$recipes
	]);

});

 ?>