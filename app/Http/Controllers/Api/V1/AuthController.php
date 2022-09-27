<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UserLoginRequest;
use App\Http\Requests\V1\UserRegisterRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @param UserRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $requestData = $request->validated();

            $requestData['password'] = Hash::make($requestData['password']);

            $user = User::create($requestData);

            if ($user) {
                return $this->successResponse(new UserResource($user), 'Registration successfully done!', Response::HTTP_CREATED);
            }
            return $this->errorResponse('Something went wrong! please try again', Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param UserLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserLoginRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $requestData = $request->validated();

            if (!Auth::attempt($requestData)) {
                return $this->errorResponse('UnAuthorised Access', Response::HTTP_UNAUTHORIZED);
            }

            $accessToken = Auth::user()->createToken('authToken')->accessToken;

            return $this->successResponse([
                'user' => new UserResource(Auth::user()),
                'access_token' => $accessToken
            ], 'You have been successfully log in!');
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): \Illuminate\Http\JsonResponse
    {
        try {
            $token = Auth::user()->token();
            $token->revoke();
            return $this->successResponse(null, 'You have been successfully logged out!');
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
