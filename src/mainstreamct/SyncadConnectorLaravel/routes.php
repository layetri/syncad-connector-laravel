<?php

  use Illuminate\Http\Request;

  Route::get('/ext/auth', function (Request $request) {
    return Syncad::authenticate($request->key, config('syncad.login_redirect'));
  });

  Route::group(['middleware' => ['cors', 'api']], function () {
    Route::prefix('api')->group(function () {
      Route::post('connection/test', function (Request $request) {
        return Syncad::testConnection($request->key);
      });

      Route::group(['middleware' => ['syncad']], function () {
        Route::post('login/init', 'SyncadController@pokesLogin');

        Route::post('make/user', function (Request $request) {
          return Syncad::makeUser($request);
        });
      });
    });
  });