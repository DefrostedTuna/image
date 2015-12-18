<?php

use Illuminate\Database\Seeder;

class PhotoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('photos')->insert([
            'name' => str_random(10),
            'desc' => str_random(10),
            'path' => 'path',
            'thumb_path' => 'thumb_path',
            'mime_type' => 'mime_type',
            'slug' => 'slug'
        ]);
    }
}
