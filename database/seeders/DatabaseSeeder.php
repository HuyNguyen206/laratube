<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $huy = User::factory()->create([
            'name' => 'huy',
            'email' => 'nguyenlehuyuit@gmail.com'
        ]);
        Channel::factory()->create([
            'user_id' => $huy->id
        ]);
        Channel::factory()->count(60)->create();
        $allUser = User::all();
        $allChannel = Channel::all();
        foreach ($allUser as $user) {
            $user->subscribedChannels()->attach($allChannel->random(rand(10,50))->pluck('id')->toArray());
        }
        Comment::factory()->count(100)->create();
//        Comment::factory()->count(10)->create(['media_id' => 72, 'comment_parent_id' => 703]);
    }
}
