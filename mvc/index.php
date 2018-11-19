<?php

spl_autoload_register();

$self=str_replace(basename(__FILE__),
    '',$_SERVER['PHP_SELF']);

$urlTokens=explode('/',str_replace($self,
    '',$_SERVER['REQUEST_URI']));

$controllerName=array_shift($urlTokens);
$actionName=array_shift($urlTokens);
$params=$urlTokens;

$view= new \Core\View\View($controllerName,$actionName);
$request=new \Core\Request\Request($controllerName,$actionName,$params,$view);
$app= new \Core\App\Application($request);

try{
    $app->run();
}catch (Exception $ex){
    echo $ex->getMessage();
    exit();
}
