<?php

namespace App\Http\Controllers;

use App\Enums\ParcelSizes;
use App\Models\Parcel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParcelController extends Controller
{

    public function getParcelByNumber(Parcel $parcel)
    {
        $parcelWithUser = $parcel->load('user');

        return response(json_encode($parcelWithUser), 200);
    }

    public function addParcel(Request $request){

        if($request->isJson()){
            try{
                $sizes = array_column(ParcelSizes::cases(), 'value');

                $attributes = $request->validate([
                    'size' => ['required', Rule::in($sizes)],
                    'user_id' => ['required', Rule::exists('users', 'id')]
                ]);

            }
            catch (Exception $exception){
                return response(json_encode(["Validation error" => $exception->getMessage()]), 400);
            }

            $attributes['parcel_number'] = $this->generateParcelNumber();

            $parcel = Parcel::create($attributes);
            $parcel->save();

            $parcelWithUser = $parcel->load('user');

            return response($parcelWithUser, 200);
        }
        else{
            return response(json_encode('Error: Data must be JSON formatted!'), 400);
        }

    }

    private function generateParcelNumber(): string
    {
        $prefix = uniqid();
        $hash = md5($prefix);
        return substr($hash, 0, 10);
    }
}
