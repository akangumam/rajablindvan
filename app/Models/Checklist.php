<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Checklist extends Model
{
    protected $fillable = [
        'vehicle_id', 'check_date', 'odometer', 'checklist_type',
        'tire_pressure', 'tire_condition', 'brake_system', 'lights',
        'fluids', 'battery', 'wipers', 'mirrors', 'horn', 'seat_belts',
        'emergency_kit', 'documents', 'checked_by', 'notes'
    ];

    protected $casts = [
        'check_date' => 'date',
        'odometer' => 'decimal:2',
        'tire_pressure' => 'boolean',
        'tire_condition' => 'boolean',
        'brake_system' => 'boolean',
        'lights' => 'boolean',
        'fluids' => 'boolean',
        'battery' => 'boolean',
        'wipers' => 'boolean',
        'mirrors' => 'boolean',
        'horn' => 'boolean',
        'seat_belts' => 'boolean',
        'emergency_kit' => 'boolean',
        'documents' => 'boolean'
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
