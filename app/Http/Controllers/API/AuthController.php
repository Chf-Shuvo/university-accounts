<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $authenticated = Auth::attempt($request->only("email", "password"));
            if ($authenticated) {
                $token = auth()
                    ->user()
                    ->createToken("API_KEY");
                $token = $token->plainTextToken;
                return response()->json(
                    [
                        "api_key" => $token,
                    ],
                    Response::HTTP_OK
                );
            } else {
                return response()->json(
                    [
                        "response" => "Invalid User",
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "response" => $th->getMessage(),
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
