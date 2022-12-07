<?php

namespace App\Http\Resources;

use App\Models\Provider;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Provider
 */
class ProviderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'title' => $this->title,
            'url' => $this->url,
            'created_at' => $this->created_at,
        ];
    }
}
