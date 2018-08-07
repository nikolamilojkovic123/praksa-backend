<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @package App\Http\Resources
 */
class UserResource extends JsonResource
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
            'id'     => $this->id,
            'name'   => $this->name,
            'email'  => $this->email,
            'joined' => $this->joined,
            'games'  => GameResource::collection($this->when($this->includeGames(), $this->games()))
        ];
    }

    /**
     * @return bool
     */
    public function includeGames()
    {
        if (isset($_GET['include'])) {
            if ($_GET['include'] == 'games') {
                return true;
            }
        }
        return false;
    }
}
