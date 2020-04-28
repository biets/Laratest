<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Photo;
use App\Models\Album;

class SeedPhotosTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $albums = Album::get();
        foreach ($albums as $album) {
            factory(Photo::class, 200)->create([
                'album_id' => $album->id
            ]);
        }

    }
}
