<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTpyeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cutomer_type')->insert([
            [
                'stand_for' => 'General Customer'
            ],
            [
                'stand_for' => 'Particular Client'
            ],
        ]);
    }
}
