<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutBlockContent extends Model
{
    use HasFactory;

    protected $table = 'about_block_contents';

    protected $guarded = ['id'];

    protected $casts = ['content' => Json::class];
}
