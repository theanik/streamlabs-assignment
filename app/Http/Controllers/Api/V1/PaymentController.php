<?php

namespace App\Http\Controllers\Api\V1;

use Carbon\Carbon;
use Braintree\Gateway;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscriptionPlan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\V1\CheckoutRequest;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    private $braintreeGateway;

    public function __construct()
    {
        $this->braintreeGateway = new Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);
    }

    /**
     * Return braintree dom auth token
     * @return \Illuminate\Http\JsonResponse
     */
    public function getToken(): \Illuminate\Http\JsonResponse
    {
        try {
            $token = $this->braintreeGateway->ClientToken()->generate();

            return $this->successResponse([
                'braintree_token' => $token
            ]);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @param CheckoutRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkout(CheckoutRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $requestData = $request->validated();

            $plan = SubscriptionPlan::find($requestData['planId']);
            if (!$plan) {
                return $this->errorResponse('Subscription plan not found', Response::HTTP_BAD_REQUEST);
            }

            $result = $this->braintreeGateway->transaction()->sale([
                'amount' => $plan->price,
                'paymentMethodNonce' => $requestData['nonce'] ?? '',
                'options' => ['submitForSettlement' => True],
                'customer' => [
                    'id' => Auth::id(),
                    'firstName' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ]
            ]);

            if ($result->success) {
                $existingSubscription = UserSubscriptionPlan::where('user_id', Auth::id())->first();
                $subscriptionData = [
                    'user_id' => Auth::id(),
                    'subscription_plan_id' => $plan->id,
                    'expiry_date' => Carbon::now()->addDays($plan->duration),
                    'cancelled' => false,
                    'cancelled_at' => null
                ];
                if ($existingSubscription) {
                    UserSubscriptionPlan::where('user_id', Auth::id())->update($subscriptionData);
                    return $this->successResponse([], 'Subscription Plan Updated!');
                }
                $res = UserSubscriptionPlan::create($subscriptionData);
                return $this->successResponse($res, 'Subscription Plan Created!');
            }
            return $this->errorResponse($result->message, Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }
    }
}
