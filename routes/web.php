<?php

use Illuminate\Support\Facades\Route;

Route::get("/", "RouteController@goLogin");
Route::get('goRegister', 'RouteController@goRegister');
Route::get('goUpdate/{id}', 'RouteController@goUpdate');

Route::get('goMypage/{id}', 'RouteController@goMypage');
Route::get('goProfEdit/{id}', 'RouteController@goProfEdit');

Route::get('goApplied/{id}', 'RouteController@goApplied');

Route::get('goHome/{id}', 'RouteController@goHome');

Route::get('goOrdered/{id}', 'RouteController@goOrdered');

Route::get('goMadeQuest/{id}', 'RouteController@goMadeQuest');
Route::get('makeQuest/{id}', 'RouteController@makeQuest');

Route::get('showProfile/{id}/{o_id}', 'RouteController@showProfile');

Route::get('questDetail/{id}/{q_id}', 'RouteController@questDetail');

Route::get('evaluation/{id}/{q_id}/{status}', 'RouteController@evaluation');

Route::get('showPerformance/{id}', 'RouteController@showPerformance');
