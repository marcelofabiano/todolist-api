<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
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
            'type' => 'users',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name
            ],
            'links' => [
                'self' => route('users.show', $this->id),
                'tasks' => route('users.tasks.index', $this->id)
            ],
            'relationships' => [
                'tasks' => new TaskCollection($this->tasks)
            ]
        ];
    }
}
