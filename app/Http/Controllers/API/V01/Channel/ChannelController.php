<?php

namespace App\Http\Controllers\API\V01\Channel;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Repositories\ChannelRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ChannelController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllChannels()
    {
        $channel = resolve(ChannelRepository::class)->getAll();
        return response()->json($channel, Response::HTTP_OK);
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

        resolve(ChannelRepository::class)->create($request->name);

        return response()->json([
            'message' => 'channel created successfully'
        ], Response::HTTP_CREATED);


    }


    public function updateChannel(Request $request)
    {
        $request->validate([
           'name'=>'required'
        ]);

       resolve(ChannelRepository::class)->getUpdate($request->id , $request->name);

        return response()->json([
            'message'=>'channel updated successfully'
        ] , Response::HTTP_OK);
    }




}
