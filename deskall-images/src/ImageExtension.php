<?php 

use SilverStripe\Core\Extension;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Control\Director;

class ImageExtension extends Extension
{

    /**
     * @var array
     * @config
     */
    // private static $default_arguments = [600];

    /**
     * @var string
     * @config
     */
    // private static $default_method = 'ScaleWidth';

    /**
     * @var string
     * @config
     */
    private static $default_css_classes = '';

    /**
     * @var array A cached copy of the image sets
     */
    // protected $configSets;

    protected $uikit;


    // /**
    //  * {@inheritdoc}
    //  */
    // public function __construct()
    // {
    //     parent::__construct();
    //     $this->configSets = Config::inst()->get(__CLASS__, 'sets') ?: [];
    // }

    private static $db = [
        'Description' => 'Text',
        'Optimised' => 'Boolean(0)'
    ];


    public function onAfterUpload(){

        //Publish
        $this->owner->publishSingle();
        if ($this->owner->config()->get('optimise_tiny') && !$this->owner->Optimised){
            //Optimise via TinyPNG API
            $this->OptimiseImage(Director::absoluteURL($this->owner->getSourceURL()), $_SERVER['DOCUMENT_ROOT']."public/".$this->owner->getSourceURL());
            $this->owner->Optimised = 1;
            $this->owner->write();
        }
        
        //Resize image to fit max Width and Height before resampling
        // $width = $this->owner->config()->get('MaxWidth');
        // $height = $this->owner->config()->get('MaxHeight');
        // $backend = $this->owner->getImageBackend();
        // $resource = $backend->getImageResource();
        // if ($this->owner->getExtension() != "svg"){
        //     if ($width >= $height){
        //         $resource->widen($width,function ($constraint) {
        //             $constraint->upsize();
        //         });
        //     }
        //     if ($height > $width){
        //         $resource->heighten($width,function ($constraint) {
        //             $constraint->upsize();
        //         });
        //     }
        // }
        
        // $backend->setImageResource($resource);
    }


   
    //  * A wildcard method for handling responsive sets as template functions,
    //  * e.g. $MyImage.ResponsiveSet1
    //  *
    //  * @param string $method The method called
    //  * @param array $args The arguments passed to the method
    //  * @return HTMLText
    
    // public function __call($method, $args)
    // {
    //     if ($config = $this->getConfigForSet($method)) {
    //         return $this->createResponsiveSet($config, $args, $method);
    //     }
    // }

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

    // /**
    //  * Requires the necessary JS and sends the required HTML structure to the
    //  * template for a responsive image set.
    //  *
    //  * @param array $config The configuration of the responsive image set
    //  * @param array $defaultArgs The arguments passed to the responsive image
    //  *                           method call, e.g. $MyImage.ResponsiveSet(800x600)
    //  * @param string $set The method, or responsive image set, to generate
    //  * @return SSViewer
    //  */
    // protected function createResponsiveSet($config, $defaultArgs, $set)
    // {
    //     // Requirements::javascript(RESPONSIVE_IMAGES_DIR . '/javascript/picturefill/picturefill.min.js');

    //     if (!isset($config['arguments']) || !is_array($config['arguments'])) {
    //         throw new Exception("Responsive set $set does not have any arguments defined in its config.");
    //     }

    //     if (empty($defaultArgs)) {
    //         if (isset($config['default_arguments'])) {
    //             $defaultArgs = $config['default_arguments'];
    //         } else {
    //             $defaultArgs = Config::inst()->get(__CLASS__, 'default_arguments');
    //         }
    //     }

    //     if (isset($config['method'])) {
    //         $methodName = $config['method'];
    //     } else {
    //         $methodName = Config::inst()->get(__CLASS__, 'default_method');
    //     }


    //     if (!$this->owner->hasMethod($methodName)) {
    //         throw new RuntimeException(get_class($this->owner) . ' has no method ' . $methodName);
    //     }

    //     //fallbakc for title and alt tags
    //     $fallback = (empty($defaultArgs)) ? null : end($defaultArgs);
    //     $uikit = (isset($config['uikit'])) ? $config['uikit'] : null;


    //     // Create the resampled images for each query in the set
    //     $sizes = ArrayList::create();
    //     //Specific for slide
    //     if ($set == "slides"){
    //         $slide = DataObject::get_by_id('Slide',reset($defaultArgs));
    //         if (!$slide){
    //             throw new Exception("Responsive set $set doesn't have the correct arguments provided for the slide ID");
    //         }

    //         // If methode slide we calculate the ration


    //         $ratio = ($slide->Image()->ID > 0) ? $slide->Image()->getWidth() / $slide->Image()->getHeight() : 1;

    //         $MaxHeight = $slide->Parent()->MaxHeight;
    //         $MinHeight = $slide->Parent()->MinHeight;

    //         foreach ($config['arguments'] as $query => $args) {
    //             if (is_numeric($query) || !$query) {
    //                 throw new Exception("Responsive set $set has an empty media query. Please check your config format");
    //             }

    //             if (!is_array($args) || empty($args)) {
    //                 throw new Exception("Responsive set $set doesn't have any arguments provided for the query: $query");
    //             }
    //             $height = $args[0] / $ratio;
    //             //Special dimension for retina screen
    //             if (strpos($query,'min-device-pixel-ratio: 2') > 0){
    //                 $height = ($height > $MaxHeight * 2) ? $MaxHeight * 2 : $height;
    //                 $height = ($height < $MinHeight * 2) ? $MinHeight * 2 : $height;
    //             }
    //             else
    //             {
    //                 $height = ($height > $MaxHeight ) ? $MaxHeight : $height;
    //                 $height = ($height < $MinHeight ) ? $MinHeight : $height;
    //             }
    //             //+ 50 To fit all screen pixels
    //             $args[1] = $height + 50;

    //             $sizes->push(ArrayData::create([
    //                 'Image' => $this->getResampledImage($methodName, $args),
    //                 'Query' => $query
    //             ]));
    //         }
          
    //         //reset default
    //         $defaultArgs = [];
    //         $defaultArgs[0] = $config['default_arguments'][0];
    //         $defaultArgs[1] = $defaultArgs[0] / $ratio;
    //     }
    //     elseif ($set == "content"){
    //         $image = DataObject::get_by_id(Image::class,reset($defaultArgs));
    //         if (!$image){
    //             throw new Exception("Responsive set $set doesn't have the correct arguments provided for the image ID");
    //         }

    //         // If methode slide we calculate the ration
    //         $ratio = $image->getWidth() / $image->getHeight();

    //         foreach ($config['arguments'] as $query => $args) {
    //             if (is_numeric($query) || !$query) {
    //                 throw new Exception("Responsive set $set has an empty media query. Please check your config format");
    //             }

    //             if (!is_array($args) || empty($args)) {
    //                 throw new Exception("Responsive set $set doesn't have any arguments provided for the query: $query");
    //             }
    //             $height = $args[0] / $ratio;
    //             $args[1] = $height;
    //             $sizes->push(ArrayData::create([
    //                 'Image' => $this->getResampledImage($methodName, $args),
    //                 'Query' => $query
    //             ]));
    //         }
            
    //         //reset default
    //         $defaultArgs = [];
    //         $defaultArgs[0] = $config['default_arguments'][0];
    //         $defaultArgs[1] = $defaultArgs[0] / $ratio;
    //     }
    //     elseif ($set == "overlays" || $set == "banners"){
    //         $ratio = $defaultArgs[0] / $defaultArgs[1];

    //         foreach ($config['arguments'] as $query => $args) {
    //             if (is_numeric($query) || !$query) {
    //                 throw new Exception("Responsive set $set has an empty media query. Please check your config format");
    //             }

    //             if (!is_array($args) || empty($args)) {
    //                 throw new Exception("Responsive set $set doesn't have any arguments provided for the query: $query");
    //             }
    //             $height = $args[0] / $ratio;
    //             $args[1] = $height + 50;
    //             $sizes->push(ArrayData::create([
    //                 'Image' => $this->getResampledImage($methodName, $args),
    //                 'Query' => $query
    //             ]));
    //         }
          
    //         //reset default
    //         $defaultArgs = [];
    //         $defaultArgs[0] = $config['default_arguments'][0];
    //         $defaultArgs[1] = $defaultArgs[0] / $ratio;
    //     }
    //     else{
            
    //         foreach ($config['arguments'] as $query => $args) {
    //             if (is_numeric($query) || !$query) {
    //                 throw new Exception("Responsive set $set has an empty media query. Please check your config format");
    //             }

    //             if (!is_array($args) || empty($args)) {
    //                 throw new Exception("Responsive set $set doesn't have any arguments provided for the query: $query");
    //             }
              
               
    //             $sizes->push(ArrayData::create([
    //                 'Image' => $this->getResampledImage($methodName, $args),
    //                 'Query' => $query
    //             ]));
    //         }
    //     }
    //     return $this->owner->customise([
    //         'Sizes' => $sizes,
    //         'DefaultImage' => $this->getResampledImage($methodName, $defaultArgs)
    //     ])->renderWith('Includes/ResponsiveImageSet', ['uikitAttr' => $uikit,'altTag' => $this->AltTag($fallback), 'titleTag' => $this->TitleTag($fallback) ]);
    // }

    // /**
    //  * Return a resampled image equivalent to $Image.MethodName(...$args) in a template
    //  *
    //  * @param string $methodName
    //  * @param array $args
    //  * @return Image
    //  */
    // protected function getResampledImage($methodName, $args)
    // {
    //     return call_user_func_array([$this->owner, $methodName], $args);
    // }

    // /**
    //  * Due to {@link Object::allMethodNames()} requiring methods to be expressed
    //  * in all lowercase, getting the config for a given method requires a
    //  * case-insensitive comparison.
    //  *
    //  * @param string $setName The name of the responsive image set to get
    //  * @return array|false
    //  */
    // protected function getConfigForSet($setName)
    // {
    //     $name = strtolower($setName);
    //     $sets = array_change_key_case($this->configSets, CASE_LOWER);

    //     return (isset($sets[$name])) ? $sets[$name] : false;
    // }

    // /**
    //  * Returns a list of available image sets.
    //  *
    //  * @return array
    //  */
    // protected function getResponsiveSets()
    // {
    //     return array_map('strtolower', array_keys($this->configSets));
    // }

    // /**
    //  * Defines all the methods that can be called in this class.
    //  *
    //  * @return array
    //  */
    // public function allMethodNames()
    // {
    //     return $this->getResponsiveSets();
    // }



    //Optimise with tynigPNG

    public function OptimiseImage($url,$path){
        $optimiser = new DeskallImageOptimiser();
        $optimiser->Optimise($url,$path);
    }


}