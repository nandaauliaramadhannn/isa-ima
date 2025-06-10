<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Isa extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function analisis()
    {
        return $this->hasMany(IsaAnalisis::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
