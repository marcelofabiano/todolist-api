<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    public function toArray($request)
    {
        if ($this->collection->count()) {
            $data['data'] = $this->collection->map(function ($task) {
                return new TaskResource($task);
            });
            $data['meta'] = $this->setMeta();
            return $data;
        }
        return ['data'=>[]];
    }

    private function setMeta()
    {
        $data['meta']['limit'] = request()->has('limit') ? request()->get('limit') : 100;
        $data['meta']['offset'] = request()->has('offset') ? request()->get('offset') : 0;
        if (request()->has('sort') and request()->has('order')) {
            $data['meta']['sort'] = request()->get('sort') == 'desc' ? 'desc' : 'asc';
            $data['meta']['order'] = request()->get('order');
        } else {
            $data['meta']['sort'] = 'asc';
            $data['meta']['order'] = 'id';
        }
        return $data['meta'];
    }
}
