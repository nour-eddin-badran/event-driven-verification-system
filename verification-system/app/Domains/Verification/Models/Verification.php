<?php

namespace App\Domains\Verification\Models;

use BinaryCabin\LaravelUUID\Traits\HasUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory, HasUUID;

    protected $primaryKey = 'uuid';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'uuid', 'identity', 'type', 'confirmed', 'confirmed_at', 'is_expired', 'code', 'attempts_count', 'user_info'
    ];

    protected $casts = [
      'user_info' => 'array',
      'confirmed' => 'bool'
    ];
}
