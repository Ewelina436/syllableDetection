<?php
define('WEB_SYSTEM', 'crm');

require_once(dirname(__FILE__,3)."/!_shared/classes/AutoLoader.php");
require_once(dirname(__FILE__,3)."/!_shared/functions/main.php");

$App = new AppFunctions(['system' => 'crm']);
require_once ("SylabeDetection.php");


$sylabeDet=new SylabeDetection($App);
$sylabeDet->getSyllable('joanna');

//chwaszochnyd