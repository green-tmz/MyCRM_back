<?php

namespace App\Modules\Personal\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Modules\MainSettings\Models\MainSettings;
use App\Modules\Vacansies\Models\Vacansies;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Personal extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function organization()
    {
        return $this->hasOne(MainSettings::class, 'id', 'organization_id');
    }

    public function vacansy()
    {
        return $this->hasOne(Vacansies::class, 'id', 'vacansy_id');
    }
}
