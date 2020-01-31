<?php

use Illuminate\Database\Seeder;

class LanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lanks')->insert([
            [
                'lank_id' => '1',
                'lank_name' => 'Copper',
                'lank_min_score' => '0',
                'lank_max_score' => '999',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'lank_id' => '2',
                'lank_name' => 'Silver',
                'lank_min_score' => '1000',
                'lank_max_score' => '2499',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'lank_id' => '3',
                'lank_name' => 'Gold',
                'lank_min_score' => '2500',
                'lank_max_score' => '4999',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'lank_id' => '4',
                'lank_name' => 'Platina',
                'lank_min_score' => '5000',
                'lank_max_score' => '8499',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'lank_id' => '5',
                'lank_name' => 'Adamant',
                'lank_min_score' => '8500',
                'lank_max_score' => '12999',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
