<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Media;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function index(Media $video)
    {
        return response()->success($video->comments()->with(['user', 'voters'])->withCount(['replies'])->paginate(10));
    }

    public function getReplies(Comment $comment)
    {
        return response()->success($comment->replies()->with(['user', 'voters'])->paginate(5));
    }
}
