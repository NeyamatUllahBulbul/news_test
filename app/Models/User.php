<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const TYPE_SUPERADMIN = 1;
    const TYPE_ADMIN      = 2;

    const TYPES = [
        self::TYPE_SUPERADMIN => 'SuperAdmin',
        self::TYPE_ADMIN      => 'Admin',
    ];

    const STATUS_ACTIVE   = 1;
    const STATUS_INACTIVE = 0;

    const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
