<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'user_id' => 'tester',
                'penname' => 'プロテスター',
                'user_mail' => 'test@example.com',
                'user_password' => '$2y$10$JbHUZpl47yYmRQMp6bnjvumarHJjpCAjoyZ4ur41AXYseRNnfTGXa',
                'user_created_at' => date('Y-m-d H:i:s'),
                'user_updated_at' => date('Y-m-d H:i:s'),
                'user_status' => '1',
            ],
            [
                'user_id' => 'questmaker',
                'penname' => '仕事依頼人',
                'user_mail' => 'quest@example.com',
                'user_password' => '$2y$10$JbHUZpl47yYmRQMp6bnjvumarHJjpCAjoyZ4ur41AXYseRNnfTGXa',
                'user_created_at' => date('Y-m-d H:i:s'),
                'user_updated_at' => date('Y-m-d H:i:s'),
                'user_status' => '1',
            ],
            [
                'user_id' => 'gamemaker',
                'penname' => 'ゲームのことならお任せ',
                'user_mail' => 'game@example.com',
                'user_password' => '$2y$10$JbHUZpl47yYmRQMp6bnjvumarHJjpCAjoyZ4ur41AXYseRNnfTGXa',
                'user_created_at' => date('Y-m-d H:i:s'),
                'user_updated_at' => date('Y-m-d H:i:s'),
                'user_status' => '1',
            ],
            [
                'user_id' => 'nier',
                'penname' => 'ニーア',
                'user_mail' => 'nier@example.com',
                'user_password' => '$2y$10$JbHUZpl47yYmRQMp6bnjvumarHJjpCAjoyZ4ur41AXYseRNnfTGXa',
                'user_created_at' => date('Y-m-d H:i:s'),
                'user_updated_at' => date('Y-m-d H:i:s'),
                'user_status' => '1',
            ],
            [
                'user_id' => 'hikaru',
                'penname' => 'ひかる',
                'user_mail' => 'hikaru@example.com',
                'user_password' => '$2y$10$JbHUZpl47yYmRQMp6bnjvumarHJjpCAjoyZ4ur41AXYseRNnfTGXa',
                'user_created_at' => date('Y-m-d H:i:s'),
                'user_updated_at' => date('Y-m-d H:i:s'),
                'user_status' => '1',
            ],
            [
                'user_id' => 'laravel',
                'penname' => 'ララヴェル',
                'user_mail' => 'laravel@example.com',
                'user_password' => '$2y$10$JbHUZpl47yYmRQMp6bnjvumarHJjpCAjoyZ4ur41AXYseRNnfTGXa',
                'user_created_at' => date('Y-m-d H:i:s'),
                'user_updated_at' => date('Y-m-d H:i:s'),
                'user_status' => '1',
            ],
            [
                'user_id' => 'vue',
                'penname' => 'ビュ〜',
                'user_mail' => 'vue@example.com',
                'user_password' => '$2y$10$JbHUZpl47yYmRQMp6bnjvumarHJjpCAjoyZ4ur41AXYseRNnfTGXa',
                'user_created_at' => date('Y-m-d H:i:s'),
                'user_updated_at' => date('Y-m-d H:i:s'),
                'user_status' => '1',
            ],
        ]);
    }
}
