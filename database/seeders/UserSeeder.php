<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ReferralCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Company Head',
            'email' => 'company@example.com',
            'password' => Hash::make('password'),
            'whatsapp_number' => '1234567890',
            'binance_pay_id' => 'binance_id_123',
            'status' => 'active',
            'role' => 'company',
            'referred_by' => null, // No referral code
        ]);

        // Generate referral code for the Admin
        $adminReferralCode = strtoupper(Str::random(6));
        ReferralCode::create([
            'user_id' => $admin->id,
            'code' => $adminReferralCode,
        ]);

       
    }
}


