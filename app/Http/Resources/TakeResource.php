<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TakeResource
 * @package App\Http\Resources
 */
class TakeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'game_id'  => $this->game_id,
            'user_id'  => $this->user_id,
            'position' => $this->position,
            'symbol'   => $this->symbol
        ];
    }
}
