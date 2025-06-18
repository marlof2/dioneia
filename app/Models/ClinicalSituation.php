<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicalSituation extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor',
        'medication',
        'reason',
    ];

    protected $table = 'clinical_situations';

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
