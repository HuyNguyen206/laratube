<?php

namespace App\Http\Controllers;

use App\Jobs\Videos\ConvertForStreaming;
use App\Jobs\Videos\CreateVideoThumbnail;
use App\Models\Channel;
use Illuminate\Http\Request;

class UploadVideoController extends Controller
{
    //
    public function index(Channel $channel)
    {
        return view('channels.upload.index', compact('channel'));
    }

    public function store(Channel $channel)
    {
        $media = $channel->addMediaFromRequest('video')
            ->withCustomProperties(['title' => \request()->title, 'description' => \request()->description])
            ->toMediaCollection('videos');

        $this->dispatch(new CreateVideoThumbnail($media));
        $this->dispatch(new ConvertForStreaming($media));
        return response()->success($media);
    }
}
