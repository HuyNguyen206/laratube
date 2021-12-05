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
            'body' => $this->faker->words(random_int(4, 10), true),
            'media_id' => '1', //This one will be override in configure
            'comment_parent_id' => '1' //This one will be override in configure
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Comment $comment) {
            $comment->comment_parent_id = Arr::random([null, Comment::query()->inRandomOrder()->first('id')->id ?? null]);
            if ($comment->comment_parent_id) {
                $comment->media_id = Comment::find($comment->comment_parent_id)->media_id;
            } else {
                $comment->media_id = Media::query()->where('collection_name', 'videos')->inRandomOrder()->first('id')->id;
            }
            $comment->save();
        });
    }
}
