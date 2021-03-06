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
    public function getPathAttribute(){
        $url = $this->attributes['img_path'];
        if(stristr($url ,'http') === false){
            $url = 'storage/'.$url;
        }
        return $url;
    }
    //stessa cosa della funzione precedente ma in modo diverso così quando richiamo img_path è già formattatato correttamente
    public function getImgPathAttribute($value){

        if(stristr($value ,'http') === false){
            $value = 'storage/'.$value;
        }
        return $value;
    }
    //stesso principio di prima, per mettere sempre la prima lettera maiuscola quando setto il nome
    public function setNameAttribute($value) {
        $this->attributes['name'] = strtoupper($value);
    }
}
