<?php 

require_once("vendor/autoload.php");

use Slim\Slim;
use Dev\DB\Sql;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    

	$sql = new Sql();

	$sql->query("INSERT INTO tb_ingredient(ingredient) VALUES ('vinagre');");

	$results = $sql->select("SELECT * FROM tb_ingredient");

	var_dump($results);
	exit;

});

$app->run();

 ?>