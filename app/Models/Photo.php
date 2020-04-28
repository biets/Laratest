<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public function album(){

        return $this->belongsTo(Album::class);
        //$this->belongsTo(Album::class, 'album_id', '');
    }
    /**
    Aggiunge al path la cartella /storage
    */
    public function getPathAttribute () {
        $url = $this->img_path;
        if(stristr($url,'http') === false) {
            $url = 'storage/'.$this->img_path;
        }
        return $url;
    }
    //stessa cosa della funzione precedente ma in modo diverso
    public function getImgPathAttribute ($value) {
        if(stristr($value,'http') === false) {
            $value = 'storage/'.$value;
        }
        return $value;
    }
}
