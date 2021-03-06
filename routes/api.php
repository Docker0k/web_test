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


//Route::post('auth/login', 'Api\User\AuthController@login');

Route::middleware('auth:api')->group(function () {
    Route::get('/user/info', function () {
        return new \Illuminate\Http\JsonResponse(['info' => []], 200);
    });

    Route::get('/remote-files', 'Api\RemoteFilesController@getRemoteFiles');
    Route::post('/remote-files/{fileKey}/import', 'Api\RemoteFilesController@importRemoteFile');
    Route::get('/report', function () {
        $limit = 400;
        $report = [
            'importedByFiles' => \App\Models\Files::getRows(),
            'subscribesInfo' => \App\Models\Subscription::getRows(),
            'importedByFilesCount' => \App\Models\Files::getRowsLimited($limit),
            'limit' => $limit
        ];
        return response()->json($report);
    });


});
