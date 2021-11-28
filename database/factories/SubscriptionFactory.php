<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::query()->inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'channel_id' => Channel::query()->where('id',  '<>', $user->id)->inRandomOrder()->first()->id
        ];
    }
}
