<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostBlock extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'content' => AsCollection::class,
    ];
}
