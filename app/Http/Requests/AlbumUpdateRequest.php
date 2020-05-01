<?php

namespace App\Http\Requests;

use App\Models\Album;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class AlbumUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $album = Album::find($this->id);

        //$this->authorize('update', $album);

        /*if(Gate::denies('manage-album', $album)) {
            return false;
        }*/
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param $id
     * @return array
     */
    public function rules()
    {
        return [

            'name' => 'required|unique:albums,album_name,'.$this->id,
            'description' => 'required',
            //'user_id' => 'required'
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Il nome è obbligatorio',
            'description.required' => 'la descrizione è obbligatoria',
        ];
    }
}
