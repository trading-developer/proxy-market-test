<?php

namespace App\Http\Resources;

use App\Models\Proxy;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Proxy
 */
class ProxyResource extends JsonResource
{
    public static $wrap = null;

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
            'ip' => $this->ip,
            'status' => $this->status,
            'port' => $this->port,
            'password' => $this->password,
            'login' => $this->login,
            'created_at' => $this->created_at,
            'provider' => ProviderResource::make($this->provider),
        ];
    }
}
