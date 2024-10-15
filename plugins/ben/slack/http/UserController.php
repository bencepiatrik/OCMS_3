<?php namespace Ben\Slack\Http;

use Illuminate\Http\Request;
use Ben\Slack\Models\User;

class UserController
{
    public function getAllUsers(Request $request)
    {
        $user = $request->input('authenticated_user');

        $users = User::where('id', '!=', $user->id)->get(['id', 'username', 'email']);

        return response()->json($users);
    }

    public function register(Request $request) // REVIEW - Logika tejto funkcie patrí do UserController (ale v http/controllers/) // FIX - Už opravené v predošlej commite
    {
        // REVIEW - všetká validácia čo takto robíš sa dá premiestniť do modelu a je to tak elegantnejšie / lepšie, takže odporučam premiestniť do $rules = [] pre všetky modely
        // FIX - Register mi funguje bez problemov, login mi vrati error "The password field is required."
        $user = new User();
        $user->username = $request->input('username');
        $user->password = $request->input('password');
        $user->save();

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        if (empty($username) || empty($password)) {
            return response()->json(['message' => 'Username and password are required'], 400);
        }

        $user = User::where('username', $username)->first();

        if ($user && password_verify($password, $user->password)) {
            $token = $user->generateApiToken();
            return response()->json(['message' => 'Login successful', 'api_token' => $token], 200);
        }

        return response()->json(['message' => 'Invalid username or password'], 401);
    }
}
