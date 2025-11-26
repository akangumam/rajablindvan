<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleDocument extends Model
{
    protected $fillable = [
        'vehicle_id',
        'document_name',
        'document_path',
        'document_type',
        'file_type',
        'file_size',
    ];

    /**
     * Relationship to Vehicle
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get formatted file size
     */
    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) {
            return '0 KB';
        }

        $bytes = $this->file_size;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        
        return $bytes . ' bytes';
    }

    /**
     * Get file icon based on file type
     */
    public function getFileIconAttribute(): string
    {
        return match($this->file_type) {
            'pdf' => 'fas fa-file-pdf text-danger',
            'image' => 'fas fa-file-image text-primary',
            'word' => 'fas fa-file-word text-info',
            'excel' => 'fas fa-file-excel text-success',
            default => 'fas fa-file text-secondary',
        };
    }
}
