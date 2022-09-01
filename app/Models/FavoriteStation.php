<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteStation extends Model
{
    use HasFactory;
    public function petrolStation()
  {
    return $this->hasOne('App\Models\PetrolStation', 'id', 'p_station_id');
  }
}
