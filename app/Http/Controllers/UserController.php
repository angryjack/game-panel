<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreate;
use App\Http\Requests\UserUpdate;
use App\Models\User;
use App\Services\ServerService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var ServerService
     */
    private $serverService;

    public function __construct(UserService $userService, ServerService $serverService)
    {
        $this->userService = $userService;
        $this->serverService = $serverService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $list = $this->userService->search($search);
        return view('user.index', compact('list'));
    }

    public function show($id)
    {
        $model = $this->userService->getWithServers($id);
        return view('user.show', compact('model'));
    }

    public function create()
    {
        $user = new User();
        $servers = $this->serverService->getAllWithPrivileges();
        return view('user.create', compact('user', 'servers'));
    }

    public function edit($id)
    {
        $user = $this->getById($id);

        $servers = $this->serverService->getAllWithPrivileges();
        $userPrivileges = $user->servers;
        foreach ($servers as $index => $server) {
            if ($userPrivileges->contains($server)) {
                $servers[$index] = $userPrivileges->find($server->id);
            }

        }

        return view('user.edit', compact('user', 'servers'));
    }

    public function store(UserCreate $request)
    {
        $model = $this->userService->create($request->all());
        return redirect()->route('users.show', ['id' => $model->id]);
    }

    public function update(UserUpdate $request)
    {
        $id = $request->input('id');
        $model = $this->userService->update($this->getById($id), $request->all());
        return redirect()->route('users.show', ['id' => $model->id]);
    }

    public function delete($id)
    {
        $model = $this->getById($id);
        $model->delete();

        return redirect()->route('servers');
    }

    private function getById(int $id): User
    {
        return User::findOrFail($id);
    }
}
