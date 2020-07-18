<?php 

session_start();
require_once("vendor/autoload.php");

use Slim\Slim;
use Dev\Page;
use Dev\PageAdmin;

$app = new Slim();

$app->config('debug', true);

require_once("functions.php");
require_once("admin-users.php");
require_once("admin-ingredients.php");
require_once("admin.php");

$app->run();

 ?>