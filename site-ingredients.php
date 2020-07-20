<?php 

use \Dev\Page;
use \Dev\Model\Ingredient;


$app->get("/ingredients", function(){

	$page = new Page();

	$ingredients = Ingredient::listAll();


	$page->setTpl("ingredients-list",[
		'ingredients'=>$ingredients
	]);

});

 ?>