<?php

namespace Tests\Feature;

use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\UserSubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    public function test_get_plans_without_authentication() :void
    {
        $this->json('GET', 'api/v1/plans', ['Accept' => 'application/json'])
            ->assertStatus(401);
    }

    public function test_get_plans() :void
    {
        Passport::actingAs(User::factory()->create());
        $this->json('GET', 'api/v1/plans', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'code',
                'data'
            ]);
    }


    public function test_get_user_subscription_without_authentication() :void
    {
        $this->json('GET', 'api/v1/user-subscription', ['Accept' => 'application/json'])
            ->assertStatus(401);
    }

    public function test_get_user_subscription() :void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        // Create Plans
        Artisan::call('db:seed SubscriptionPlanSeeder');
        $plan = SubscriptionPlan::first();
        UserSubscriptionPlan::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'expiry_date' => Carbon::now()->addDays($plan->duration),
            'cancelled' => false,
            'cancelled_at' => null
        ]);

        $this->json('GET', 'api/v1/user-subscription', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'code',
                'data' => [
                    'user',
                    'plan',
                    'expiry_date',
                    'status',
                    "cancelled",
                    "cancelled_at",
                    'is_subscription_active'
                ]
            ]);
    }

    public function test_cancel_subscription() :void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        // Create Plans
        Artisan::call('db:seed SubscriptionPlanSeeder');
        $plan = SubscriptionPlan::first();
        UserSubscriptionPlan::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'expiry_date' => Carbon::now()->addDays($plan->duration),
            'cancelled' => false,
            'cancelled_at' => null
        ]);

        $this->json('POST', 'api/v1/cancel-subscription', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                'status' => 'Success',
                'message' => 'Subscription plan successfully cancelled',
                'code' => 200,
                'data' => null
            ]);
    }
}
