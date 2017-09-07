<?php

Route::group(['prefix'=>'v1'], function () {
    Route::resource('users', 'UsersController', ['except'=>['edit', 'create']]);
    Route::resource('users.tasks', 'UserTasksController', ['except'=>['edit', 'create']]);
    Route::name('tasks')->get('tasks', 'TasksController@index');
    Route::name('tasks.show')->get('tasks/{id}', 'TasksController@show');
});
