<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Home extends Model
{
    use HasFactory;

     //? mass update:
     protected $guarded = ['id'];

     // protected $fillable = [''];


     //? appendiamo un nuovo campo per le immagini:
    protected $appends = ['image_frontend'];

    //? con mutators & casting creiamo un nuovo campo per le immagini:
    protected function imageFrontend(): Attribute
    {
        return new Attribute(

                get: fn() => $this->image ? env('APP_FRONTEND_IMG_URL', 'http.//localhost') . $this->image : null,

        );
    }


     //? relazione molti a molti con ADS:
     public function ads()
    {
        return $this->belongsToMany(Ad::class, 'ad_home')
            ->withPivot('ad_id', 'home_id', 'created_at', 'updated_at');
    }

    //? relazione uno a molti con USER:
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //? relazione uno a molti con MESSAGES:
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    //? relazione molti a molti con SERVICES:
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    //? relazione uno a molti con VISUALS:
    public function visuals()
    {
        return $this->hasMany(Visual::class);
    }


}
