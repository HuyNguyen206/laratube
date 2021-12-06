<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    protected $appends = ['created_at_human'];
    use HasFactory;

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'comment_parent_id')->latest();
    }

    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'comment_parent_id');
    }

    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function voters()
    {
        return $this->morphToMany(User::class, 'votable')->withPivot(['type']);
    }
}
