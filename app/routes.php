<?php


$app->route('/','index','get', 'mhndev\NanoFrameworkSkeleton\Controllers\HomeController@indexAction');


$app->get('/users','users_index','mhndev\trycatch\Controllers\UserController@indexAction');

$app->route('/trycatch/public/index.php','index','delete', 'mhndev\trycatch\Controllers\UserController@deleteAction');



//$app->get('/test/public/index.php', 'index2', '\App\Controllers\HomeController@fooAction');
