<?php

namespace App\Imports;

use App\Models\PetrolStation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PetrolStationImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PetrolStation([
            'query'     => $row['query'],
            'name'    => $row['name'], 
            'site' => $row['site'],
            'type' => $row['type'],
            'subtypes' => $row['subtypes'],
            'category' => $row['category'],
            'phone' => $row['phone'],
            'full_address' => $row['full_address'],
            'borough' => $row['borough'],
            'street' => $row['street'],
            'city' => $row['city'],
            'postal_code' => $row['postal_code'],
            'state' => $row['state'],
            'us_state' => $row['us_state'],
            'country' => $row['country'],
            'country_code' => $row['country_code'],
            'latitude' => $row['latitude'],
            'longitude' => $row['longitude'],
            'time_zone' => $row['time_zone'],
            'plus_code' => $row['plus_code'],
            'rating' => $row['rating'] ?? 0,
            'reviews ' => $row['reviews'] ?? 0,
            'reviews_link' => $row['reviews_link'],
            'reviews_tags' => $row['reviews_tags'],
            'reviews_per_score' => $row['reviews_per_score'],
            'reviews_per_score_1' => $row['reviews_per_score_1'] ?? 0,
            'reviews_per_score_2' => $row['reviews_per_score_2'] ?? 0,
            'reviews_per_score_3' => $row['reviews_per_score_3'] ?? 0,
            'reviews_per_score_4' => $row['reviews_per_score_4'] ?? 0,
            'reviews_per_score_5' => $row['reviews_per_score_5'] ?? 0,
            'photos_count' => $row['photos_count'] ?? 0,
            'photo' => $row['photo'],
            'street_view' => $row['street_view'],
            'located_in' => $row['located_in'],
            'working_hours' => $row['working_hours'],
            'working_hours_old_format' => $row['working_hours_old_format'],
            'other_hours' => $row['other_hours'],
            'popular_times' => $row['popular_times'],
            'business_status' => $row['business_status'],
            'about' => $row['about'],
            'rang' => $row['range'],
            'posts' => $row['posts'],
            'logo' => $row['logo'],
            'description' => $row['description'],
            'verified' => $row['verified'],
            'owner_id' => $row['owner_id'],
            'owner_title' => $row['owner_title'],
            'owner_link' => $row['owner_link'],
            'reservation_links' => $row['reservation_links'],
            'booking_appointment_link' => $row['booking_appointment_link'],
            'menu_link' => $row['menu_link'],
            'order_links' => $row['order_links'],
            'location_link' => $row['location_link'],
            'place_id' => $row['place_id'],
            'google_id' => $row['google_id'],
            'cid' => $row['cid'],
            'reviews_id' => $row['reviews_id'],
            'located_google_id' => $row['located_google_id'],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => null,
            'deleted_at' => null,
        ]);
    }
}
