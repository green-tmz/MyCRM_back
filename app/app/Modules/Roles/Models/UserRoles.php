<?php

namespace App\Modules\Roles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    use HasFactory;

    protected $table = "user_roles";

    protected $fillable = [
        'id',
        'user_id',
        'role_id',
    ];
}
