<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\FavoritePetrolStationListResource;
use App\Http\Resources\PetrolStationListResource;
use App\Models\PetrolStation;
use App\Imports\PetrolStationImport;
use App\Models\FavoriteStation;
use App\Models\PetrolStationsPrice;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiController extends BaseController
{
    /**
     * Get All station
     *
     * @return \Illuminate\Http\Response
     */
    // public function getAllStation()
    // {
    //     try {
    //         $categories = PetrolStation::all();
    //         return $this->sendResponse($categories, 'Get successfully.');
    //     } catch (\Exception $e) {
    //         return $this->sendError($e->getMessage(), 500);
    //     }
    // }
    public function import(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'file' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(), 200);
            }
            Excel::import(new PetrolStationImport, request()->file('file'));
            return $this->sendResponse([], 'Import successfully.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    public function getNearByStations(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'latitude' => 'required',
                'longitude' => 'required',
                'user_id' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(), 200);
            }
            $latitude       =       $request->latitude;
            $longitude      =       $request->longitude;
            $data = DB::table('petrol_stations');
            $db               = DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                    * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $longitude . "))
                    + sin(radians(" . $latitude . ")) * sin(radians(latitude))) AS distance");
            $stations          =       $data->select("*",  $db);
            $stations          =       $stations->having('distance', '<', 50);
            $data       =       $stations;
            if (!empty($request->searchKeyword)) {
                $data->where('name', 'LIKE', "%{$request->searchKeyword}%") 
                ->orWhere('description', 'LIKE', "%{$request->searchKeyword}%");
            }
            if ($data->count() > 0) {
                $stations = $data->get();
                return $this->sendResponse(PetrolStationListResource::collection($stations), 'Data get successfully.');
            } else {
                return $this->sendResponse([], 'No data found.');
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    public function update_station_price(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(), 200);
            }
            $station = PetrolStationsPrice::where('p_station_id', $request->id)->first();
            if (empty($station)) {
                $station = new PetrolStationsPrice;
                $station->p_station_id = $request->id;
                $station->price = $request->price;
                $station->d_price = $request->d_price;
                $station->save();
            } else {
                $station->price = $request->price;
                $station->d_price = $request->d_price;
                $station->save();
            }
            $data['price'] =  $station->price ?? "";
            $data['d_price'] =  $station->d_price ?? "";
            return $this->sendResponse($data, 'Data updated successfully.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    public function getStationById(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(), 200);
            }
            $check = PetrolStation::where('id', $request->id)->first();
            if (empty($check)) {
                return $this->sendError("Petrol station not found", 401);
            }
            $station = PetrolStation::where('id', $request->id)->first();
            return $this->sendResponse(new PetrolStationListResource($station), 'Data get successfully.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }
    public function getPriceById(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(), 200);
            }
            $check = PetrolStationsPrice::where('p_station_id', $request->id)->first();
            if (empty($check)) {
                return $this->sendError("Petrol station price not found", 401);
            }
            $data['price'] = PetrolStationsPrice::where('p_station_id', $request->id)->first()->price;
            return $this->sendResponse($data, 'Data get successfully.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    public function addRemoveFavoriteStation(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'p_station_id' => 'required',
                'is_favorite' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(), 422);
            }
            $check = PetrolStation::where('id', $request->p_station_id)->first();
            if (empty($check)) {
                return $this->sendError("Petrol station not found", 401);
            }
            if ($request->is_favorite == 1) {
                $check = FavoriteStation::where('user_id', $request->user_id)->where('p_station_id', $request->p_station_id)->first();
                if(!empty($check)){
                    return $this->sendError("Already marked as favorite", 401);
                }
                $favorite = new FavoriteStation();
                $favorite->user_id = $request->user_id;
                $favorite->p_station_id = $request->p_station_id;
                $favorite->save();
                return $this->sendResponse($favorite, 'Petrol station marked as favorite.');
            }
            if ($request->is_favorite == 0) {
                $favorite = FavoriteStation::where('user_id', $request->user_id)->where('p_station_id', $request->p_station_id)->first();
                $favorite->delete();
                return $this->sendResponse($favorite, 'Petrol station marked as unfavorite.');
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }
    public function getMyFavoriteStation(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(), 422);
            }
            $favorite = FavoriteStation::where('user_id', $request->user_id);
            if ($favorite->count() > 0) {
                $favorite = $favorite->get();
                return $this->sendResponse(FavoritePetrolStationListResource::collection($favorite), 'Data get successfully.');
            } else {
                return $this->sendResponse([], 'No data found.');
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }
}
