<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChannelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('channels')->insert([
            [
                'channel_id' => 1,
                'name' => 'LTV1',
            ],
            [
                'channel_id' => 2,
                'name' => 'LTV7',
            ],
            [
                'channel_id' => 3,
                'name' => 'LSM',
            ]
        ]);
    }
}
