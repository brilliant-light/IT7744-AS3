<?php namespace YourName\ImageUploader;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'ImageUploader',
            'description' => 'Allows users to upload images',
            'author'      => 'YourName',
            'icon'        => 'icon-camera'
        ];
    }

    public function registerComponents()
    {
        return [
            'YourName\ImageUploader\Components\ImageUploader' => 'imageUploader'
        ];
    }
}
