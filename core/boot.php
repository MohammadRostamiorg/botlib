<?php
global $input;
use App\Controller;
$basedir =  dirname(__DIR__."../");
require __DIR__."/loadEnv.php";
require $basedir."/core/DB.php";
require $basedir."/core/bot.php";
require $basedir."/app/StateManager.php";


new Controller($input);


