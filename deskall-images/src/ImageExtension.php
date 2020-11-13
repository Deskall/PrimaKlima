<?php 

use SilverStripe\Core\Extension;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Control\Director;
use SilverStripe\Core\Environment;

class ImageExtension extends Extension
{

    private static $db = [
        'Description' => 'HTMLText',
        'Optimised' => 'Boolean(0)'
    ];

    public function Square($width){
        $variant = $this->owner->variantName(__FUNCTION__, $width);
        return $this->owner->manipulateImage($variant, function (\SilverStripe\Assets\Image_Backend $backend) use($width) {
            $clone = clone $backend;
            $resource = clone $backend->getImageResource();
            $resource->fit($width);
            $clone->setImageResource($resource);
            return $clone;
        });
    }


    public function onAfterUpload(){

        //Publish
        $this->owner->publishSingle();

        //Create the WebP
        if (function_exists('imagewebp')) {
            ob_start();
            print_r('start webp');
            $result = ob_get_clean();
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
            $stream = $this->owner->File->getStream();
            ob_start();
            print_r($stream);
            $result = ob_get_clean();
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result, FILE_APPEND);

            $filename = $this->owner->File->getString();
            ob_start();
            print_r($filename);
            $result = ob_get_clean();
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result, FILE_APPEND);

            $webpName = $this->owner->createWebPName($filename);

            ob_start();
                        print_r($webpName);
                        $result = ob_get_clean();
                        file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result, FILE_APPEND);

            imagewebp($stream, $webpName, 90);

            imagedestroy($stream);
        }
    }

    public function createWebPName($filename)
    {
        $picname = pathinfo($filename, PATHINFO_FILENAME);
        $directory = pathinfo($filename, PATHINFO_DIRNAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        return $directory.'/'.$picname.'_'.$extension.'.webp';
    }

    public function AltTag($fallback = null){
        $text = ($this->owner->Description) ? $this->owner->Description : (($fallback) ? $fallback : $this->owner->Name);
        $text = strip_tags(preg_replace( "/\r|\n/", "", $text ));       
        return $text;
    }

    public function TitleTag($fallback = null){
        $title = ($fallback) ? $fallback : $this->owner->Name;
        
        return $title;
    }

    public function HeightForWidth($width){

        return ($this->owner->exists()) ? round($width / ($this->owner->getWidth() / $this->owner->getHeight()) , 0) : 0;
    }

}