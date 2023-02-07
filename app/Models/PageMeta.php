<?php

namespace App\Models;

use App\Casts\MetaValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageMeta extends Model
{
    use HasFactory;

    protected $table = "page_meta";

    protected $guarded = ['id'];

    protected $casts = [
        'value' => MetaValue::class,
    ];
}
