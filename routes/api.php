<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout');

Route::post('register', 'UserController@register');

Route::post('update', 'UserController@update');

Route::post('mypage', 'UserController@mypage');

Route::post('showHome', 'QuestController@showHome');
Route::post('conditionQuest', 'QuestController@conditionQuest');
Route::post('showThisQuest', 'QuestController@showThisQuest');
Route::post('applyQuest', 'QuestController@applyQuest');

Route::post('goProfEdit', 'UserController@goProfEdit');
Route::post('profEdit', 'UserController@profEdit');

Route::post('showApplied', 'QuestController@showApplied');
Route::post('showOrdered', 'QuestController@showOrdered');
Route::post('showMadeQuest', 'QuestController@showMadeQuest');
Route::post('makeQuest', 'QuestController@makeQuest');
Route::post('storeQuest', 'QuestController@storeQuest');

Route::post('profile', 'GuildController@profile');
Route::post('otherProf', 'UserController@otherProf');

Route::post('questDetail', 'QuestController@questDetail');

Route::post('request', 'QuestController@request');

Route::post('storeEvaluation', 'QuestController@storeEvaluation');

Route::post('showPerformance', 'UserController@showPerformance');
