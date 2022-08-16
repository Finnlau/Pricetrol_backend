<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
class PetrolStation extends Model
{
    use HasFactory, HasApiTokens;
    protected $fillable = ['query', 'name', 'site', 'type', 'subtypes', 'category', 'phone', 'full_address', 'borough', 'street', 'city', 'postal_code', 'state', 'us_state', 'country', 'country_code', 'latitude', 'longitude', 'time_zone', 'plus_code', 'rating', 'reviews', 'reviews_link', 'reviews_tags', 'reviews_per_score', 'reviews_per_score_1', 'reviews_per_score_2', 'reviews_per_score_3', 'reviews_per_score_4', 'reviews_per_score_5', 'photos_count', 'photo', 'street_view', 'located_in', 'working_hours', 'other_hours', 'popular_times', 'business_status', 'about', 'rang', 'posts', 'logo', 'description', 'verified', 'owner_id', 'owner_title', 'owner_link', 'reservation_links', 'booking_appointment_link', 'menu_link', 'order_links', 'location_link', 'place_id', 'google_id', 'cid', 'reviews_id', 'located_google_id', 'location_link'];
}
