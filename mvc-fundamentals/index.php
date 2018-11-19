<?php
spl_autoload_register();
session_start();
$entryPointFileName = basename(__FILE__);
$self = $_SERVER['PHP_SELF'];
$junk = str_replace($entryPointFileName, '', $self);
$uri = $_SERVER['REQUEST_URI'];
$significantUri = str_replace($junk, '', $uri);
$significantUri = str_replace([$_SERVER['QUERY_STRING'], '?'], '', $significantUri);

$uriParts = explode('/', $significantUri);

$controllerName = array_shift($uriParts);
$actionName = array_shift($uriParts);
$arguments = $uriParts;

$app = new \Core\Application($controllerName, $actionName, $arguments);

$db = new \Database\PDODatabase(new PDO("mysql:dbname=chushki;host=localhost", 'root', ''));


$app->addMapping(
    \Core\View\ViewInterface::class,
    \Core\View\View::class);

$app->addMapping(
    \Services\Mail\MailServiceInterface::class,
    \Services\Mail\SmtpMailService::class
);

$app->addMapping(
    \App\Service\UserServiceInterface::class,
    \App\Service\UserService::class
);

$app->addMapping(
    \App\Repository\UserRepositoryInterface::class,
    \App\Repository\UserRepository::class
);

$app->addInstance(
    \Database\DatabaseInterface::class,
    $db
);

$app->start();
