<?php 

require_once __DIR__ . "/vendor/autoload.php";

use Appp\Routes\Router;

$entry = Router();
$entry->helloWorld();
