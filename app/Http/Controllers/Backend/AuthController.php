<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginIndex()
    {
        if (\auth()->check()){
            return redirect()->route('panel.home.index');
        }else{
            return view('Backend.Auth.login');
        }

    }

    public function loginProcess(Request $request)
    {
        $hasEmail = User::where('email',$request->email)->count('id');
        if ($hasEmail < 1){
            return response()->json(['statusCode' => 0, 'statusMessage' => 'Sistemde E-Posta Adresi Kayıtlı Değil']);
        }

        $arr = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1,
        ];
        if (Auth::attempt($arr,$request->has('rememberMe'))){
            return response()->json(['statusCode' => 1, 'statusMessage' => 'Bilgiler Doğru Yönlendiriliyorsunuz']);
        }else{
            return response()->json(['statusCode' => 0, 'statusMessage' => 'Hatalı Şifre Girdiniz']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('panel.auth.login.index');
    }


}
