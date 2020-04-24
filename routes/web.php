<?php

use Illuminate\Support\Facades\Route;
use App\Models\Album;

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

Route::get('/', 'HomeController@index');

Route::get('welcome/{name?}/{lastname?}/{age?}', 'HomeController@index')->where([
    'name'=> '[a-zA-Z]+',
    'lastname'=> '[a-zA-Z]+',
    'age'=>'[0-9]{1,3}'
]);

Route::get('/albums', function () {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    //Album::truncate();
    //Album::all();
});

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
