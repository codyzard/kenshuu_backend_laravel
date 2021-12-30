<?php

namespace App\Policies;

use App\Article;
use App\Author;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function create(Author $author, $article)
    {
        return $author && $article instanceof Article;
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
