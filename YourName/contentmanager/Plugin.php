<?php namespace yourname\contentmanager;

use System\Classes\PluginBase;
use Illuminate\Support\Facades\Route;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'Content Manager',
            'description' => 'Manage and publish content',
            'author'      => 'Your Name',
            'icon'        => 'icon-pencil'
        ];
    }

    public function registerComponents() {}
	
	public function register()
{
    Route::get('/register', 'yourname\contentmanager\Controllers\Registration@index');
    Route::post('/register', 'yourname\contentmanager\Controllers\Registration@onRegister');
}


    public function registerPermissions()
    {
        return [
            'yourname.contentmanager.manage_content' => [
                'tab' => 'Content Manager',
                'label' => 'Manage Content'
            ],
        ];
    }
}
