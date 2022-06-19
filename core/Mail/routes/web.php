<?php

Route::namespace('Core\Mail\Controllers\Web')->prefix('admin')->name('admin.')->group(function () {
    #*** Ex: START: Mail ***#
    // Route::resource('mails', 'MailController')->except([
    //    'store', 'update', 'destroy'
    // ]);
    #*** END: Mail ***#
});
