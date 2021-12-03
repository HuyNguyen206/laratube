<?php


namespace App\Helper;


use Illuminate\Support\Str;
use Spatie\MediaLibrary\Models\Media;

class MediaHelper
{
    public static function getStreamingUrl(Media $video)
    {
        return Str::replace($video->file_name, "convert-for-streaming/{$video->id}.m3u8", $video->getFullUrl());
    }

    public static function canEditVideo(Media $video)
    {
        $user = auth()->user();
        return $user && $user->id === $video->model->user_id;
    }

}
