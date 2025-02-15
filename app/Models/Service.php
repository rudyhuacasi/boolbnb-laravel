<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;


    //? relazione molti a molti con HOMES:
    public function homes()
    {
        return $this->belongsToMany(Home::class);
    }
}
