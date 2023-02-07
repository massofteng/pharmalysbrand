<?php

namespace App\Post;

use App\Models\AnonymousPost;

class GetPost implements PostInterface
{
    public function getPost($pos)
    {
        AnonymousPost::where('is_published', 1)->where('post_position', $pos)->first();
    }
}
