<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Server
 * @property $id
 * @property $hostname
 * @property $address
 * @property $description
 * @property $rules
 * @property $created_at
 * @property $updated_at
 */
class Server extends Model
{
    protected $fillable = [
        'hostname',
        'address',
        'description',
        'rules',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function privileges()
    {
        return $this->hasMany(Privilege::class);
    }
}
