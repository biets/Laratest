<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
