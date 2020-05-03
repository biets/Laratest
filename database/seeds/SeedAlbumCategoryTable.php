<?php

use App\Models\AlbumCategory;
use Illuminate\Database\Seeder;

class SeedAlbumCategoryTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats = ['abstract',
            'animals',
            'business',
            'cats',
            'city',
            'food',
            'fashion',
            'people',
            'nature',
            'sports'
        ];

        foreach ($cats as $cat) {
            $u = \App\User::inRandomOrder()->first();
            AlbumCategory::create([
                'category_name' => $cat,
                'user_id' => $u->id
            ]);

        }
    }
}
