<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest as Request;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\User;

class UsersController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new User;
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

        $users = $this->user
            ->orderBy('id', 'ASC')
            ->limit($limit)
            ->offset($offset)
            ->orderBy($order, $sort)
            ->get();
        
        return response(new UserCollection($users), 200);
    }

    public function show($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return response([], 404);
        }
        return response(new UserResource($user), 200);
    }

    public function store(Request $request)
    {
        $user = $this->user->create($request->all());
        $header = ['Location'=>route('users.show', $user)];
        return response(new UserResource($user), 201, $header);
    }

    public function update($id, Request $request)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return response([], 404);
        }
        $user->update($request->all());
        return response(new UserResource($user), 200);
    }

    public function destroy($id)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return response([], 404);
        }
        $id = $user->id;
        $header = ['Entity'=>$id];
        $user->delete();
        return response([], 204, $header);
    }
}
