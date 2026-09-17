<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    use HasFactory;

    protected $table = 'campuses';

    protected $fillable = [
        'name',
        'abbreviation',
        'city',
    ];

    public function koses()
    {
        return $this->belongsToMany(Kos::class, 'campus_kos')
                    ->withPivot('distance_meters')
                    ->withTimestamps();
    }
}
