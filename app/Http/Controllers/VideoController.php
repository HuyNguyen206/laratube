<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateVideoDetailRequest;
use App\Models\Channel;
use Illuminate\Support\Facades\Response;
use Spatie\MediaLibrary\Models\Media;

class VideoController extends Controller
{
    //
    public function getVideo(Media $video)
    {
        if (\request()->expectsJson()) {
            return response()->success($video);
        }
        $channel = $video->model;
        return view('channels.video.show', compact('video', 'channel'));
    }

    public function updateVideoView(Media $video)
    {
        $video->setCustomProperty('view', ($video->getCustomProperty('view') ?? 0) + 1)->save();
        return Response::success($video);
    }

    public function updateVideoDetail(UpdateVideoDetailRequest $request, Media $video)
    {
        $validatedData = $request->validationData();
        $video->setCustomProperty('title', $validatedData['title'])
            ->setCustomProperty('description', $validatedData['description'])
            ->save();
        return redirect()->back();
    }

}
