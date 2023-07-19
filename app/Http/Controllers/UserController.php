<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Exception\ValidationException;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Unique;
use PHPUnit\Exception;

class UserController extends Controller
{

    public function listAllUsers(){
        try{
            $users = User::all();

            http_response_code(200);
            return json_encode($users);
        }
        catch (Exception $exception){
            http_response_code(500);
            return json_encode('Error' . $exception->getMessage());
        }

    }

    public function addUser(Request $request)
    {

        if($request->isJson()){

            try{
                $attributes = $request->validate([
                    'first_name' => ['required', 'string'],
                    'last_name' => ['required', 'string'],
                    'password' => ['required', 'string'],
                    'email_address' => ['required', 'email', 'unique:users'],
                    'phone_number' => ['string', 'unique:users']
                ]);
            }
            catch (\Exception $exception){
                return response(json_encode(["Validation error" => $exception->getMessage()]), 400);
            }

            $attributes['password'] = bcrypt($attributes['password']);

            $user = User::create($attributes);
            $user->save();

            return response($user, 200);
        }
        else{
            return response(json_encode('Error: Data must be JSON formatted!'), 400);
        }
    }
}
