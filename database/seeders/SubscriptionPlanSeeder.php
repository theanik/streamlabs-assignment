<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Advanced Stream - Monthly',
                'price' => 9.99,
                'duration' => 30,
                'status' => true,
                'description' => 'Active you Advanced Stream for 30 days',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Advanced Stream - Yearly',
                'price' => 80.99,
                'duration' => 365,
                'status' => true,
                'description' => 'Active you Advanced Stream for 1 year',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        SubscriptionPlan::insert($plans);
    }
}
