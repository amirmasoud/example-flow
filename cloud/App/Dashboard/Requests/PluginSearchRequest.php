<?php

namespace App\Dashboard\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PluginSearchRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'search' => ['sometimes'],
        ];
    }
}
