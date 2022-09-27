<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserSubscriptionResource;
use App\Models\UserSubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrentUserSubscription(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $userSubscriptionPlan = UserSubscriptionPlan::with(['user', 'plan'])->where('user_id', Auth::id())->first();
            if ($userSubscriptionPlan) {
                return $this->successResponse(new UserSubscriptionResource($userSubscriptionPlan));
            }
            return $this->successResponse(null, 'No subscription found');
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelCurrentUserSubscription(): \Illuminate\Http\JsonResponse
    {
        try {
            $userSubscriptionPlan = UserSubscriptionPlan::where('user_id', Auth::id())->first();
            if ($userSubscriptionPlan) {
                $userSubscriptionPlan->cancelled = true;
                $userSubscriptionPlan->cancelled_at = Carbon::now();

                if ($userSubscriptionPlan->save()) {
                    return $this->successResponse(null, 'Subscription plan successfully cancelled');
                }
                return $this->errorResponse('Something went wrong!', Response::HTTP_BAD_REQUEST);
            }
            return $this->errorResponse('Subscription not found!', Response::HTTP_NOT_FOUND);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
