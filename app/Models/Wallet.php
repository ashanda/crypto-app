<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    // Protect the mass assignment
    protected $fillable = ['user_id', 'balance'];

    // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Optionally, you can add helper methods to interact with wallet balances, such as:
    public function addBalance($amount)
    {
        $this->balance += $amount;
        $this->save();
    }

    public function subtractBalance($amount)
    {
        $this->balance -= $amount;
        $this->save();
    }
}

