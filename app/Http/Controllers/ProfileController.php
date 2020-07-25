<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdate;
use App\Services\UserService;

class ProfileController
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        //todo подгрузить с привилегиями
        return view('profile.show', ['model' => $this->userService->getUserByAuth()]);
    }

    public function update(ProfileUpdate $request)
    {
        $model = $this->userService->updateProfile($request->validated());
        return view('profile.show', compact('model'));
    }

}
