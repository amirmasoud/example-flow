<?php

namespace App\Dashboard\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'host' => $this->host,
            'status' => $this->status->label(),
            'deleted_at' => $this->deleted_at,
            'servers' => ServerResource::collection($this->whenLoaded('server')),
            'stacks' => StackResource::collection($this->whenLoaded('stack')),
        ];
    }
}
