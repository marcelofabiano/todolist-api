<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Task;

class TasksController extends Controller
{
    private $task;

    public function __construct()
    {
        $this->task = new Task;
    }

    public function index()
    {
        $limit = request()->has('limit') ? request()->get('limit') : 100;
        $offset = request()->has('offset') ? request()->get('offset') : 0;

        if (request()->has('sort') and request()->has('order')) {
            $sort = request()->get('sort') == 'desc' ? 'desc' : 'asc';
            $order = request()->get('order');
        } else {
            $sort = 'asc';
            $order = 'id';
        }

        $tasks = $this->task
            ->orderBy($order, $sort)
            ->limit($limit)
            ->offset($offset)
            ->get();

        return response(new TaskCollection($tasks), 200);
    }

    public function show($id)
    {
        $task = $this->task->find($id);
        return response(new TaskResource($task), 200);
    }
}
