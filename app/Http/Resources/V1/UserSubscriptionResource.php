<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'user' => $this->user,
            'plan' => $this->plan,
            'expiry_date' => $this->expiry_date,
            'status' => $this->status,
            'cancelled' => $this->cancelled,
            'cancelled_at' => $this->cancelled_at,
            'is_subscription_active' => $this->status && !$this->cancelled && Carbon::now()->lt($this->expiry_date)
        ];
    }
}
