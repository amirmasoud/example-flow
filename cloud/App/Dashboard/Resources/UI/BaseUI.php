<?php

namespace App\Dashboard\Resources\UI;

use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseUI extends JsonResource
{
    public static $wrap = null;
}
