<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            GenresTableSeeder::class
        );
        $this->call(
            LanksTableSeeder::class
        );
        $this->call(
            UsersTableSeeder::class
        );
        $this->call(
            ProfilesTableSeeder::class
        );
        $this->call(
            QuestsTableSeeder::class
        );
        $this->call(
            UserExpsTableSeeder::class
        );
    }
}
