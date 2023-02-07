<?php

namespace App\Models;

use App\Models\Scopes\LanguageScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partners extends Model
{
    use HasFactory;

    protected $table = 'partners';

    protected $guarded = ['id'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new LanguageScope);
    }
}
