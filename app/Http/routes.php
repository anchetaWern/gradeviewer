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

$app->get('/tester', function(){

	$arr = array(
		array(
			'fname' => 'yoh',
			'lname' => 'asakura',
			'age' => 10
		),
		array(
			'fname' => 'ichigo',
			'lname' => 'kurosaki',
			'age' => 20
		)
	);

	$selected_key = '';
	$filtered = array_filter($arr, function($row) use ($selected_key) {
		if($row['age'] == 10){
			//$selected_key = $key;
			return $row;
		}
		
	});

	return key($filtered);
});

$app->get('/sess', function(){
	return session(array('d' => 'luffy'));
});

$app->get('/sess2', function(){
	$grades = session('grades');
	return $grades;
});
