<?php

namespace App\Http\Resources;

use App\Models\Lection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'image' => $this->image,
            'updated_at' => Carbon::parse($this->updated_at)->format('d.m.Y'),
            'videos' => $this->videos,
            'next' => Lection::where('id', '>', $this->id)->orderBy('id')->first() ? Lection::where('id', '>', $this->id)->orderBy('id')->first()->id :null,
            'previous' => Lection::where('id', '<', $this->id)->orderBy('id','desc')->first() ? Lection::where('id', '<', $this->id)->orderBy('id','desc')->first()->id : null,
        ];
    }
}
