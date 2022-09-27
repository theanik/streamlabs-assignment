<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\SubscriptionPlanResource;
use App\Http\Resources\V1\SubscriptionPlanCollection;
use App\Models\SubscriptionPlan;

class SubscriptionPlanController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPlans(): \Illuminate\Http\JsonResponse
    {
        try {
            $plans = SubscriptionPlan::all();
            return $this->successResponse(new SubscriptionPlanCollection($plans));
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param SubscriptionPlan $plan
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPlan(SubscriptionPlan $plan): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->successResponse(new SubscriptionPlanResource($plan));
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
