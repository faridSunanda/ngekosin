<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kos extends Model
{
    use HasFactory;

    protected $table = 'koses';

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'type',
        'address',
        'google_maps_url',
        'province',
        'city',
        'district',
        'village',
        'price_per_month',
        'price_per_day',
        'price_per_week',
        'allow_two_people',
        'price_2_persons',
        'total_rooms',
        'available_rooms',
        'description',
        'facilities',
        'thumbnail',
        'images',
        'status',
        'views_count',
        'clicks_count',
    ];

    protected $casts = [
        'facilities' => 'array',
        'images' => 'array',
        'price_per_month' => 'integer',
        'price_per_day' => 'integer',
        'price_per_week' => 'integer',
        'allow_two_people' => 'boolean',
        'price_2_persons' => 'integer',
        'total_rooms' => 'integer',
        'available_rooms' => 'integer',
        'views_count' => 'integer',
        'clicks_count' => 'integer',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function campuses()
    {
        return $this->belongsToMany(Campus::class, 'campus_kos')
                    ->withPivot('distance_meters')
                    ->withTimestamps();
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price_per_month, 0, ',', '.');
    }

    public function getFormattedPriceDayAttribute(): ?string
    {
        return $this->price_per_day ? 'Rp ' . number_format($this->price_per_day, 0, ',', '.') : null;
    }

    public function getFormattedPriceWeekAttribute(): ?string
    {
        return $this->price_per_week ? 'Rp ' . number_format($this->price_per_week, 0, ',', '.') : null;
    }

    public function getFormattedPrice2PersonsAttribute(): ?string
    {
        return $this->price_2_persons ? 'Rp ' . number_format($this->price_2_persons, 0, ',', '.') : null;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kos) {
            if (empty($kos->slug)) {
                $kos->slug = Str::slug($kos->name) . '-' . Str::random(5);
            }
        });
    }
}
