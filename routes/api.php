<?php

Route::group(['prefix'=>'v1'], function () {
    Route::resource('users', 'UsersController', ['except'=>['edit', 'create']]);
    Route::resource('users.tasks', 'TasksController', ['except'=>['edit', 'create']]);
});
