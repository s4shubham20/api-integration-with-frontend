<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginUserController extends Controller
{
    public function index()
    {

        return view('auth.login');
    }

    public function store(Request $request)
    {
        $response = Http::post('http://localhost/laravel_api/public/api/login',[
            'email' => $request->email,
            'password'  => $request->password
        ]);
        $result = json_decode((string) $response->getBody(), true);
        if(isset($result['message'])){
            session()->put('access_token', $result['authorization']['token']);
            session()->flash('success', 'You have successfully login !');
            return response()->json($result);
        }else{
            return response()->json($result);
        }
    }

    public function userdetails()
    {
        $token = session()->get('access_token');
        $response = Http::withToken($token)->get('http://localhost/laravel_api/public/api/users');
        $result = json_decode((string) $response->getBody(), true);
        return $result;
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login')->with('success', 'You have successfully logout !');

    }
}
