<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;


    //? relazione molti a molti con HOME:
    public function homes()
    {
        return $this->belongsToMany(Home::class, 'ad_home')
            ->withPivot('ad_id', 'home_id', 'created_at', 'updated_at');
    }
}
