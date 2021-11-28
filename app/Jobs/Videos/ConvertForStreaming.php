<?php

namespace App\Jobs\Videos;

use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Spatie\MediaLibrary\Models\Media;

class ConvertForStreaming implements ShouldQueue
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
        //
        $this->media = $media;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $low = (new X264())->setKiloBitrate(100);//360p
        $mid = (new X264())->setKiloBitrate(250);
        $high = (new X264())->setKiloBitrate(500);

        $savePath = "channels/{$this->media->model->id}/videos/{$this->media->id}/convert-for-streaming/{$this->media->id}.m3u8";
        $videoPath = Str::of($this->media->getUrl())->remove('/storage/');
        FFMpeg::fromDisk('public')
            ->open($videoPath)
            ->exportForHLS()
            ->onProgress(function ($percentage) {
                $this->media->setCustomProperty('percentage', $percentage)->save();
            })
            ->addFormat($low)
            ->addFormat($mid)
            ->addFormat($high)
            ->save($savePath);
    }
}
