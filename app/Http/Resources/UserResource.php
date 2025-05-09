<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nip' => $this->nip,
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->gender,
            'address' => $this->address,
            'photo' => $this->photo ? $this->photo :
                    'https://akcdn.detik.net.id/visual/2021/09/08/karina-aespa-4_43.jpeg?w=720&q=90',
            'office' => $this->office->name,
            'office_lat' => $this->office->lat,
            'office_long' => $this->office->long,
        ];
    }
}
