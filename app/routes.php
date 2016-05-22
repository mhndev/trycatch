<?php


//$app->get('/','index', 'mhndev\NanoFrameworkSkeleton\Controllers\HomeController@indexAction');


$app->get('/users','user_index','mhndev\trycatch\Controllers\UserController@indexAction');
$app->post('/users/{id}','user_create','mhndev\trycatch\Controllers\UserController@createAction');
$app->delete('/users/{id}','user_delete','mhndev\trycatch\Controllers\UserController@deleteAction');
$app->get('/users/{id}','users_show','mhndev\trycatch\Controllers\UserController@showAction');
$app->delete('/users/bulk','users_bulkDelete','mhndev\trycatch\Controllers\UserController@deleteBulkAction');
$app->put('/users/{id}','users_update','mhndev\trycatch\Controllers\UserController@updateAction');
