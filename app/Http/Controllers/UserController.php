<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Notifications\RegisteredNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->notify(new RegisteredNotification());

            return response()->json([
                'status' => 'success',
                'message' => 'Une notification a été envoyée. Veuillez vérifier votre boîte de réception.',
            ]);
            
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
