<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('articles', 'ArticleController@index');//done
Route::post('articlewhere', 'ArticleController@where');//done
Route::post('articleinsert', 'ArticleController@store');//done
Route::post('articleupdate', 'ArticleController@update');//done
Route::post('articledelete', 'ArticleController@delete');//done
Route::post('articlelike', 'ArticleController@like');//done
Route::get('articleorderby', 'ArticleController@orderby');//done
Route::get('articleinnerjoin', 'ArticleController@innerjoin');//done
Route::get('articleleftjoin', 'ArticleController@leftjoin');//done
Route::get('articlerightjoin', 'ArticleController@rightjoin');//done
Route::get('articlefullouterjoin', 'ArticleController@fullouterjoin');//done
