<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'description',
        'status',
        'progress',
        'start_date',
        'deadline',
        'budget',
        'cost_consumed',
    ];

    protected $casts = [
        'start_date' => 'date',
        'deadline' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
