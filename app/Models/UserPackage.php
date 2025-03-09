<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class UserPackage extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'package', 'status', 'ref_id', 'sale','earn'];

    protected $casts = [
        'status' => 'string',  // Ensure that status is always a string
    ];
    public $timestamps = true;
    // Define the relationship to User
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function userpackage()
    {
        return $this->belongsTo(Package::class , 'package');
    }
}
