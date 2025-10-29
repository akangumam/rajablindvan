<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{
    protected $fillable = [
        'original_name',
        'stored_name',
        'file_path',
        'mime_type',
        'file_size',
        'file_type',
        'category'
    ];

    /**
     * Get human readable file size
     */
    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Get file icon class
     */
    public function getFileIconAttribute()
    {
        $icons = [
            'pdf' => 'fa-file-pdf',
            'excel' => 'fa-file-excel',
            'word' => 'fa-file-word',
            'image' => 'fa-file-image',
            'video' => 'fa-file-video',
            'audio' => 'fa-file-audio',
            'archive' => 'fa-file-archive',
            'code' => 'fa-file-code',
        ];

        return $icons[$this->file_type] ?? 'fa-file';
    }
}
