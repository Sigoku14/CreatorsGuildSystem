<?php

use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profiles')->insert([
            [
                'user_id' => 'tester',
                'profile' => '',
                'user_area' => '25',
                'user_gender' => 'male',
                'user_birthday' => '1980-03-04',
                'user_sns' => '',
                'user_icon_path' => 'tester_icon.jpg',
                'user_updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'questmaker',
                'profile' => '',
                'user_area' => '09',
                'user_gender' => 'female',
                'user_birthday' => '1999-12-25',
                'user_sns' => '',
                'user_icon_path' => 'questmaker_icon.jpg',
                'user_updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'gamemaker',
                'profile' => '',
                'user_area' => '19',
                'user_gender' => 'male',
                'user_birthday' => '2000-01-01',
                'user_sns' => '',
                'user_icon_path' => '',
                'user_updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'nier',
                'profile' => '',
                'user_area' => '27',
                'user_gender' => 'female',
                'user_birthday' => '2017-02-23',
                'user_sns' => '',
                'user_icon_path' => 'nier_icon.jpg',
                'user_updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'hikaru',
                'profile' => '',
                'user_area' => '30',
                'user_gender' => 'male',
                'user_birthday' => '1996-06-14',
                'user_sns' => '@Sigoku',
                'user_icon_path' => 'hikaru_icon.jpg',
                'user_updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'laravel',
                'profile' => '',
                'user_area' => '25',
                'user_gender' => 'male',
                'user_birthday' => '1976-11-12',
                'user_sns' => '',
                'user_icon_path' => '',
                'user_updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 'vue',
                'profile' => '',
                'user_area' => '22',
                'user_gender' => 'female',
                'user_birthday' => '1989-03-04',
                'user_sns' => '',
                'user_icon_path' => 'vue_icon.jpg',
                'user_updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }
}
