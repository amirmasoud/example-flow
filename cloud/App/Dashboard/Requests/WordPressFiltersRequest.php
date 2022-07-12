<?php

namespace App\Dashboard\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WordPressFiltersRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'theme_search' => ['sometimes'],
            'plugin_search' => ['sometimes'],
        ];
    }
}
