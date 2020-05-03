<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumCategory;
use App\Models\Photo;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index() {
        $albums = Album::latest()->with('categories')->get();

        //foreach ($albums as $album) {
        //  return $album->categories;
        //}

        return view('gallery.albums')->with('albums', $albums);
    }

    public function showAlbumsByCategory(AlbumCategory $category) {
        $albums = $category->albums;

        return view('gallery.albums')->with('albums',$category->albums);
    }

    public function showAlbumImages(Album $album) {
        return view('gallery.images',
            ['images' => Photo::whereAlbumId($album->id)->latest()->get(),
            'album' => $album]
        );
    }
}
