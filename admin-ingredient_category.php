<?php 

use \Dev\DB\Sql;
use \Dev\Model;
use \Dev\PageAdmin;

$app->get("/admin/ingredient-category", function(){

	$page = new PageAdmin();

	$page->setTpl("ingredient-category", [
		'createError'=>'',
		'createSuccess'=>''
	]);

});

$app->get("/admin/ingredient-category/create", function(){

	$page = new PageAdmin();

	$page->setTpl("ingredient-category-create", [
		'createError'=>'',
		'registerError'=>(isset($_SESSION['registerValues'])) ? $_SESSION['registerValues'] : ['name'=>'']
	]);

});

$app->post("/admin/ingredient-category/create", function(){

	$page = new PageAdmin();

	if (!isset($_POST['name']) || $_POST['name'] === '') {
			
	}

	header("Location: /admin/ingredient-category");
	exit;
});

?>