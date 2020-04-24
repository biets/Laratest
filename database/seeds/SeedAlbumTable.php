<?php

use Illuminate\Database\Seeder;

class SeedAlbumTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        factory(App\User::class, 30)->create();
    }
}
