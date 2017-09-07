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
        $users = $this->user->orderBy('id', 'ASC')->limit(100)->get();
        return new UserCollection($users);
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
