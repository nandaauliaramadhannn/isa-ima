<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImaAnalisis extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function ima()
    {
        return $this->belongsTo(Ima::class);
    }
}
