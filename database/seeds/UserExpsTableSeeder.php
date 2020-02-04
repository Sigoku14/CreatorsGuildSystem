<?php

use Illuminate\Database\Seeder;

class UserExpsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_exps')->insert([
            [
                'user_id' => 'tester',
                'exp' => '1000',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'questmaker',
                'exp' => '20',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'gamemaker',
                'exp' => '150',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'nier',
                'exp' => '10000',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'hikaru',
                'exp' => '10000',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'laravel',
                'exp' => '3000',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'vue',
                'exp' => '6000',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
