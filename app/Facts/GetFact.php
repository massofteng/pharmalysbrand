<?php

namespace App\Facts;

use App\Models\Home;
use App\Facts\FactInterface;

class GetFact implements FactInterface
{
    public $model;
    public function __construct(Home $model)
    {
        $this->model = $model;
    }

    public function getData($type = null)
    {
        if ($type == 'banner-slider') {
            return $this->model::where('is_published', 1)
                ->where('block_type', 'banner-slider')
                ->orderBy('id', 'DESC')
                ->first();
        }

        return  $this->model::where('is_published', 1)
            ->where('block_type', $type)
            ->orderBy('id', 'DESC')
            ->get();
    }
}
