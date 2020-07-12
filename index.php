<?php 

require_once("vendor/autoload.php");

use Slim\Slim;
use Dev\Page;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    

});

$app->run();

 ?>