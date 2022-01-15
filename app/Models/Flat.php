<?php

namespace App\Models;

use App\Services\Settings\FlatsSettings;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Flat extends Model
{
    use HasFactory;

    public function area() {
        return $this->belongsTo(Area::class);
    }

    public function city() {
        return $this->belongsTo(City::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function scopeWithAll(Builder $query) {
        return $query->with((new FlatsSettings())->getRelations());
    }
}
