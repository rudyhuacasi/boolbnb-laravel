<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    //? mass update:
    protected $guarded = ['id'];



    //? relazione uno a molti con HOMES:
    public function home()
    {
        return $this->belongsTo(Home::class);
    }
}
