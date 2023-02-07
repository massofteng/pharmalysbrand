<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageBlockContent extends Model
{
    use HasFactory;

    protected $table = 'page_block_contents';

    protected $guarded = ['id'];

    protected $casts = ['content' => Json::class];
}
