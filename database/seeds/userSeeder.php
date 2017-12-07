<?php

use Illuminate\Database\Seeder;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => "kskevin",
            'email' => 'ksk@gmail.com',
            'password' => bcrypt('goygoy08'),
            'status' => 0,
        ]);
    }
}
