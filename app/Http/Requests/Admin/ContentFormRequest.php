<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class ContentFormRequest extends Request
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
            'key' => 'required|unique:contents',
            'cat_id' => 'required',
            'title' => 'required',
            'content' => 'required|array',
            'state' => 'required|boolean'
        ];
    }
}
