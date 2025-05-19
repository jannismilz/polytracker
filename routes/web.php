<?php

Route::get('/', function () {
  return response()->file(public_path('startup.html'));
});
