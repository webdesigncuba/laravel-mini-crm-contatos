<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Database\Factories\ContactFactory;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'score',
        'status',
        'processed_at',
    ];

    protected $casts = [
        'score'        => 'integer',
        'processed_at' => 'datetime',
    ];


    protected static function newFactory()
    {
        return ContactFactory::new();
    }
}
