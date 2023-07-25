<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    // RULES
    public static $rules = [
        'deezer_id' => 'required | unique:tracks',
        'youtube_id' => 'required',
        'title' => 'required',
        'duration' => 'required',
        'position' => 'required',
    ];

    protected $fillable = [
        'deezer_id',
        'youtube_id',
        'title',
        'title_short',
        'duration',
        'position',
        'disk_number',
        'release_date',
        'preview',
        'md5_image',
        'searchable',
    ];

    public $timestamps = false;
}
