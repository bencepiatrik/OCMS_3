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
        $validatedData = $request->validate($user->rules);

        $user->username = $validatedData['username'];
        $user->password = $validatedData['password'];
        $user->save();

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    /**
     * @throws \Exception
     */
    public function login(Request $request) // REVIEW - Logika tejto funkcie patrí do UserController (ale v http/controllers/) // FIX - Už opravené v predošlej commite
    {
        $user = new User();
        //dd($request);
        //dd($user->rules);
        $validatedData = $request->validate($user->rules);


        $user = User::where('username', $validatedData['username'])->first();

        if (!$user || !password_verify($validatedData['password'], $user->password)) {
            throw new \Exception('Invalid username or password');

        }

        $token = $user->generateApiToken();

        return response()->json(['message' => 'Login successful', 'api_token' => $token], 200);
    }
}
