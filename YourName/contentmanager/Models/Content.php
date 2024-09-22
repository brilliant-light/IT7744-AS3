<?php namespace yourname\contentmanager\Models;

use Model;

/**
 * Content Model
 */
class Content extends Model
{
    // This property defines the database table associated with the model
    protected $table = 'contents'; 

    // This property defines the fillable attributes
    protected $fillable = [
        'title',
        'body',
    ];
}
