<?php

namespace App\Dashboard\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'ip' => $this->ip,
            'port' => $this->port,
            'ram' => $this->ram,
            'ram_unit' => $this->ram_unit,
            'cpu' => $this->cpu,
            'disk' => $this->disk,
            'disk_type' => $this->disk_type,
            'disk_unit' => $this->disk_unit,
            'os' => $this->os,
            'os_version' => $this->os_version,
            'status' => $this->status,
            'notes' => $this->notes,
        ];
    }
}
