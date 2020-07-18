<?php 

use \Dev\PageAdmin;
use \Dev\Model\Ingredient;
use \Dev\DB\Sql;
use \Dev\Model;

$app->get("/admin/ingredients", function(){

	$page = new PageAdmin();

	$ingredients = Ingredient::listAll();

	$page->setTpl("ingredients", [
		'ingredients'=>$ingredients
	]);

});

$app->get("/admin/ingredients/create", function(){

	$page = new PageAdmin();

	$page->setTpl("ingredients-create");
});



?>