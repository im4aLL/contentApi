<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $guarded = ['id'];

    /**
     * Get the category of a content.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Admin\Cat', 'cat_id');
    }
}
