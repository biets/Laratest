<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumsController extends Controller
{
    public function index(Request $request) {
        $sql = 'Select * from albums WHERE 1=1 ';
        $where = [];
        if($request->has('id')) {
            $where['id'] = $request->get('id');
            $sql.= " AND id=:id";
        }
        if($request->has('album_name')) {
            $where['album_name'] = $request->get('album_name');
            $sql .= " AND album_name=:album_name";
        }

        $albums = DB::select($sql, $where);
        return view('albums.albums', ['albums' => $albums]);
    }

    public function create() {
        echo 'sono qui';
        /*$sql ="SELECT album_name, description, id FROM albums WHERE id=:id";
        $album = DB::select($sql, ['id'=> $id]);

        return view('albums.editalbum')->with('album', $album[0]);*/
    }

    public function show($id) {
        $sql = "SELECT * FROM albums WHERE id=:id ";

        return DB::select($sql, ['id'=> $id]);

    }

    public function edit($id) {
        $sql ="SELECT album_name, description, id FROM albums WHERE id=:id";
        $album = DB::select($sql, ['id'=> $id]);

        return view('albums.editalbum')->with('album', $album[0]);
    }

    public function store($id, Request $req){
        $data = request()->only(['name', 'description']);
        $data['id'] = $id;
        $sql = 'UPDATE albums SET album_name=:name, description=:description';
        $sql.= ' WHERE id=:id ';
        $res = DB::update($sql, $data);
        $message = $res ? 'Album id: '.$id.' aggiornato ':'Album id: '.$id.' non aggiornato ';
        session()->flash('message', $message);
        return redirect()->route('albums');
    }

    public function delete($id) {
        $sql = "DELETE FROM albums WHERE id=:id ";

        return DB::delete($sql, ['id'=> $id]);

        //return redirect()->back();
    }
}
