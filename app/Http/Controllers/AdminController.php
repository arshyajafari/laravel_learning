<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login (Request $request)
    {
        $loginData = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'password' => ['required', 'string', 'max:100'],
        ]);

        $admin = AdminModel::where('name', $loginData['name'])->first();

        if (! empty($admin) && Hash::check($loginData['password'], $admin->password))
        {
            $token = $admin->createToken('authToken');

            return response()->json([
                'token' => $token->plainTextToken
            ]);
        }

        $admin = $request->user();

        return response()->json([
            'code' => '6',
            'message' => 'name or password is wrong'
        ], 401);
    }
}
