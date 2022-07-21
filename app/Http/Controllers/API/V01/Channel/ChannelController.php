<?php

namespace App\Http\Controllers\API\V01\Channel;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Repositories\ChannelRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChannelController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllChannels()
    {
        return response()->json(Channel::all(), 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createNewChannel(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name' => 'required'
        ]);

        resolve(ChannelRepository::class)->create($request);

        return response()->json([
            'message' => 'channel created successfully'
        ], 201);


    }


}
