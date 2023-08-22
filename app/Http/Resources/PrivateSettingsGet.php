<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrivateSettingsGet extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'msg' => trans('shared.success'),
            'settings' => [
                'id' => $this->id,
                'user_id' => $this->user_id,
                'event_on' => $this->event_off ? true : false,
                'content_on' => $this->content_on ? true : false,
                'coupon_on' => $this->coupon ? true : false,
            ],
        ];
    }
}
