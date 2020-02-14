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
                'lank_max_score' => '20000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'lank_id' => '2',
                'lank_name' => 'Silver',
                'lank_min_score' => '20001',
                'lank_max_score' => '50000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'lank_id' => '3',
                'lank_name' => 'Gold',
                'lank_min_score' => '50001',
                'lank_max_score' => '90000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'lank_id' => '4',
                'lank_name' => 'Platina',
                'lank_min_score' => '90001',
                'lank_max_score' => '140000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'lank_id' => '5',
                'lank_name' => 'Adamant',
                'lank_min_score' => '140001',
                'lank_max_score' => '200000',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
