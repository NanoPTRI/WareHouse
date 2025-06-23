<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login',[
            'title' => 'Page Login'
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' =>  'required', 'alpha_dash','string',
            'password' => 'required|string|min:5',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors([
                'ChekaMatch' => 'Username atau Password salah',
            ]);
        }

        $validator = $validator->validated();
        try {
            $user = User::where('username', $validator['username'])->where('Active',true)->firstOrFail();

            if ($user){
//                if (strtoupper($user->Password) == strtoupper(md5($validator['password']))){
//                    $request->session()->regenerate();
//                    Auth::login($user);
//                    return redirect()->intended('Admin');
//                }
                if (Hash::check($validator['password'], $user->password)){
                    $request->session()->regenerate();
                    Auth::login($user);
                    if ($user->role ==  Rules::Administrator->value || $user->role ==  Rules::Supervisor->value){
                        return redirect()->intended('Admin');

                    }
                    return redirect()->intended('/');

                }
                return redirect()->back()->withErrors(['ChekaMatch' => 'Username atau Password salah']);
            }
            return redirect()->back()->withErrors(['ChekaMatch' => 'Cek Status User Active']);

        }catch (Exception $e){
            Log::debug($e->getMessage());
            return redirect()->back()->withErrors(['ChekaMatch' => 'Username atau Password salah']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
