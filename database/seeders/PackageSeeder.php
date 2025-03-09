<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    public function run()
    {
        $packages = [
            ['name' => '10 USDT', 'price' => 10, 'commission' => 20],
            ['name' => '100 USDT', 'price' => 100, 'commission' => 40],
            ['name' => '1000 USDT', 'price' => 1000, 'commission' => 60],
            ['name' => '5000 USDT', 'price' => 5000, 'commission' => 70],
            ['name' => '10000 USDT', 'price' => 10000, 'commission' => 80],
            ['name' => '1L USDT', 'price' => 100000, 'commission' => 90],
            ['name' => '1M USDT', 'price' => 1000000, 'commission' => 90],
            ['name' => '5M USDT', 'price' => 5000000, 'commission' => 90],
            ['name' => '10M USDT', 'price' => 10000000, 'commission' => 90],
        ];

        // Insert packages into the database
        DB::table('packages')->insert($packages);
    }
}
