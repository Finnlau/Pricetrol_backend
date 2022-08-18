<?php

namespace App\Http\Resources;

use App\Models\FavoriteStation;
use App\Models\PetrolStationsPrice;
use Illuminate\Http\Resources\Json\JsonResource;

class PetrolStationListResource extends JsonResource
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
            'query' => $this->query,
            'name' => $this->name,
            'phone' => $this->phone ?? "",
            'full_address' => $this->full_address,
            'street' => $this->street ?? "",
            'city' => $this->city ?? "",
            'postal_code' => $this->postal_code ?? "",
            'state' => $this->state ?? "",
            'photo' => $this->photo  ?? "",
            'price' => PetrolStationsPrice::where('p_station_id', $this->id)->first()->price ?? "",
            'd_price' => PetrolStationsPrice::where('p_station_id', $this->id)->first()->d_price ?? "",
            'latitude' => $this->latitude  ?? "",
            'longitude' => $this->longitude  ?? "",
            'distance' => round($this->distance)."km",
            'favorite_count' => FavoriteStation::where('p_station_id', $this->id)->count()
        ];
    }
}
