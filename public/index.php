<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
const DS = DIRECTORY_SEPARATOR;
const DSUP = '..'.DS;

require __DIR__.DS.'..'.DS.'vendor'.DS.'autoload.php';

require_once __DIR__.DS.'..'.DS.'config'.DS.'bootstrap.php';
