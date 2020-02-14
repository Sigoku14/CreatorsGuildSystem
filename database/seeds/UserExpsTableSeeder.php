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
                'exp' => '9000',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'questmaker',
                'exp' => '20001',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'gamemaker',
                'exp' => '15000',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'nier',
                'exp' => '30000',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'hikaru',
                'exp' => '70000',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'laravel',
                'exp' => '13000',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'vue',
                'exp' => '46000',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
