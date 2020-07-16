<?php

use MicroFrame\Handlers\Route;

defined('BASE_PATH') OR exit('No direct script access allowed');

// TODO: Route point to related path with dot note, and an array of required middleware, check notes
// TODO: Default app middleware config for all controllers with pattern match
// TODO: Add default middleware, header and routing structure here.
/*
|--------------------------------------------------------------------------
| APP Routes
|--------------------------------------------------------------------------
|
| Here is where you can register routes for your application if they're
| not to be automatically routed via the controller path.
|
| NOTE: Avoid any string or character output here it would break rendering for now.
|
*/

Route::map("/api/index/*");

