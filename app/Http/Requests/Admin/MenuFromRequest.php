<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class MenuFromRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'state' => 'required',
            'content_id' => 'required_without_all:cat_id,raw_path',
            'cat_id' => 'required_without_all:content_id,raw_path',
            'raw_path' => 'required_without_all:content_id,cat_id'
        ];
    }
}
