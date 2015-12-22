<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    protected $guarded = ['id'];

    /**
     * Get contents under a category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    /*public function contents()
    {
        return $this->hasMany('App\Models\Admin\Content');
    }*/
}
