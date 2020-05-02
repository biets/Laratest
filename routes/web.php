<?php

use Illuminate\Support\Facades\Route;
use App\Models\Album;
use App\Models\Photo;
use App\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'GalleryController@index')->name('gallery.albums');

Route::get('welcome/{name?}/{lastname?}/{age?}', 'HomeController@index')->where([
    'name'=> '[a-zA-Z]+',
    'lastname'=> '[a-zA-Z]+',
    'age'=>'[0-9]{1,3}'
]);


// USERS

Auth::routes();


Route::group(
    [
        'middleware'=>'auth',
        'prefix' => 'dashboard'
    ],
    function(){
        Route::get('/', 'AlbumsController@index')->name('albums');

        // ALBUMS
        //Route::get('/home', 'AlbumsController@index');
        Route::get('/albums', 'AlbumsController@index')->name('albums');
        Route::get('/albums/create', 'AlbumsController@create')->name('albums.create');
        Route::post('/albums', 'AlbumsController@save')->name('albums.save');
        Route::patch('/albums/{id}', 'AlbumsController@store')->name('album.store');
        Route::get('/albums/{id}/edit', 'AlbumsController@edit')->where('id', '[0-9]+')->name('album.edit');
        Route::get('/albums/{id}', 'AlbumsController@show')->where('id', '[0-9]+');
        Route::get('/albums/{album}/images', 'AlbumsController@getImages')->name('albums.getImages');
        Route::delete('/albums/{album}', 'AlbumsController@delete')->name('album.delete');;


        //IMAGES

        Route::resource('/photos', 'PhotosController');
        Route::get('/photos/{photo}/edit', 'PhotosController@edit')->name('photos.edit');
        //Route::get('/photos', function () { return Photo::all(); });



        Route::get('/users', function () {
            return User::all();
        });

        Route::get('usersnoalbum', function() {
            $usersnoalbum = DB::table('users as u')->leftjoin('albums as a', 'u.id','=', 'a.user_id')
                ->select('u.id','name','email')->whereNull('album_name')->get();
            return $usersnoalbum;
        });

    });

//Gallery

Route::group(
    ['prefix'=>'gallery'],
    function(){

        Route::get('albums', 'GalleryController@index')->name('gallery.albums');
        Route::get('albums/category/{category}', 'GalleryController@showAlbumByCategory')->name('gallery.albums.category');
        Route::get('/', 'GalleryController@index')->name('gallery.albums');
        Route::get('album/{album}/images', 'GalleryController@showAlbumImages')->name('gallery.album.images');
    });


Route::resource('categories', 'AlbumCategoryController');





/*
Route::get('/{name?}/{lastname?}/{age?}', function($name='', $lastname='', $age=0) {
        return '<h1>Hello world '.$name.' '.$lastname.' you are '.$age.' old</h1>';
    })->where([
        'name'=> '[a-zA-Z]+',
        'lastname'=> '[a-zA-Z]+',
        'age'=>'[0-9]{1,3}'
    ]);

     Questo è un possibile metodo per controllare i dati passati nell'uri oppure si utilizza un'array
})->where('name', '[a-zA-Z]+')
    ->where('lastname','[a-zA-Z]+');  */


//Route::get('/{name?}/{surname?}/{age?}', function($name, $surname, $age) {
//    return "nome ".$name." cognome ".$surname." età ".$age;
//});


