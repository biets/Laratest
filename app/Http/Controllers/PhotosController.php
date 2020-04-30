<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    /**
     * Validazione campi
     * oppure con php artisan make:request AlbumRequest e si possono passare in altro modo
     * */

    protected $rules = [
      'album_id' => 'required|integer|exists:albums,id',
      'name' => 'required|unique:photos,name',
      'description' => 'required',
      'img_path' => 'required|image'
    ];

    protected $errorMessages = [
        'album_id.required' => 'Il campo album è obbligatorio',
        'name.required' => 'Il campo name è obbligatorio',
        'description.required' => 'Il campo description è obbligatorio',
        'img_path.required' => 'Il campo img_path è obbligatorio'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Photo::get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $id = $req->has('album_id')?$req->input('album_id') : null;
        $album = Album::firstOrNew(['id' => $id]);
        $photo = new Photo();
        $albums =$this->getAlbums();
        return view('images.editImage', compact('album','photo','albums'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       $this->validate($request, $this->rules, $this->errorMessages);
       $photo = new Photo();
       $photo->name = $request->input('name');
       $photo->description = $request->input('description');
       $photo->album_id = $request->input('album_id');
       $this->processFile($photo, $request);
       $photo->save();
       return redirect(route('albums.getImages', $photo->album_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        dd($photo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        $albums =$this->getAlbums();
        $album = $photo->album;

        return view('images.editImage', compact('album', 'photo', 'albums'));
    }

    public function getAlbums() {
        return Album::orderBy('album_name')->get();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        $this->validate($request, $this->rules, $this->errorMessages);
        $this->processFile($photo, $request);
        $photo->album_id = $request->album_id;
        $photo->name = $request->input('name');
        $photo->description = $request->input('description');
        $res = $photo->save();

        $message = $res ? 'Photo id: '.$photo->id.' aggiornato ':'Photo id: '.$photo->id.' non aggiornato ';
        session()->flash('message', $message);
        return redirect(route('albums.getImages', $photo->album_id));
        //return redirect()->route('photos.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        $res = $photo->delete();
        if($res) {
            $this->deleteFile($photo);
        }
        return $res;
        //return Photo::destroy($id);
    }

    /**
     * @param Request $req
     * @param $id
     * @param $photo
     */
    public function processFile(Photo &$photo, Request $req=null): bool
    {
        if(!$req->hasFile('img_path')) {
            return false;
        }

        $file = $req->file('img_path');
        if(!$file->isValid()) {
            return false;
        }
        $imgName = preg_replace('@[a-z0-9]i@','_', $photo->name);
        $fileName = $imgName. '.' . $file->extension();
        $file->storeAs(env('IMG_DIR').'/'.$photo->album_id.'/', $fileName);
        //$fileName = $file->store(env('ALBUM_THUMB_DIR'));
        $photo->img_path = env('IMG_DIR').'/'.$photo->album_id.'/'.$fileName;

        return true;
    }

    public function deleteFile(Photo $photo) {
        $disk = config ('filesystems.default');
        if($photo->img_path && Storage::disk($disk)->has($photo->img_path)) {
            return Storage::disk($disk)->delete($photo->img_path);
        }
        return false;
    }
}
