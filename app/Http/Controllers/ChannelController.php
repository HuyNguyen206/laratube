<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChannelRequest;
use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\MediaLibrary\Models\Media;

class ChannelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel)
    {
        $videos = $channel->media()->where('collection_name', 'videos')->paginate(10);
        return view('channels.show', compact('channel', 'videos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ChannelRequest $request, Channel $channel)
    {
        try {
            $data = $request->validated();
            if ($file = $request->file('image')) {
                $channel->clearMediaCollection('images')
                    ->addMediaFromRequest('image')
                    ->toMediaCollection('images');
            }
            $channel->update($data);
            return redirect()->back()->with('success', 'Update channel successfully');
        }catch (\Throwable $ex) {
           return redirect()->back()->with('error', $ex->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
