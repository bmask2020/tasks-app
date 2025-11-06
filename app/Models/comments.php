<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    
    protected $guarded = [];

    public function user() {

        return $this->belongsTo(User::class, 'user_id');

    } // End Method


    public function task() {

        return $this->belongsTo(tasks::class, 'task_id');

    } // End Method
    
}
