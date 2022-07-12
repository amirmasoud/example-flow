<?php

namespace App\Dashboard\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $site
 */
class SiteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'unique:sites,name,'.$this->site?->id],
            'host' => ['required', 'unique:sites,host,'.$this->site?->id],
            'server_id' => ['required', 'exists:servers,id'],
            'stack_id' => ['required', 'exists:stacks,id'],
        ];
    }
}
