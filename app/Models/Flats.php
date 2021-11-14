<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flats extends Model
{
    use HasFactory;
//    На будущее, в этом проекте сделал все через left join
//    public function area()
//    {
//        return $this->belongsTo(Area::class);
//    }
//
//    public function city()
//    {
//        return $this->belongsTo(City::class);
//    }
//
//    public function company()
//    {
//        return $this->belongsTo(Company::class);
//    }
}
