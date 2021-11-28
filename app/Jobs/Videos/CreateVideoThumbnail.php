<?php

namespace App\Jobs\Videos;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Spatie\MediaLibrary\Models\Media;

class CreateVideoThumbnail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $media;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Media $media)
    {
        $this->media = $media;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $videoPath = Str::of($this->media->getUrl())->remove('/storage/');
//        $savePath = "videos/channel/{$this->video->model->id}/convert-for-streaming/{$this->video->id}/thumbnail/{$this->video->id}.png";
        $savePath = "channels/{$this->media->model->id}/videos/{$this->media->id}/thumbnail/{$this->media->id}.png";
        FFMpeg::fromDisk('public')
            ->open($videoPath)
            ->getFrameFromSeconds(1)
        ->export()
        ->toDisk('public')
        ->save($savePath);
        $thumbnailPath = Storage::url($savePath);
        $this->media->setCustomProperty('thumbnail', $thumbnailPath)->save();

    }
}
