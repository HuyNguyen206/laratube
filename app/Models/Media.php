<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends \Spatie\MediaLibrary\Models\Media
{
    use HasFactory;

    public function voters()
    {
        return $this->morphToMany(User::class, 'votable')->withPivot(['type']);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'media_id')->whereNull('comment_parent_id')->latest('comments.created_at');
    }

}
