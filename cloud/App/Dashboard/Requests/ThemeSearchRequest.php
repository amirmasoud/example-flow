<?php

namespace App\Dashboard\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThemeSearchRequest extends FormRequest
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
