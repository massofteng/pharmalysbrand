<?php

namespace App\Stories;

use App\Models\Story;

class GetStory implements StoryInterface
{
    public $model;
    public function __construct(Story $model)
    {
        $this->model = $model;
    }

    public function getData($category_id)
    {
        if ($category_id == 0) {
            return $this->model::where('is_published', 1)->get();
        }
        return $this->model::where('is_published', 1)->where('category_id', $category_id)->get();
    }
}
