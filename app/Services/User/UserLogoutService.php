<?php

namespace App\Services\User;



use Illuminate\Support\Facades\Log;


/**
 * User Logout Service
 */
class UserLogoutService
{
    /**
     * logs out the currently authenticated user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function userLogout()
    {
        try {
            auth()->user()->currentAccessToken()->delete();
            return response ([
                'message' =>'Successfully Logged Out'
            ]);
        } catch (\Throwable $th) {
            Log::error('An error occurred: ',$th->getMessage());
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }

}
