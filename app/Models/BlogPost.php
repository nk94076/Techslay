<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class BlogPost extends Model
{
    protected static string $table = 'blog_posts';
    protected static bool $softDeletes = true;
}
