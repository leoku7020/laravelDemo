<?php

Route::group(['prefix' => 'v1/member'], function () {
    Route::post('register', 'MemberController@register')->name('register');
});