<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
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

        /*
        Apply class prettyprint on all the pre tags from the description
        in order to let the code prettifier to style it.
        */
        $preTags = $dom->getElementsByTagName('pre');
        foreach ($preTags as $item => $pre) {
            $pre->setAttribute('class', 'prettyprint');
        }

        $imageFile = $dom->getElementsByTagName('img'); // get all the image tags

        foreach ($imageFile as $item => $image) {

            $name = $image->getAttribute('data-filename');
            $plainName = substr($name, 0, strrpos($name, ".")); // get the filename without extension

            $image_name = random_int(1000000000, 9999999999) . $name; // unique image name
            $displayPath = url('/storage/images/' .  $image_name); // actual path to display image
            $image_path = public_path('/storage/images/') . $image_name; // path for saving image

            $data = $image->getAttribute('src');
            list($type, $data) = explode(';', $data); // get data and type from data
            list(, $data)      = explode(',', $data); // change the data again to decode it
            $imageData = base64_decode($data);

            file_put_contents($image_path, $imageData); // save the image as its original extension

            $img = Image::make($image_path); // creates a new image source using image intervention package
            $img->save($image_path, 50); // save the image with a medium quality

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

    /*
    editTransformUpload works exaclty the same as transformUpload
    except for its additional feature of detecting the deleted images inside
    the description of the submitted article for edit
    */
    public static function editTransformUpload($description, $newDescription)
    {
        /*
        For checking if there are excluded images in description that are already
        uploaded to the server, two dodocument variables will be initialized and 
        checked for difference
        */

        // domdocument for old description
        $dom = new \DOMDocument();
        @$dom->loadHTML($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD); // include @ sign to escape warning
        $imageFile = $dom->getElementsByTagName('img');

        $oldDescriptionImages = []; // all the image names of the old description

        foreach ($imageFile as $item => $image) {

            if ($image->hasAttribute('class')) {
                $imageHref = $image->getAttribute('src');
                $imageName = substr($imageHref, strrpos($imageHref, '/') + 1); // get the image name with extension
                $oldDescriptionImages[] = $imageName;
            }
        }

        //domdocument for new description
        $domNew = new \DOMDocument();
        @$domNew->loadHTML($newDescription, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD); // include @ sign to escape warning
        
        /*
        If the pre tag does not have class attribute, apply class 
        prettyprint on all the pre tags from the description
        in order to let the code prettifier to style it.
        */
        $preTags = $domNew->getElementsByTagName('pre');
        foreach ($preTags as $item => $pre) {
            if ($pre->hasAttribute('class')) { // if the pre tag has the class avoid proceeding furthers
                continue;
            }
            $pre->setAttribute('class', 'prettyprint');
        }

        $imageFileNew = $domNew->getElementsByTagName('img');

        $newDescriptionImages = []; // all the image names of the old description

        foreach ($imageFileNew as $item => $image) {

            if ($image->hasAttribute('class')) {
                $imageHref = $image->getAttribute('src');
                $imageName = substr($imageHref, strrpos($imageHref, '/') + 1); // get the image name with extension
                $newDescriptionImages[] = $imageName;
            }
        }

        // if excluded image detected, delete those images from the server
        if ($diffImages = array_diff($oldDescriptionImages, $newDescriptionImages)) {

            foreach ($diffImages as $diffImage) {
                if (File::exists(public_path('/storage/images/') . $diffImage)) {
                    File::delete(public_path('/storage/images/') . $diffImage);
                }
            }
        }

        foreach ($imageFileNew as $item => $image) {

            // if image is already uploaded to the server skip the image
            if ($image->hasAttribute('class')) {
                continue;
            }

            $name = $image->getAttribute('data-filename');
            $plainName = substr($name, 0, strrpos($name, ".")); // get the filename without extension

            $image_name = random_int(1000000000, 9999999999) . $name; // unique image name
            $displayPath = url('/storage/images/' .  $image_name); // actual path to display image
            $image_path = public_path('/storage/images/') . $image_name; // path for saving image

            $data = $image->getAttribute('src');
            list($type, $data) = explode(';', $data); // get data and type from data
            list(, $data)      = explode(',', $data); // change the data again to decode it
            $imageData = base64_decode($data);

            file_put_contents($image_path, $imageData); // save the image as its original extension

            $img = Image::make($image_path); // creates a new image source using image intervention package
            $img->save($image_path, 50); // save the image with a medium quality

            $image->removeAttribute('src');
            $image->removeAttribute('style');
            $image->setAttribute('alt', $plainName); // set alt attribute
            $image->setAttribute('src', $displayPath);
            $image->setAttribute('loading', 'lazy'); // includes lazy loading
            $image->setAttribute('class', 'rounded-lg mx-auto max-h-[25rem]'); // includes tailwind classes
        }

        $description = $domNew->saveHTML();

        return $description;
    }
}
