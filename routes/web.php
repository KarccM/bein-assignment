<?php

use Illuminate\Support\Facades\Route;

Route::view('/{vue?}', 'welcome')->where('vue', '^(?!api).*$');
