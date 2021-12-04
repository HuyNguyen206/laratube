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
        return response()->success($video->comments()->with(['user', 'replies.user'])->paginate(5));
    }
}
