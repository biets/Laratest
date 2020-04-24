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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate;
        Album::truncate;
        Photos::truncate;
        $this->call(SeedUserTable::class);
        $this->call(SeedAlbumTable::class);
        $this->call(SeedPhotosTable::class);
    }
}
