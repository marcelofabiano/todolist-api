<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TaskResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type' => 'tasks',
            'id' => $this->id,
            'attributes' => [
                'description' => $this->description,
                'done' => $this->done,
                'user_id' => $this->user_id
            ],
            'links' => [
                'self' => route('users.tasks.show', [$this->user_id, $this->id]),
                'user' => route('users.show', $this->user_id)
            ]
        ];
    }
}
