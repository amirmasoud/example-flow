<?php

namespace App\Dashboard\Requests;

use Domain\Sites\Enums\DiskTypeEnum;
use Domain\Sites\Enums\DiskUnitEnum;
use Domain\Sites\Enums\OsFlavorEnum;
use Domain\Sites\Enums\RamUnitEnum;
use Domain\Sites\Enums\ServerStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ServerRequest extends FormRequest
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
            'ip' => ['required'],
            'port' => ['required'],
            'ram' => ['required'],
            'ram_unit' => ['required', new Enum(RamUnitEnum::class)],
            'cpu' => ['required'],
            'disk' => ['required'],
            'disk_type' => ['required', new Enum(DiskTypeEnum::class)],
            'disk_unit' => ['required', new Enum(DiskUnitEnum::class)],
            'os' => ['required', new Enum(OsFlavorEnum::class)],
            'os_version' => ['required'],
            'status' => ['required', new Enum(ServerStatusEnum::class)],
            'notes' => ['required'],
        ];
    }
}
