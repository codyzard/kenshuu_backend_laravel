<?php

use App\Image;
use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Image::create([
            'src' => 'article-1.jpg',
            'article_id' => 1,
        ]);

        Image::create([
            'src' => 'article-2.png]',
            'article_id' => 2,
        ]);

        Image::create([
            'src' => 'article-3.jpg',
            'article_id' => 3,
        ]);
    }
}
