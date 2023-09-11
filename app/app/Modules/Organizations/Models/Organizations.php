<?php

namespace App\Modules\Organizations\Models;

use App\Models\OrganizationForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organizations extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'form',
        'director',
        'logo',
        'start_at',
        'end_at',
        'days',
    ];

    protected $casts = [
        'days' => 'array'
    ];

    public function OrganizationFormData(): HasOne
    {
        return $this->hasOne(OrganizationForm::class, 'id', 'organization_form');
    }
}
