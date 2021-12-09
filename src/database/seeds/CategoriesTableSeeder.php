<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'モバイル',
            'アプリ',
            'エンタメ',
            'ビューティー',
            'ファッション',
            'ライフスタイル',
            'ビジネス',
            'グルメ',
            'スポーツ'
        ];

        foreach ($categories as $c) {
            Category::create(['category_name' => $c]);
        }
    }
}
