<?php


namespace App\Http\MediaService;


use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

class CustomPath implements PathGenerator
{

    public function getPath(Media $media) : string
    {
        if ($media->collection_name === 'videos') {
            return "channels/{$media->model->id}/videos/$media->id/";
        }
        return $media->id.'/';
    }

    public function getPathForConversions(Media $media) : string
    {
        if ($media->collection_name === 'videos') {
            return $this->getPath($media).'conversions'.'/';
        }
        return $this->getPath($media).'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        if ($media->collection_name === 'videos') {
            return $this->getPath($media).'responsive'.'/';
        }
        return $this->getPath($media).'responsive/';
    }
}
