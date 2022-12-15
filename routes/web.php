<?php

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
    Route::get('/departaments-results','HomeController@getDepartamentsResults')->name('getDepartamentsResults');
    // Route::get('/departaments-categor');

    Route::get('/categories-results','HomeController@getCategoriesResults')->name('getCategoriesResults');

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

    Route::post('survey-builders/get-survey-builder','SurveyBuilderController@getSurveyBuilder')->name('survey-builders.getSurveyBuilder');

    Route::post('survey-builders/store-survey','SurveyBuilderController@storeSurvey')->name('survey-builders.storeSurvey');

    Route::post('survey-builders/get-categories', 'SurveyBuilderController@getControllCategories')->name('survey-builders.getControllCategories');

    Route::post('survey-builders/get-available-categories', 'SurveyBuilderController@getAvailableControllCategories')->name('survey-builders.getAvailableCategories');

    Route::post('survey-builders/get-dimensions', 'SurveyBuilderController@getDimensions')->name('survey-builders.getDimensions');

    Route::delete('survey-builders/destroy', 'SurveyBuilderController@massDestroy')->name('survey-builders.massDestroy');
    Route::resource('survey-builders', 'SurveyBuilderController');

    // Survey Result

    Route::post('survey-results/store-survey-result', 'SurveyResultController@storeSurveyResult')->name('survey-results.storeSurveyResult');

    Route::delete('survey-results/destroy', 'SurveyResultController@massDestroy')->name('survey-results.massDestroy');
    Route::resource('survey-results', 'SurveyResultController');

    // Dimensiune
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
