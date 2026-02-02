<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login()
    {
        // menampilkan halaman login
        return response()->view("user.login", [
            "title" => 'Halaman Login'
        ]);
    }

    public function doLogin(Request $request): Response|RedirectResponse
    {
        // action login
        $user = $request->input('user');
        $password = $request->input('password');

        // validate input
        if(empty($user) || empty($password)){
            return response()->view("user.login", [
                "title" => 'Halaman Login',
                "error" => "User or Password is Required"
            ]);
        }
    if($this->userService->login($user, $password)){
        $request->session()->put("user", $user);
        return redirect("/");
    }

    return response()->view("user.login", [
        "title" => "login",
        "error" => "User or Password is wrong"
    ]);

    }

    public function doLogout(Request $request): RedirectResponse
    {
        $request->session()->forget("user");
        return redirect('/home');
    }
}
