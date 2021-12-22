<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreamUrl extends Model
{
    use HasFactory;

    protected $fillable = ['url'];

    public function streamable()
    {
        return $this->morphTo();
    }
}
