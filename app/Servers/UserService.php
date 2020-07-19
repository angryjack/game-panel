<?php

namespace App\Services;

use App\Mail\BuyPrivilege;
use App\Mail\ProlongPrivilege;
use App\Models\Payment;
use App\Models\PrivilegeRate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserService
{
    public function create(array $data): User
    {
        $user = new User($data);
        $user->save();

        if ($data['servers']) {
            $this->setPrivileges($user, $data);
        }

        return $user;
    }

    public function update(User $user, array $data): User
    {
        foreach ($data as $key => $value) {
            if ($value === null) {
                unset($data[$key]);
            }
        }

        if (Auth::id() === $user->id) {
            // запрещаем менять себе роль
            unset($data['role']);
        }

        $user->update($data);

        if ($data['servers']) {
            $this->setPrivileges($user, $data);
        }

        return $user;
    }

    private function setPrivileges(User $user, $data)
    {
        $privilegesOnServers = [];
        foreach ($data['servers'] as $serverId => $params) {
            if (!isset($params['on'])) {
                continue;
            }
            if (isset($params['forever']) || !isset($params['expire'])) {
                $expire = null;
            } else {
                $expire = date('Y-m-d H:i:s', strtotime($params['expire']));
            }

            $privilegesOnServers[$serverId] = [
                'access' => $params['access'],
                'expire' => $expire,
            ];
        }

        $user->servers()->sync($privilegesOnServers);
    }


    /**
     * Ищет пользователей.
     *
     * @param string $search
     * @return mixed
     */
    public function search($search)
    {
        $list = User
            ::when($search, function ($query, $search) {
                return $query
                    ->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('steam_id', 'like', "%$search%")
                    ->orWhere('nickname', 'like', "%$search%");
            })
            ->orderBy('id', 'desc')
            ->paginate(50);

        return $list;
    }


    /**
     * Возвращает пользователя с услугами.
     *
     * @param $id
     * @return mixed
     */
    public function getWithServers($id)
    {
        return User::with('servers')->findOrFail($id);
    }

    /**
     * Валидация данных перед оплатой.
     *
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateUserBeforePay(Request $request): void
    {
        $model = Auth::user();

        $validationRules = [
            'rate' => 'required'
        ];

        if ($model === null) {
            $model = new User();
            $validationRules['nickname'] = [
                'required',
                Rule::unique($model->getTable())->ignore($model),
            ];
            $validationRules['email'] = [
                'required',
                Rule::unique($model->getTable())->ignore($model),
            ];
        }

        $messages = [
            'nickname.unique' => 'Данный ник уже используется другим игроком.',
            'email.unique' => 'Почта уже зарегистрирована в системе.'
        ];

        $this->validate($request, $validationRules, $messages);
    }

    /**
     * Добавление привилегии после покупки.
     *
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function addPrivilege(Payment $payment)
    {
        $data = $payment->data;
        $requiredKeys = ['email', 'nickname', 'privilege_rate_id'];

        foreach ($requiredKeys as $key) {
            if (!isset($data[$key])) {
                throw new \Exception("Ошибка при создании привилегии. Ключа $key нет в передаваемом массиве.");
            }
        }

        $rate = PrivilegeRate::findOrFail($data['privilege_rate_id']);
        //todo подумать чтобы на момент покупки не было совпадения ников
        // создали 2 одинаковых ника и пошли оплачивать
        $user = $this->createUser($data['email'], $data['nickname'], $rate->privilege->flags);

        $server = $rate->privilege->server;

        $expire = ($rate->term === 0) ?
            null :
            date('Y-m-d H:i:s', strtotime($rate->term . 'days'));


        $user->servers()->save($server, [
            'custom_flags' => $rate->privilege->flags,
            'expire' => $expire
        ]);

        Mail::to($user->email)->send(new BuyPrivilege($user, $rate->privilege));

        return $user;
    }

    /**
     * Продление привилегии.
     *
     * @param Payment $payment
     * @return mixed
     * @throws \Exception
     */
    public function prolongPrivilege(Payment $payment)
    {
        $data = $payment->data;
        $requiredKeys = ['email', 'nickname', 'privilege_rate_id'];

        foreach ($requiredKeys as $key) {
            if (!isset($data[$key])) {
                throw new \Exception("Ошибка при создании привилегии. Ключа $key нет в передаваемом массиве.");
            }
        }

        $rate = PrivilegeRate::findOrFail($data['privilege_rate_id']);

        $user = User::where([
            ['nickname', $data['nickname']],
            ['email', $data['email']],
        ])->first();

        if ($user === null) {
            throw new \Exception('Невозможно продлить привилегию. Пользователь не найден.');
        }

        $server = $rate->privilege->server;
        $existPrivilege = $user->servers()->where('id', $server->id)->first();

        if (isset($existPrivilege)) {
            // мы предпологаем что привилегии одинаковые и происходит продление
            // так как проверка на совпадание флагов в привилегиях производили до оплаты
            // после оплаты необходимо оказать услугу
            $existPrivilegeExpire = strtotime($existPrivilege->pivot->expire);
            if ($rate->term === 0) {
                $expire = null;
            } elseif ($existPrivilegeExpire <= time()) {
                $expire = date('Y-m-d H:i:s', strtotime($rate->term . ' days'));
            } else {
                $secondsOffset = $existPrivilegeExpire - time();
                $expire = date('Y-m-d H:i:s', strtotime($rate->term . ' days ' . $secondsOffset . ' seconds'));
            }
        } else {
            throw new \Exception('Невозможно продлить привилегию. Не найдена привилегия для продления.');
        }

        $user->servers()->updateExistingPivot($server, [
            'custom_flags' => $rate->privilege->flags,
            'expire' => $expire
        ]);

        Mail::to($user->email)->send(new ProlongPrivilege($user));

        return $user;
    }

    /**
     * Создание / обновление пользователя.
     *
     * @param Request $request
     * @return User
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store($data)
    {
        $model = User::find($data['id'] ?? 0);

        if ($model === null) {
            $model = new User();
        }

        // binding values
        $model->fill($data);
        $model->username = $model->nickname;

        $password = trim($data['password'], '');
        if (!empty($password)) {
            $model->password = md5($password);
        }

        $model->save();

        return $model;


        $privilegesOnServers = [];
        foreach ($data['servers'] as $serverId => $params) {
            if (!isset($params['on'])) {
                continue;
            }
            if (empty($params['expire'])) {
                continue;
            }
            if (isset($params['forever'])) {
                $expire = null;
            } else {
                $expire = date('Y-m-d H:i:s', strtotime($params['expire']));
            }

            $privilegesOnServers[$serverId] = [
                'custom_flags' => $params['custom_flags'],
                'expire' => $expire,
            ];
        }

        $model->servers()->sync($privilegesOnServers);

        return $model;
    }

    /**
     * Обновление профиля пользователя.
     *
     * @param Request $request
     * @return User
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateProfile(Request $request)
    {
        /** @var User $model */
        $model = $this->getUserByAuth();

        $messages = [
            'nickname.unique' => 'Данный ник уже используется другим игроком.',
            'nickname.required' => 'Необходимо указать ник.',
            'password.min' => 'Минимальная длина пароля 6 символов.'
        ];

        $validationRules = [
            'nickname' => [
                'required',
                Rule::unique($model->getTable())->ignore($model),
            ],
            'password' => 'sometimes|min:6'
        ];

        $this->validate($request, $validationRules, $messages);

        $model->nickname = $model->steamid = $model->username = $request->input('nickname');
        $newPassword = trim($request->input('password'));

        if (strlen($newPassword) >= 6) {
            $model->password = md5($newPassword);
        }
        $model->save();

        return $model;
    }

    /**
     * Возвращает пользователя из сессии.
     *
     * @return User|null
     */
    public function getUserByAuth(): ?User
    {
        return Auth::user();
    }

    public function getUserByPayment(Payment $payment): ?User
    {
        $data = $payment->data;

        return User::where([
            ['nickname', $data['nickname']],
            ['email', $data['email']],
        ])->first();
    }

    /**
     * Создает пользователя при покупке привилегии.
     * //todo перенести создание пользователя в один метод.
     * @param $email
     * @param $nickname
     * @param $flags
     * @return User
     */
    private function createUser($email, $nickname, $flags): User
    {
        $authKey = Str::random(25);
        $password = substr($authKey, 0, 8);

        $model = new User();
        $model->nickname = $model->username = $model->steamid = $nickname;
        $model->email = $email;
        $model->password = md5($password);
        $model->flags = User::FLAG_NAME;
        $model->access = $flags;
        $model->created = time();
        $model->expired = $model->days = 0;
        $model->role = User::ROLE_USER;
        $model->auth_key = $authKey;
        $model->save();

        return $model;
    }
}
