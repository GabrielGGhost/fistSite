<?php 

use \Dev\Page;
use \Dev\Model\Ingredient;


$app->get("/ingredients", function(){

	$page = new Page();

	$ingredients = Ingredient::listAll();

	$ingredients = encodeData($ingredients);

	$page->setTpl("ingredients-list",[
		'ingredients'=>$ingredients
	]);

});

 ?>