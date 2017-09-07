<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    private $limit = 100;
    private $offset = 0;
    private $order = 'id';
    private $sort = 'asc';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $this->setParams();
        return [
            'data' => $this->when($this->collection->count(), function () {
                return $this->collection->map(function ($task) {
                    return new TaskResource($task);
                });
            }),
            'meta' => [
                'total' => $this->collection->count(),
                'limit' => $this->limit,
                'offset' => $this->offset,
                'order' => $this->order,
                'sort' => $this->sort,
            ]
        ];
    }

    private function setParams()
    {
        $this->limit = request()->has('limit') ? request()->get('limit') : 100;
        $this->offset = request()->has('offset') ? request()->get('offset') : 0;

        if (request()->has('sort') and request()->has('order')) {
            $this->sort = request()->get('sort') == 'desc' ? 'desc' : 'asc';
            $this->order = request()->get('order');
        } else {
            $this->sort = 'asc';
            $this->order = 'id';
        }
    }
}
