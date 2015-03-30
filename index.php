<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'autoload.php';

use NFSWeb\App\Router;
use NFSWeb\App\App;

$_uri = $_SERVER['REQUEST_URI'];
$_offset = '/wh-web';
//$R = new Router($_uri, $_offset);

App::run();

