<?php

namespace App\Dashboard\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StackRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'price' => ['required'],
            'properties' => ['required'],
            'type' => ['required'],
        ];
    }
}
