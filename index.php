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
require_once("site-ingredients.php");
require_once("admin-ingredient_category.php");
require_once("admin-recipe_category.php");
require_once("admin-difficult.php");
require_once("admin-measure.php");
require_once("admin-yields.php");
require_once("admin-recipes.php");

$app->run();

 ?>