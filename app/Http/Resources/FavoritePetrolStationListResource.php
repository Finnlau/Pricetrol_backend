<?php

namespace App\Http\Resources;

use App\Models\FavoriteStation;
use App\Models\PetrolStationsPrice;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoritePetrolStationListResource extends JsonResource
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
            'p_station_id' => $this->p_station_id,
            'query' => $this->petrolStation->query,
            'name' => $this->petrolStation->name,
            'phone' => $this->petrolStation->phone ?? "",
            'full_address' => $this->petrolStation->full_address,
            'street' => $this->petrolStation->street ?? "",
            'city' => $this->petrolStation->city ?? "",
            'postal_code' => $this->petrolStation->postal_code ?? "",
            'state' => $this->petrolStation->state ?? "",
            'photo' => $this->petrolStation->photo  ?? "",
            'price' => PetrolStationsPrice::where('p_station_id', $this->p_station_id)->first()->price ?? "",
            'd_price' => PetrolStationsPrice::where('p_station_id', $this->p_station_id)->first()->d_price ?? "",
            'latitude' => $this->petrolStation->latitude  ?? "",
            'longitude' => $this->petrolStation->longitude  ?? "",
            'distance' => round($this->petrolStation->distance)."km",
            'favorite_count' => FavoriteStation::where('p_station_id', $this->p_station_id)->count()
        ];
    }
}
