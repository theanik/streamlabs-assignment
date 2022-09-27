<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Http\Resources\V1\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUserInfo()
    {
        $user = Auth::user();
        $user->load(['subscription', 'subscription.plan']);
        return $this->successResponse(new UserResource(Auth::user()));
    }
}
