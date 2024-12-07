<?php

use App\Http\Middleware\EnsureApiSessionIsValid;
use Illuminate\Support\Facades\Route;


Route::middleware([EnsureApiSessionIsValid::class])->group(function () {

});
