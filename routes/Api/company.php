<?php

Route::group(['prefix' => 'v1/company'], function () {
    Route::get('getName', 'CompanyController@getCompanyName');
});