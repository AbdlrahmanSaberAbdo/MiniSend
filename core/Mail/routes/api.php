<?php

Route::group(['prefix' => 'api', 'middleware' => []], function () {
    # V1
    Route::namespace('Core\Mail\Controllers\API\V1')->prefix('v1')->name('api.v1.')->group(function () {
        #*** Ex: START: Mail ***#
         Route::apiResource('emails', 'MailController');
        #*** END: Mail ***#

        Route::get('/attachments/download', 'MailController@download');
    });
});
