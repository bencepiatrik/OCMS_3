<?php

namespace CustomSlack\Chat\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use CustomSlack\Chat\Models\User;
use http\Client\Response;
use Input;
use Hash;
use Str;
use Session;

class AuthController extends Controller
{
// Register a new user
    protected $currentUser;

    public $requiredPermissions = ['customslack.chat.authcontroller'];
public function register()
{
    $username = Input::get('username');
    $email = Input::get('email');
    $password = Input::get('password');

    $user = new User;
    $user->username = $username;
    $user->email = $email;
    $user->password = $password;
    $user->token = Str::random(60);
    $user->save();

    return redirect('/login')->with('message', 'Registration successful! Please log in.');
}

// Log in the user
    public function login()
    {
        $username = Input::get('username');
        $password = Input::get('password');

        // Retrieve the user based on the input
        $user = User::where('username', $username)->first();
        $asd = User::all();
        if ($user && Hash::check($password, $user->password)) {
            Session::start();
            Session::put('user', $user->id);
            Session::save();
           // dd(Session::all());

            // Redirect to the homepage after login
            return redirect('/home');
        } else {
            // If login fails, redirect to login page with an error
            return redirect('/login')->with('error', 'Invalid credentials');
        }
    }


// Log out the user
    public function logout()
    {
    //Session::forget('user');
    //return redirect('/login')->with('message', 'Logged out successfully');
    }

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('CustomSlack.Chat', 'chat', 'authcontroller');
    }



}
