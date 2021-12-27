<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'season_id', 
        'episode_number'
    ];

    public function stream()
    {
        return $this->morphOne(StreamUrl::class, 'streamable');
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function getVideo()
    {
        return url('storage/' . $this->stream->url);
    }
}
