<?php

namespace App\Http\Controllers;

use App\Http\Resources\LectionResource;
use App\Models\Lection;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class LectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Lection::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:lections|max:255',
            'content' => 'required',
            'image' => 'sometimes|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=250,min_height=250,max_width=1000,max_height=1000',
            'videos.*' => 'sometimes|string'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $url = Storage::url($path);
            $data['image'] = $url;
        }

        $lection = Lection::create($data); //ak obrazok nenahram daj tam default

        if (isset($data['videos'])) {
            foreach ($data['videos'] as $video) {
                $newVideo['lection_id'] = $lection->id;
                $newVideo['youtubeVideoId'] = $video;
                Video::create($newVideo);
            }
        }


        return $lection;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new LectionResource(Lection::with('videos')->find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => ['required', 'max:255', Rule::unique('lections')->ignore($id)],
            'content' => 'required',
            'image' => 'sometimes|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=250,min_height=250,max_width=1000,max_height=1000',
            'videos.*' => 'sometimes|string'
        ]);

        $lection = Lection::find($id);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $url = Storage::url($path);
            $data['image'] = $url;
        }

        if ($request->has('videos')) {
            $videos = $request->input('videos');
            $lection->videos()->delete();

            foreach ($videos as $video) {
                $newVideo['lection_id'] = $lection->id;
                $newVideo['youtubeVideoId'] = $video;
                Video::create($newVideo);
            }
        }

        $lection->update($data);
        return $lection;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Lection::destroy($id);
    }

    public function uploadImage(Request $request)
    {
        $path = $request->file('file')->store('public/images');
        $url = Storage::url($path);
        return response()->json(['url' => $url]);
    }
}
