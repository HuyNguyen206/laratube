<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChannelResource;
use App\Models\Channel;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function toggleSubscriber(Channel $channel)
    {
        try {
            $user = auth()->user();
            $user->subscribedChannels()->toggle($channel->id);
            return response()->success($user);
        }catch (\Throwable $ex) {
            return  response()->error($ex->getMessage());
        }

    }
}
