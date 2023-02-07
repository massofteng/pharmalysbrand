<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';
    
    protected $guarded = ['id'];

    public function continent(){
        return $this->hasOne(Continent::class,'id','continent_id');
    }

    public function languages(){
        return $this->hasMany(Language::class);
    }
}
