<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Braintree\Gateway;

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
}
