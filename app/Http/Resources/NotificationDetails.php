<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationDetails extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->data['title'],
            'message' => $this->data['message'],
            'date' => Carbon::parse( $this->created_at)->format('Y-m-d h:i:s A'),
            'web_link' => $this->data['web_link']
        ];
    }
}
