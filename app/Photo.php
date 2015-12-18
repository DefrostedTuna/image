<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Helper\Table;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class Photo extends Model
{
    protected $table = 'photos';

    protected $fillable = ['name', 'description', 'path', 'thumb_path', 'mime_type', 'slug'];

    /**
     * Checks to see whether the slug passed is unique
     *
     * @param $slug
     * @return bool
     */
    public static function isSlugUnique($slug) {
        if(!Photo::where('slug', '=', $slug)->first()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Generates a random string and then checks the database to see if it is unique.
     *
     * @param $number
     * @return string
     */
    public static function generateUniqueSlug($number) {
        do {
            $slug = str_random($number);
        } while (!Photo::isSlugUnique($slug)); //While slug is not unique

        return $slug;
    }

    /**
     * Find photo based on slug passed into url
     *
     * @param $slug
     * @return mixed
     * @throws FileNotFoundException
     */
    public function findBySlug($slug) {
        $obj = $this->where('slug', $slug)->first();
        if(!$obj) {
            throw new FileNotFoundException('The file ' . $slug . ' was not found.');
        }
        return $obj;
    }
}
