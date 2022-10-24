<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store (Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'max:100']
        ]);

        $data['password'] = Hash::make($data['password']);

        return response()->json(
            User::create($data)
        );
    }

    /**
     * @return JsonResponse
     */
    public function get (): JsonResponse
    {
        return response()->json(
            User::all()
        );
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function getById (string $id): JsonResponse
    {
        $user = User::where('id', $id)->first();

        if (! empty($user))
        {
            return response()->json(
                $user
            );
        }

        return response()->json(
            [
                'code' => '1',
                'message' => 'user not found'
            ],
            404
        );
    }

    public function updateById (string $id, Request $request)
    {
        $data = $request->validate([
            'name' => ['string', 'max:150'],
            'email' => ['email', 'max:100'],
            'password' => ['string', 'max:100']
        ]);

        if (isset($data['email']) && User::where('email', $data['email'])->where('id', '!=', $id)->exists())
        {
            return response()->json(
                [
                    'code' => '2',
                    'message' => 'this email is already taken'
                ],
                ResponseAlias::HTTP_BAD_REQUEST
            );
        }

        isset($data['password']) && ($data['password'] = Hash::make($data['password']));

        User::where('id', $id)->update($data);

        return response()->json([
            'message' => 'user updated successfully'
        ]);
    }

    public function deleteById(string $id)
    {
        User::where('id', $id)->delete();

        return response()->json([
            'message' => 'user deleted successfully'
        ]);
    }
}
