<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all('id')->random(),
            'media_id' => Media::query()->where('collection_name', 'videos')->inRandomOrder()->first('id')->id,
            'body' => $this->faker->words(random_int(4, 10), true),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Comment $comment) {
            $comment->comment_parent_id = Arr::random([null, Comment::query()->inRandomOrder()->first('id')->id ?? null]);
            $comment->save();
        });
    }
}
