<?php

use App\ArticleCategory;
use Illuminate\Database\Seeder;

class ArticlesCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ArticleCategory::create([
            'article_id' => '1',
            'category_id' => '1',
        ]);

        ArticleCategory::create([
            'article_id' => '1',
            'category_id' => '2',
        ]);

        ArticleCategory::create([
            'article_id' => '1',
            'category_id' => '3',
        ]);

        ArticleCategory::create([
            'article_id' => '2',
            'category_id' => '4',
        ]);

        ArticleCategory::create([
            'article_id' => '2',
            'category_id' => '5',
        ]);

        ArticleCategory::create([
            'article_id' => '2',
            'category_id' => '6',
        ]);
    }
}
