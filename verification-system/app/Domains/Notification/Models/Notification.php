<?php

namespace App\Domains\Notification\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Notification extends Model
{
    use HasFactory, Notifiable;

    public $email;

    protected $fillable = [
        'recipient', 'channel', 'body', 'dispatched'
    ];
}
