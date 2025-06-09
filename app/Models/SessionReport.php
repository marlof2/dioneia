<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionReport extends Model
{
    protected $fillable = [
        'promptuary_id',
        'text',
    ];

    public function promptuary()
    {
        return $this->belongsTo(Promptuary::class);
    }
}
