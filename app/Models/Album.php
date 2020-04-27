<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Photo;

class Album extends Model {
    //se il nome della tabella è diversa e non è al plurale nel db dichiararla con: protected $table = 'album';
    //se la primary key della tabella non è id: protected $primaryKey = 'album_id'
    //in questo caso la primaryKey coincide con id
    protected $fillable = ['album_name', 'description', 'user_id'];

    public function getPathAttribute () {
        $url = $this->album_thumb;
        if(stristr($this->album_thumb,'http') === false) {
            $url = 'storage/'.$this->album_thumb;
        }
        return $url;
    }

    public function photos() {
        return $this->hasMany(Photo::class,'album_id', 'id');
    }
}
