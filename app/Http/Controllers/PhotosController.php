<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Photo::get;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        return $photo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    public function processFile($id, Photo &$photo, Request $req=null): bool
    {
        if(!$req->hasFile('img_paths')) {
            return false;
        }

        $file = $req->file('img_paths');

        if(!$file->isValid()) {
            return false;
        }

        $fileName = $id . '.' . $file->extension();
        $file->storeAs(env('IMG_DIR'), $fileName);
        //$fileName = $file->store(env('ALBUM_THUMB_DIR'));
        //$album->img_paths = env('IMG_DIR') . '/' . $fileName;

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
