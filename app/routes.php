<?php


$app->route('/','index','get', 'mhndev\NanoFrameworkSkeleton\Controllers\HomeController@indexAction');


$app->get('/users','users_index','mhndev\trycatch\Controllers\UserController@indexAction');

$app->route('/trycatch/public/index.php/users/delete','users_delete','delete', 'mhndev\trycatch\Controllers\UserController@deleteAction');
$app->route('/trycatch/public/index.php/users','user_list','get', 'mhndev\trycatch\Controllers\UserController@indexAction');



//$app->get('/test/public/index.php', 'index2', '\App\Controllers\HomeController@fooAction');
