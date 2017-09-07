<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->when($this->collection->count(), function () {
                return $this->collection->map(function ($user) {
                    return new UserResource($user);
                });
            }),
            'meta' => [
                'total' => $this->collection->count(),
                'limit' => 100
            ]
        ];
    }
}
