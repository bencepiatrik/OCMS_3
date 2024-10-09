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

    public function register(Request $request) // REVIEW - Logika tejto funkcie patrí do UserController (ale v http/controllers/)
    {
        // REVIEW - všetká validácia čo takto robíš sa dá premiestniť do modelu a je to tak elegantnejšie / lepšie, takže odporučam premiestniť do $rules = [] pre všetky modely
        $validatedData = $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = new User();
        $user->username = $validatedData['username'];
        $user->password = $validatedData['password'];
        $user->save();

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    public function login(Request $request) // REVIEW - Logika tejto funkcie patrí do UserController (ale v http/controllers/)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $validatedData['username'])->first();

        if (!$user || !password_verify($validatedData['password'], $user->password)) {
            return response()->json(['error' => 'Invalid username or password'], 401);
        }

        $token = $user->generateApiToken();

        return response()->json(['message' => 'Login successful', 'api_token' => $token], 200);
    }
}
