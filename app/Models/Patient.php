<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_date',
        'age',
        'gender',
        'marital_status',
        'children',
        'address',
        'city',
        'phone',
        'religion',
        'education_level',
        'occupation',
        'vices',
        'family_suicide_history',
        'suicidal_thoughts',
        'disorders',
    ];

    protected $casts = [
        'vices' => 'array',
        'disorders' => 'array',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function clinicalSituations()
    {
        return $this->hasMany(ClinicalSituation::class);
    }
}
