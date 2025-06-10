<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsaAnalisis extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function isa()
    {
        return $this->belongsTo(Isa::class);
    }
}
