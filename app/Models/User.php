<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @property $id
 * @property $name
 * @property $email
 * @property $auth_key
 * @property $password
 * @property $role
 * @property $flags
 * @property $steam_id
 * @property $nickname
 */
class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;

    public const ROLE_USER = 'user';
    public const ROLE_EDITOR = 'editor';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_OWNER = 'owner';

    public const FLAG_NAME = 'a';
    public const FLAG_STEAM_ID = 'ca';

    protected $fillable = [
        'name',
        'email',
        'auth_key',
        'password',
        'role',
        'flags',
        'steam_id',
        'nickname',
    ];

    protected $guarded = [
        'password',
        'role',
    ];

    protected $hidden = [
        'password'
    ];

    public function servers()
    {
        return $this->belongsToMany(Server::class)
            ->withPivot(['access', 'expire']);
    }

    /**
     * Проверяет роль пользователя.
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        // для владельца доступно все
        return $this->role === self::ROLE_OWNER || $this->role === $role;
    }

    /**
     * Возвращает список типов доступа.
     * @return array
     */
    public function getFlagListAttribute()
    {
        return [
            self::FLAG_NAME => 'Ник + Пароль',
            self::FLAG_STEAM_ID => 'Steam ID + Пароль',
        ];
    }

    /**
     * Возвращает список ролей.
     * @return array
     */
    public function getRoleListAttribute()
    {
        return [
            self::ROLE_USER => 'Юзер',
            self::ROLE_EDITOR => 'Редактор',
            self::ROLE_ADMIN => 'Админ',
            self::ROLE_OWNER => 'Владелец',
        ];
    }

    public function getPrivilegesAttribute()
    {
        $privileges = [];
        foreach ($this->servers as $server) {
            $privilege = Privilege
                ::where([
                    ['server_id', $server->id],
                    ['flags', $server->pivot->access],
                ])
                ->with('rates')
                ->first();

            if ($server->pivot->expire === null) {
                $expire = 'Навсегда';
            } elseif (strtotime($server->pivot->expire) < time()) {
                $expire = 'Истекла';
            } else {
                $expire = date('d.m.Y H:i', strtotime($server->pivot->expire));
            }

            $privileges[] = [
                'server' => $server,
                'privilege' => $privilege,
                'flags' => $server->pivot->custom_flags,
                'expire' => $expire,
            ];
        }

        return $privileges;
    }
}
