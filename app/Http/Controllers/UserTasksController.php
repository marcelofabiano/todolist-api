<?php

namespace App\Http\Controllers;

use App\Http\Requests\TasksRequest as Request;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Task;

class UserTasksController extends Controller
{
    private $task;

    public function __construct()
    {
        $this->task = new Task;
    }

    public function index($idUser)
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

        $tasks = $this->task->where('user_id', $idUser)
            ->orderBy($order, $sort)
            ->limit($limit)
            ->offset($offset);

        if (request()->has('done')) {
            $tasks = $tasks->where('done', request()->get('done'));
        }

        $tasks = new TaskCollection($tasks->get());
        return response($tasks, 200);
    }

    public function show($idUser, $idTask)
    {
        $task = $this->task->where('id', $idTask)
            ->where('user_id', $idUser)
            ->first();

        if (!$task) {
            return response([], 404);
        }
        return response(new TaskResource($task), 200);
    }

    public function store($idUser, Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $idUser;
        $task = $this->task->create($data);
        $header = ['Location'=>route('users.tasks.show', [$idUser, $task->id])];
        return response(new TaskResource($task), 201, $header);
    }

    public function update($idUser, $idTask, Request $request)
    {
        $task = $this->task->where('id', $idTask)
            ->where('user_id', $idUser)
            ->first();

        if (!$task) {
            return response([], 404);
        }

        $task->update($request->all());

        return response(new TaskResource($task), 200);
    }

    public function destroy($idUser, $idTask)
    {
        $task = $this->task->where('id', $idTask)
            ->where('user_id', $idUser)
            ->first();

        if (!$task) {
            return response([], 404);
        }

        $id = $task->id;
        $header = ['Entity'=>$id];
        $task->delete();
        return response([], 204, $header);
    }
}
