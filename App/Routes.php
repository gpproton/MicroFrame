<?php

declare(strict_types=1);

use MicroFrame\Handlers\Route;

defined('BASE_PATH') or exit('No direct script access allowed');

// TODO: Route point to related path with dot note, and an array of required middleware, check notes
// TODO: Default app middleware config for all controllers with pattern match
// TODO: Add default middleware, header and routing structure here.
// TODO: Route parameter from second level, filter : or {XXZZZ} at first level.
/*
|--------------------------------------------------------------------------
| APP Routes
|--------------------------------------------------------------------------
|
| Here is where you can register routes for your application if they're
| not to be automatically routed via the controller path.
| 1. path
| 2. request methods array()
| 3. [ function | closure | string | file system path | controller array() ]
| 4. middleware
| 5. status
|
| NOTE: Status does not function for controllers routing only within the controller codes.
*/

//Route::map("/", ['get', 'post'], "test", []);

//Route::map("/api/index", ['get', 'post'], "api.index", []);

//Route::map("/api/index/*", ['get', 'post'], function () {return "Test routes...";}, []);

//Route::map("/api/test/*", ['get', 'post'], "Testing!!!", []);

//Route::map("/api/", ['get', 'post', 'put'], "api.index", []);

//Route::map("/test", ['get', 'post'], "test", []);

//Route::map("/testing", ['get', 'post'], "./CustomApp", []);

Route::map("/testx/sampling/*", ['get', 'post'], function () {
    return "Hey there!!";
}, []);
