<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Media;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $channels = $videos = collect();
        if ($s = \request()->search) {
            $channels = Channel::query()->where('name', 'like', "%$s%")
                ->orWhere('description', 'like', "%$s%")->paginate(5, ["*"], 'page_channel');

            $videos = Media::query()->where('collection_name', 'videos')
                ->where('custom_properties->title', 'like', "%$s%")
                ->orWhere('custom_properties->description', 'like', "%$s%")
                ->paginate(5, ["*"], 'page_video');
        }
        return view('home', compact('channels', 'videos'));
    }
}
