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
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'whatsapp_number' => '1234567890',
            'binance_pay_id' => 'binance_id_123',
            'status' => 'active',
            'role' => 'admin',
            'referred_by' => null, // No referral code
        ]);

        // Generate referral code for the Admin
        $adminReferralCode = strtoupper(Str::random(6));
        ReferralCode::create([
            'user_id' => $admin->id,
            'code' => $adminReferralCode,
        ]);

        // Create Agent User
        $agent = User::create([
            'name' => 'Agent User',
            'email' => 'agent@example.com',
            'password' => Hash::make('password'),
            'whatsapp_number' => '1234567891',
            'binance_pay_id' => 'binance_id_124',
            'status' => 'active',
            'role' => 'agent',
            'referred_by' => $adminReferralCode, // Referred by Admin
        ]);

        // Generate referral code for Agent
        $agentReferralCode = strtoupper(Str::random(6));
        ReferralCode::create([
            'user_id' => $agent->id,
            'code' => $agentReferralCode,
        ]);

        // Create Regular User
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'whatsapp_number' => '1234567892',
            'binance_pay_id' => 'binance_id_125',
            'status' => 'active',
            'role' => 'user',
            'referred_by' => $agentReferralCode, // Referred by Agent
        ]);

        // Generate referral code for Regular User
        $userReferralCode = strtoupper(Str::random(6));
        ReferralCode::create([
            'user_id' => $user->id,
            'code' => $userReferralCode,
        ]);
    }
}


