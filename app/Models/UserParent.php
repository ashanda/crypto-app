<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserParent extends Model
{
    protected $fillable = ['user_id', 'virtual_id', 'parent_id','node'];
}
