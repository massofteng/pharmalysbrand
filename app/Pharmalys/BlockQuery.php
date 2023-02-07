<?php

namespace App\Pharmalys;

use App\Models\PageBlock;
use Illuminate\Database\Eloquent\Collection;

class BlockQuery
{
    private static $instance;

    private Collection $blocks;

    private ?PageBlock $block;

    private static string $pageName = '';

    public function __construct(string $pageName)
    {
        $this->block = null;

        self::$pageName = $pageName;
        $this->getPageBlocks();
    }

    /**
     * initialized BlockQuery class
     *
     * @param  string  $pageName
     * @return BlockQuery
     */
    public static function init(string $pageName): BlockQuery
    {
        if (request()->query('refresh')) {
            self::$instance = null;
        }

        if (! self::$instance || self::$pageName != $pageName) {
            self::$instance = new BlockQuery($pageName);
        }

        return self::$instance;
    }

    /**
     * query page blocks
     *
     * @return void
     */
    private function getPageBlocks(): void
    {
        $this->blocks = PageBlock::query()->with(['block_content:id,block_id,content'])
            ->lang()
            ->published()
            ->orderBy('display_order')
            ->get();
    }

    /**
     * query by block type
     *
     * @param  string  $type
     * @return BlockQuery
     */
    public function typeOf(string $type, string $title = null)
    {
        $query = $this->blocks->where('block_type', $type);

        if ($title) {
            $query = $query->where('title', $title);
        }

        $this->block = $query->first();

        // if ($block) {
        //     $this->block = $this->blocks->where('block_type', $type)->first();
        // }

        return $this;
    }

    /**
     * get all the contents
     *
     * @return array
     */
    public function getContents()
    {
        if (! $this->block) {
            return [];
        }

        $content = $this->block->block_content;

        if ($content) {
            return $content->content;
        }

        return [];
    }

    /**
     * get single content
     *
     * @param  int  $index
     * @return array
     */
    public function getContent($index = 0)
    {
        if (! $this->block) {
            return [];
        }
        $content = $this->block->block_content;

        if ($content) {
            if (count($content->content) > 0) {
                return $content->content[$index];
            }
        }

        return [];
    }

    /**
     * get block title
     *
     * @return string
     */
    public function getTitle($default = '')
    {
        if ($this->block) {
            return $this->block->title;
        }

        return $default;
    }
}
