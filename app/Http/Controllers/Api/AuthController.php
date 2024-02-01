<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Auth;
use App\models\User;
use Laravel\Sanctum\HasApiTokens;


class AuthController extends BaseController
{
   public function register(Request $request){

    $validate = validator::make($request->all(),[

        'name' => 'required',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:6',
        'confirm_password' => 'required|same:password',
        
    ]);

    if($validate->fails()){

        return $this->sendError('validation Error', $validate->errors());
    }
    $password = bcrypt($request->password);
    $user = User::create([ 
        'name'=> $request->name,
        'email'=> $request->email,
        'password' => $password,
    ]);  

    $success['token'] = $user->createToken('Restapi')->plainTextToken;
    $success['name'] = $user->name;

    return $this->sendResponse($success,'user registered successfully');
   }

   public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email|max:255|exists:users",
            "password" => "required|min:6",
        ]);

        if ($validator->fails()) {
            return $this->sendError('validation error', $validator->errors());
        }

       if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

    $user = Auth::user(); // Use auth() helper to access authenticated user

    
   $success['token'] = $user->createToken('Restapi')->plainTextToken;
    $success['name'] = $user->name;

    
     return $this->sendResponse($success, 'logged in successfully');
}
  else {
             return $this->sendError('unauthorized', ['error' => 'unauthorized user']);
         }
     }
 }
