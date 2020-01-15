<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use JWTAuth;

class RegisterController extends Controller
{
    

    use RegistersUsers;

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function register(Request $request)
       {

           $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ];

            $customMessages = [
                'email.unique' => 'Un compte déjà éxistant avec cet email.',
                'password.min' => 'Le mot de passe doit contenir 6 caractères au minimum',

            ];
             $this->validate($request, $rules, $customMessages);
            $user = new User;
            $user->email = $request->email;
            $user->name = $request->name;
            $user->password = bcrypt($request->password);
            $user->save();
            return response([
                'status' => 'success',
                'data' => $user
               ], 200);
 }
}
