<?php

namespace App\Services;

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
        $dom->loadHTML($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $imageFile = $dom->getElementsByTagName('img');

        foreach ($imageFile as $item => $image) {
            
            $name = $image->getAttribute('data-filename');
            $image_name = uniqid() . $name; 
            $display_path = url('/storage/images/' .  $image_name); // atual path to display image
            $image_path = public_path('/storage/images/') . $image_name; // path for saving image

            $data = $image->getAttribute('src');
            list($type, $data) = explode(';', $data); // get data and type from data
            list(, $data)      = explode(',', $data); // change the data again to decode it
            $imageData = base64_decode($data);
            
            file_put_contents($image_path, $imageData); // save the image as its original extension

            $image->removeAttribute('src');
            $image->setAttribute('src', $display_path);
            $image->setAttribute('loading', 'lazy'); // includes lazy loading
            $image->setAttribute('class', 'summer-image'); // includes a class to identify as an image uploaded by summernote
        }

        $description = $dom->saveHTML();

        return $description;
    }
}