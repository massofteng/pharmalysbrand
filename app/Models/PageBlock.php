<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class PageBlock extends Model
{
    use HasFactory;

    protected $table = 'page_blocks';

    protected $guarded = ['id'];

    public function contents()
    {
        return $this->hasMany(PageBlockContent::class, 'block_id');
    }

    public function block_content()
    {
        return $this->hasOne(PageBlockContent::class, 'block_id');
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
