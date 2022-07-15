<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(UserRegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        auth()->login($user);
        return redirect()->route('home')->with('message', 'User created successfully!');
    }
    public function register()
    {
        return view('users.register');
    }
    public function loginForm()
    {
        return view('users.login');
    }
    public function login(UserLoginRequest $request)
    {
        $data = $request->validated();
        if (auth()->attempt($data)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('message', 'User logged in successfully!');
        }
        return redirect()->back()->withErrors(['message' => 'Invalid credentials!']);
    }
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('message', 'User logged out successfully!');
    }
}
