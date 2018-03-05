<?php 

use SilverStripe\Core\Extension;

class ImageExtension extends Extension
{

    private static $db = [
        'Description' => 'Text'
    ];

    public function AltTag($fallback = null){
        $text = ($this->owner->Description) ? $this->owner->Description : (($fallback) ? $fallback : $this->owner->Name);
        $text = strip_tags(preg_replace( "/\r|\n/", "", $text ));
        $title = ($fallback) ? $fallback : $this->owner->Name;
       
        return $text;
    }

    public function TitleTag($fallback = null){
        $title = ($fallback) ? $fallback : $this->owner->Name;
        
        return $title;
    }

    public function onAfterUpload(){

        //Resize image to fit max Width and Height before resampling
        $width = $this->owner->config()->get('MaxWidth');
        $height = $this->owner->config()->get('MaxHeight');
        $backend = $this->owner->getImageBackend();
        $resource = $backend->getImageResource();
        if ($width >= $height){
            $resource->widen($width,function ($constraint) {
                $constraint->upsize();
            });
        }
        if ($height > $width){
            $resource->heighten($width,function ($constraint) {
                $constraint->upsize();
            });
        }
        
        $backend->setImageResource($resource);
    
    }


}