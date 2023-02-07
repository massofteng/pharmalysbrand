<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $table = 'languages';

    protected $guarded = ['id'];

    public function country(){
        return $this->hasOne(Country::class,'id','country_id');
    }
}
