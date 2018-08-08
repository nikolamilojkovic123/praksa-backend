<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class GameResource
 * @package App\Http\Resources
 */
class GameResource extends JsonResource
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
            'id'        => $this->id,
            'user_x_id' => new UserResource($this->userX),
            'user_o_id' => new UserResource($this->userO),
            'active'    => $this->active,
            'winner'    => $this->winner
        ];
    }
}
