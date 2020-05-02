<?php

use App\Models\AlbumCategory;
use Illuminate\Database\Seeder;
use App\User;
use App\Models\Album;
use App\Models\Photo;

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
        User::truncate();
        Album::truncate();
        Photo::truncate();
        AlbumCategory::truncate();
        $this->call(SeedUserTable::class);
        $this->call(SeedAlbumCategoryTable::class);
        $this->call(SeedAlbumTable::class);
        $this->call(SeedPhotosTable::class);

    }
}
