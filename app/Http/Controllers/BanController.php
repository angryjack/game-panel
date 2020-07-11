<?php

namespace App\Http\Controllers;

use App\Services\BanService;
use Illuminate\Http\Request;

class BanController extends Controller
{
    /**
     * @var BanService
     */
    private $banService;

    public function __construct(BanService $banService)
    {
        $this->banService = $banService;
    }

    public function index()
    {
        $list = $this->banService->search('');
        return view('ban.index', compact('list'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        return $this->banService->search($search);
    }

    public function show($id)
    {
        $model = $this->banService->getById($id);
        return view('ban.show', compact('model'));
    }

    public function edit($id)
    {
        $model = $this->banService->getById($id);
        return view('ban.edit', compact('model'));
    }

    public function update(Request $request)
    {
        $model = $this->banService->getById($request->input('bid'));
        $this->banService->update($model, $request);
        return redirect()->route('bans.show', ['id' => $model->bid]);
    }
}
