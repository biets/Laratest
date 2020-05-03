<?php

use App\Models\AlbumsCategory;
use App\Models\Album;
use App\Models\AlbumCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SeedAlbumTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Album::class, 10)->create()
            ->each(function ($album){
                $cats = AlbumCategory::inRandomOrder()->take(3)->pluck('id');

                $cats->each(function($cat_id) use ($album) {
                    AlbumsCategory::create(
                        [
                            'album_id' => $album->id,
                            'category_id' => $cat_id
                        ]
                    );
                });
            });
    }
}
