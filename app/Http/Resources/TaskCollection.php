<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
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
                return $this->collection->map(function ($task) {
                    return new TaskResource($task);
                });
            }),
            'meta' => [
                'total' => $this->collection->count(),
                'limit' => 100
            ]
        ];
    }
}
