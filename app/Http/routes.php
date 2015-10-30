<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', 'HomeController@dashboard');
$app->get('/subjects', 'HomeController@subjects');
$app->get('/subjects/new', 'HomeController@newSubject');
$app->post('/subjects/save', 'HomeController@saveSubject');

$app->get('/subject/{id}/row/{index}', 'HomeController@viewGrades');
$app->get('/subject/{id}', 'HomeController@viewGrades');
$app->post('/subject/{id}', 'HomeController@viewGrades');

$app->post('/upload', 'HomeController@upload');

$app->get('/activities/add', 'HomeController@addActivities');
$app->post('/activities/save', 'HomeController@saveActivities');

$app->get('/activities/{id}/add', 'HomeController@addActivities');
$app->post('/activities/{id}/save', 'HomeController@saveActivities');

$app->get('/subject/{id}/update', 'HomeController@viewSubject');
$app->post('/subject/{id}/update', 'HomeController@updateSubject');