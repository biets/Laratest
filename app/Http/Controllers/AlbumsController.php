<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumRequest;
use App\Http\Requests\AlbumUpdateRequest;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlbumsController extends Controller
{

    public function __construct()
    {
        //un altro modo per autenticare i controller può essere quello di raggruppare le route senza il middleware e
        //dichiararlo qui dentro
        //$this->middleware('auth')->only(['nomi delle funzioni','create','edit'])
        //$this->middleware('auth')->except(['nome della funzione da escludere'])
    }

    public function index(Request $request) {
        $queryBuilder = Album::orderBy('id', 'DESC')->withCount('photos');
        $queryBuilder->where('user_id', Auth::user()->id);

        if($request->has('id')) {
            $queryBuilder->where('id','=', $request->input('id'));
        }
        if($request->has('album_name')) {
            $queryBuilder->where('album_name','like', '%'.$request->input('album_name').'%');
        }

        $albums = $queryBuilder->paginate(env('ALBUM_PER_PAGE'));
        return view('albums.albums', ['albums' => $albums]);
    }

    public function create() {
        $album = new Album();
        return view('albums.create', ['album' => $album]);
    }

    public function save(AlbumRequest $request)
    {
        $album = new Album();
        $album->album_name = $request->input('name');
        $album->description = $request->input('description');
        $album->user_id = $request->user()->id;
        $album->album_thumb = '';

        $res = $album->save();
        //dd($album->id);
        if($res) {
            if ($this->processFile($album->id, $request, $album)) {
                $album->save();
            }
        }


        /*
        $res = Album::create(
            ['album_name' => request()->input('name'),
                'description' => request()->input('description'),
                'user_id' => request()->input('user_id')
            ]);*/
        $message = $res ? 'Album '.request()->input('name').' inserito ':'Album '.request()->input('name').' non inserito ';
        session()->flash('message', $message);
        return redirect()->route('albums');
    }

    public function show($id) {
        $sql = "SELECT * FROM albums WHERE id=:id ";

        return DB::select($sql, ['id'=> $id]);

    }

    public function edit($id) {

        $album = Album::find($id);
        /*Per proteggere l'edit da utenti diversi
            oppure è possibile farlo con i gate in authserviceProvider.php
         * if($album->user->id !== Auth::user()->id) {
            abort(401, 'Unauthorized');
        }
        Metodo autorizzazione con i gat
        if(Gate::denies('manage-album', $album)) {
            abort(401, 'Unauthorized');
        }
        Metodo con le policy:
        */
        //altro metodo: Auth::user()->can('update', $album);

        $this->authorize('update', $album);

        return view('albums.editalbum')->with('album', $album);


        //DB::table('albums')->where('id');
        //$sql ="SELECT album_name, description, id FROM albums WHERE id=:id";
        //$album = DB::select($sql, ['id'=> $id]);
    }

    public function test($id) {
        return "ID".$id;
    }
    public function store($id, AlbumUpdateRequest $req){
        $album = Album::find($id);
        $this->authorize('update', $album);
        /*
        if(Gate::denies('manage-album', $album)) {
            abort(401, 'Unauthorized');
        }*/


        $album->album_name = $req->input('name');
        $album->description = $req->input('description');

        $this->processFile($id, $req,$album);

        $res = $album->save();
        /*
        $res = Album::where('id', $id)->update(
            ['album_name' => request()->input('name'),
                'description' => request()->input('description')]
        );*/
        $message = $res ? 'Album id: '.$id.' aggiornato ':'Album id: '.$id.' non aggiornato ';
        session()->flash('message', $message);
        return redirect()->route('albums');
    }

    public function delete(Album $album) {

        $thumbnail = $album->album_thumb;
        $disk = config('filesystem.default');
        $res = $album->delete();

        if($res) {
            if($thumbnail && Storage::disk($disk)->has($thumbnail)) {
                Storage::disk($disk)->delete($thumbnail);
            }

        }
        if(request()->ajax()) {
            return ' ' . $res;
        }else{
            return redirect()->route('albums');
        }
        //return Album::find($id)->delete();
        //return Album::where('id', $id)->delete();
    }

    /**
     * @param Request $req
     * @param $id
     * @param $album
     */
    public function processFile($id, Request $req, &$album): bool
    {
        if(!$req->hasFile('album_thumb')) {
            return false;
        }

        $file = $req->file('album_thumb');

        if(!$file->isValid()) {
            return false;
        }

        $fileName = $id . '.' . $file->extension();
        $file->storeAs(env('ALBUM_THUMB_DIR'), $fileName);
                //$fileName = $file->store(env('ALBUM_THUMB_DIR'));
        $album->album_thumb = env('ALBUM_THUMB_DIR') . '/' . $fileName;

        return true;
    }

    public function getImages(Album $album) {

        $images = Photo::where('album_id', $album->id)->latest()->paginate(env('IMG_PER_PAGE'));
        //$images = Photo::where('album_id', $album->id)->latest()->paginate(20);
        return view('images.albumImages', compact('album','images'));
    }



    /* Chiamate al DB con query grezze
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
        $sql.= ' ORDER BY id DESC';
        $albums = DB::select($sql, $where);
        return view('albums.albums', ['albums' => $albums]);
    }

    public function create() {
        return view('albums.create');
    }

    public function save() {
        $data = request()->only(['name', 'description']);
        $data['user_id'] = 1;
        $sql = 'INSERT INTO albums (album_name, description, user_id) ';
        $sql.= ' VALUES (:name, :description, :user_id)';
        $res = DB::insert($sql, $data);
        $message = $res ? 'Album '.$data['name'].' inserito ':'Album '.$data['name'].' non inserito ';
        session()->flash('message', $message);
        return redirect()->route('albums');
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
    }*/

}
