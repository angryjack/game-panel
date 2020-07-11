<?php

namespace App\Http\Controllers;

use App\Services\ServerService;
use Illuminate\Http\Request;

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
        $server = $this->serverService->getById($id);
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
        $server = $this->serverService->getById($id);
        $model = $this->serverService->getWithInformation($server);
        return view('server.show', compact('model'));
    }

    /**
     * Форма редактирования.
     */
    public function edit($id)
    {
        $model = $this->serverService->getById($id);
        return view('server.edit', compact('model'));
    }

    /**
     * Форма редактирования информации о сервере.
     */
    public function store(Request $request)
    {
        $model = $this->serverService->store($request);
        return redirect()->route('server.show', ['id' => $model->id]);
    }
}
