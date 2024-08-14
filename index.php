<?php
require   "vendor/autoload.php";
$input = file_get_contents("php://input");
$input = json_decode($input,true);
require "core/boot.php";


