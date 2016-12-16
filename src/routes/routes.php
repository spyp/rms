<?php
/*
|--------------------------------------------------------------------------
| Routes admin
|--------------------------------------------------------------------------
*/
Route::group(
    ['middleware' => ['web'],
        'namespace' => 'Cobonto\\Controllers\\Admin',
    ],
    function ()
    {
        $admin_url = config('app.admin_url');
        Route::get($admin_url.'/login', 'AuthController@showLoginForm')->name($admin_url.'.login');
        Route::post($admin_url.'/login', 'AuthController@login')->name($admin_url.'.login.auth');
        Route::get($admin_url.'/logout', 'AuthController@logout')->name($admin_url.'.logout');
    });
/*
|--------------------------------------------------------------------------
| Routes admin controllers
|--------------------------------------------------------------------------
*/
Route::group(
    [
        'namespace' => 'Cobonto\Controllers\Admin',
        'middleware' => ['web', 'admin'],
        'prefix' => config('app.admin_url')], function ()
{
    // module routes
    $admin_url = config('app.admin_url');
    Route::get('modules/install/{author}/{name}', 'ModulesController@install')->name($admin_url.'.modules.install');
    Route::get('modules/uninstall/{author}/{name}', 'ModulesController@uninstall')->name($admin_url.'.modules.uninstall');;
    Route::get('modules/enable/{author}/{name}', 'ModulesController@enable')->name($admin_url.'.modules.enable');;
    Route::get('modules/disable/{author}/{name}', 'ModulesController@disable')->name($admin_url.'.modules.disable');;
    Route::get('modules/configure/{author}/{name}', 'ModulesController@configuration')->name($admin_url.'.modules.configure');;
    Route::post('modules/save/{author}/{name}', 'ModulesController@save')->name($admin_url.'.modules.save');;
    Route::post('modules/uploadModule', 'ModulesController@uploadModule')->name($admin_url.'.modules.uploadModule');;
    Route::get('modules/rebuild', 'ModulesController@rebuildList')->name($admin_url.'.modules.rebuildList');

    // module positions routes
    Route::get('modules/positions', 'ModulePositionsController@index')->name($admin_url.'.positions.index');
    Route::post('modules/positions/update', 'ModulePositionsController@updatePositions')->name($admin_url.'.positions.update');
    Route::post('modules/positions/unregister', 'ModulePositionsController@unRegister')->name($admin_url.'.positions.unregister');
    Route::get('modules/positions/set', 'ModulePositionsController@set')->name($admin_url.'.positions.set');
    Route::post('modules/positions/register', 'ModulePositionsController@register')->name($admin_url.'.positions.register');
    Route::post('modules/positions/loadhooks', 'ModulePositionsController@loadHooks')->name($admin_url.'.positions.loadhooks');
    // permissions route
    Route::get('permissions', 'PermissionsController@index')->name($admin_url.'.permissions.index');
    Route::post('permissions/update', 'PermissionsController@updatePermissions')->name($admin_url.'.permissions.update');
    Route::post('permissions/role', 'PermissionsController@Role')->name($admin_url.'.permissions.role');
    // settings route
    Route::get('settings/{settings}', 'SettingsController@settings')->name($admin_url.'.settings.settings');
    Route::post('settings/update', 'SettingsController@updateSettings')->name($admin_url.'.settings.update');
    Route::post('settings/load', 'SettingsController@load')->name($admin_url.'.settings.load');
    // translate controller
    Route::get('translates','TranslatesController@index')->name($admin_url.'.translates.index');
    Route::post('translates/load','TranslatesController@loadFile')->name($admin_url.'.translates.load');
    Route::post('translates/save','TranslatesController@saveFile')->name($admin_url.'.translates.save');
    Route::post('translates/environment','TranslatesController@loadEnvironment')->name($admin_url.'.translates.environment');
    Route::resources([
        'dashboard' => 'DashboardController',
        'users' => 'UsersController',
        'modules' => 'ModulesController',
        'roles'=>'RolesController',
        'groups'=>'GroupsController',
        'admins'=>'AdminsController',
    ]);
/*
|--------------------------------------------------------------------------
| require  routes
|--------------------------------------------------------------------------
| for others routes that it's more complicated we separate them in files and require here
*/
    $files = File::allFiles( __DIR__.'/admin');
    foreach ($files as $file)
    {
        require_once($file->getPathName());
    }
});

/*
|--------------------------------------------------------------------------
| Routes front
|--------------------------------------------------------------------------
*/
Route::get('/url-changed',function(){
    return 'Url changed type new admin url link and back to dashboard';
})->name('url.changed');
