<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tasks extends Model
{
    
    protected $guarded = [];

    public function user() {

        return $this->belongsTo(User::class, 'user_id');

    } // End Method


    public function comments() {

        return $this->hasMany(comments::class, 'task_id');

    } // End Method
    
}
