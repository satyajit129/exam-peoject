<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $guardrd = [];
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
