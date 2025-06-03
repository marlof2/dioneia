<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promptuary extends Model
{
    protected $table = 'promptuary';

    protected $fillable = [
        'type',
        'patient1_id',
        'patient2_id',
    ];

    public function patient1()
    {
        return $this->hasOne(Patient::class, 'id', 'patient1_id');
    }

    public function patient2()
    {
        return $this->hasOne(Patient::class, 'id', 'patient2_id');
    }
}
