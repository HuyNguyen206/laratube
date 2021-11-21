<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;


class Channel extends Model implements HasMedia
{
    use HasMediaTrait;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100);
    }

    public function image()
    {
        return optional($this->getFirstMedia('images'))->getFullUrl('thumb');
    }

    public function canUpdateByCurrentUser()
    {
        return auth()->check() && $this->user_id === auth()->id();
    }

    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'subscriptions');
    }
}
