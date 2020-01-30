<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class YoutubeResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id'        => $this->id->videoId,
            'title'     => $this->snippet->title,
            'thumbnail' => $this->snippet->thumbnails->medium->url
        ];
    }
}
