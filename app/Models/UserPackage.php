<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UserPackage extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'package', 'status'];

    protected $casts = [
        'status' => 'string',  // Ensure that status is always a string
    ];

    // Define the relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
