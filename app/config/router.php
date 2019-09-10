<?php

$router = $di->getRouter();

$router->add('/', ['controller' => 'index', 'action' => 'index']);

$router->add('/user/register', ['controller' => 'user', 'action' => 'indexRegister']);
$router->add('/user/register/submit', ['controller' => 'user', 'action' => 'submitRegister']);
$router->add('/user/login', ['controller' => 'user', 'action' => 'indexLogin']);
$router->add('/user/login/submit', ['controller' => 'user', 'action' => 'submitLogin']);
$router->add('/user/logout', ['controller' => 'user', 'action' => 'logout']);

$router->add('/address/index', ['controller' => 'address', 'action' => 'index']);
$router->add('/address/user/{id}', ['controller' => 'address', 'action' => 'indexUser']);
$router->add('/address/user/add', ['controller' => 'address', 'action' => 'addAddress']);
$router->add('/address/delete/{id}', ['controller' => 'address', 'action' => 'delete']);
$router->add('/address/ajax', ['controller' => 'address', 'action' => 'ajax']);

$router->handle();
