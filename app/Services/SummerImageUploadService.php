<?php

namespace App\Services;

use Intervention\Image\Facades\Image;

class SummerImageUploadService
{
    /*
    Transform the base 64 image to webp
    and upload save it to the storage/images folder
    reference  -> https://www.positronx.io/how-to-upload-image-in-laravel-using-summernote-editor/
    */
    public static function transformUpload($description)
    {
        $dom = new \DOMDocument();
        // include @ sign to escape warning
        @$dom->loadHTML($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $imageFile = $dom->getElementsByTagName('img');

        foreach ($imageFile as $item => $image) {

            $name = $image->getAttribute('data-filename');
            $plainName = substr($name, 0, strrpos($name, ".")); // get the filename without extension

            $image_name = uniqid() . $name;
            $displayPath = url('/storage/images/' .  $image_name); // atual path to display image
            $image_path = public_path('/storage/images/') . $image_name; // path for saving image

            $data = $image->getAttribute('src');
            list($type, $data) = explode(';', $data); // get data and type from data
            list(, $data)      = explode(',', $data); // change the data again to decode it
            $imageData = base64_decode($data);

            file_put_contents($image_path, $imageData); // save the image as its original extension

            $img = Image::make($image_path); // creates a new image source using image intervention package
            $img->save($image_path, 0); // save the image with a medium quality

            $image->removeAttribute('src');
            $image->removeAttribute('style');
            $image->setAttribute('alt', $plainName); // set alt attribute
            $image->setAttribute('src', $displayPath);
            $image->setAttribute('loading', 'lazy'); // includes lazy loading
            $image->setAttribute('class', 'rounded-lg mx-auto max-h-[25rem]'); // includes tailwind classes
        }

        $description = $dom->saveHTML();

        return $description;
    }
}
