<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateVideoDetailRequest;
use App\Models\Channel;
use App\Models\Comment;
use App\Models\Media;
use Illuminate\Support\Facades\Response;

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

    public function voteVideo(Media $video)
    {
        try {
            $user = auth()->user();
            $voter = $video->voters()->where('users.id', $user->id)->first();
            if (!$voter) {
                $video->voters()->attach($user->id, ['type' => request()->type]);
            } else {
                $video->voters()->detach($user->id);
                if (request()->type !== $voter->pivot->type) {
                    $video->voters()->attach($user->id, ['type' => request()->type]);
                }
            }
            return \response()->success($video->load('voters'));
        }catch (\Throwable $ex) {
            return \response()->error($ex->getMessage());
        }
    }

}
