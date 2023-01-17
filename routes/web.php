<?php

use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Illuminate\Support\Facades\Session;



Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Route::get('userVerification/{token}', 'UserVerificationController@approve')->name('userVerification');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    //Dashbord
    Route::get('/', 'HomeController@index')->name('home');


    Route::get('/payload', function(){

        $payload = 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiWEtNWGlrQnhFam8zcklLVEw2WFRRVkRKc2N3aXZ2M2dPWjJ1QVJZVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zdXJ2ZXktcmVzdWx0cy9jcmVhdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTY3Mzk0MzA5NTt9czoxMzoic3VydmV5X3Jlc3VsdCI7czo0OiIxMDUxIjt9';

        $decodedData = unserialize(base64_decode(($payload)));

        return response()->json(Session::get('survey_result'));
    });


    // Get data for Dashboard
    Route::get('/departaments-results', 'HomeController@getDepartamentsResults')->name('getDepartamentsResults');
    Route::get('/dimensions-results', 'HomeController@getDimensionsResults')->name('getDimensionsResults');
    // Route::get('/departaments-categor');
    Route::get('/categories-results', 'HomeController@getCategoriesResults')->name('getCategoriesResults');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Departamente
    Route::delete('departamentes/destroy', 'DepartamenteController@massDestroy')->name('departamentes.massDestroy');
    Route::resource('departamentes', 'DepartamenteController');

    // Survey Builder

    Route::post('survey-builders/get-survey-builder', 'SurveyBuilderController@getSurveyBuilder')->name('survey-builders.getSurveyBuilder');

    Route::post('survey-builders/update-survey', 'SurveyBuilderController@updateSurvey')->name('survey-buiders.updateSurvey');

    Route::post('survey-builders/store-survey', 'SurveyBuilderController@storeSurvey')->name('survey-builders.storeSurvey');

    Route::post('survey-builders/get-categories', 'SurveyBuilderController@getControllCategories')->name('survey-builders.getControllCategories');

    Route::post('survey-builders/get-available-categories', 'SurveyBuilderController@getAvailableControllCategories')->name('survey-builders.getAvailableCategories');

    Route::post('survey-builders/get-dimensions', 'SurveyBuilderController@getDimensions')->name('survey-builders.getDimensions');

    Route::delete('survey-builders/destroy', 'SurveyBuilderController@massDestroy')->name('survey-builders.massDestroy');
    Route::resource('survey-builders', 'SurveyBuilderController');

    // Survey Result

    Route::post('survey-results/store-survey-result', 'SurveyResultController@storeSurveyResult')->name('survey-results.storeSurveyResult');

    Route::post('survey-results/clear-survey-session','SurveyResultController@clearSurveySession')->name('survey-results.clearSurveySession');

    Route::delete('survey-results/destroy', 'SurveyResultController@massDestroy')->name('survey-results.massDestroy');
    Route::resource('survey-results', 'SurveyResultController');

    // Dimensiune
    Route::get('dimensiunes/get-available-dimensions/{depId}', 'DimensiuneController@getDimensionsForDepartament')->name('dimensiunes.getDimensionsForDepartament');

    Route::delete('dimensiunes/destroy', 'DimensiuneController@massDestroy')->name('dimensiunes.massDestroy');
    Route::resource('dimensiunes', 'DimensiuneController');

    // Categorie De asdfgeasdafasfasfffgg
    Route::delete('categorie-de-controls/destroy', 'CategorieDeControlController@massDestroy')->name('categorie-de-controls.massDestroy');
    Route::resource('categorie-de-controls', 'CategorieDeControlController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
