<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\Author;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function create(Author $author, $article)
    {
        // return $author && $article instanceof Article;
        return true;
    }

    public function update(Author $author, Article $article)
    {
        return $author->id == $article->author_id;
    }

    public function delete(Author $author, Article $article)
    {
        return $author->id = $article->author_id;
    }
}
