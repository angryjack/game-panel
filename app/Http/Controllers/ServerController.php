<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServerStore;
use App\Models\Server;
use App\Services\ServerService;

class ServerController extends Controller
{
    /**
     * @var ServerService
     */
    private $serverService;

    public function __construct(ServerService $serverService)
    {
        $this->serverService = $serverService;
    }

    public function list()
    {
        return $this->serverService->get();
    }

    public function info($id)
    {
        $server = $this->getById($id);
        return $this->serverService->getSourceQueryInformation($server);
    }

    /**
     * Список серверов.
     */
    public function index()
    {
        $list = $this->serverService->get();
        return view('server.index', compact('list'));
    }

    /**
     * Конкретный сервер.
     */
    public function show($id)
    {
        $model = $this->getById($id);
        //$model = $this->serverService->getWithInformation($server);
        return view('server.show', compact('model'));
    }

    /**
     * Конкретный сервер.
     */
    public function create()
    {
        $model = new Server();
        return view('server.create', compact('model'));
    }

    /**
     * Форма редактирования.
     */
    public function edit($id)
    {
        $model = $this->getById($id);
        return view('server.edit', compact('model'));
    }

    /**
     * Форма редактирования информации о сервере.
     */
    public function store(ServerStore $request)
    {
        $data = $request->validated();

        $id = $request->input('id');
        if ($id) {
            $model = Server::findOrFail($id);
        } else {
            $model = new Server();
        }
        $model->fill($data);
        $model->save();

        $model->load('privileges');

        return view('server.show', compact('model'));
    }

    public function delete($id)
    {
        $model = $this->getById($id);
        $model->delete($id);

        return redirect()->route('servers');
    }

    /**
     * Возвращает сервер по идентификатору.
     *
     * @param $id
     * @return Server
     */
    private function getById($id): Server
    {
        return Server::findOrFail($id);
    }

}
