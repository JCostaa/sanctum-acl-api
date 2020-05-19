<?php

namespace Laralife\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    public function authorize()
    {
        $ability = $this->method() . '|' . $this->route()->uri;

        return $this->user()->can($ability);
    }

    public function rules()
    {
        return [
            'verb' => 'required|string',
            'uri' => 'required|string',
        ];
    }
}
