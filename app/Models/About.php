<?php

namespace App\Models;

use App\Models\AboutBlockContent;
use App\Models\Scopes\LanguageScope;
use Illuminate\Support\Facades\Lang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class About extends Model
{
    use HasFactory;

    protected $table = 'abouts';

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addGlobalScope(new LanguageScope);
    }

    public function contents()
    {
        return $this->hasMany(AboutBlockContent::class, 'block_id');
    }

    public function block_content()
    {
        return $this->hasOne(AboutBlockContent::class, 'block_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function children()
    {
        return $this->hasMany(PageBlock::class, 'parent_id');
    }

    public function scopeTypedBlock($query, $type)
    {
        return $query->where('block_type', $type);
    }

    public function scopeLang($query)
    {
        $lang = Lang::getLocale();

        return $query->where('lang', $lang);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->where('published_at', '<=', now());
    }
}
