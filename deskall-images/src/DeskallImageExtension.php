
<?php
use SilverStripe\Core\Extension;
use SilverStripe\Core\Config\Config_ForClass;
use SilverStripe\Core\Config\Config;


class DeskallImageExtension extends Extension
{

    private static $db = [
        'Description' => 'Text'
    ];

    private static $defaults = array(
        //Preserve default behaviour of cropping from center
        'FocusX' => '0',
        'FocusY' => '0',
        'Description' => ''
    );

	// /**
 //     * @var
 //     */
 //    protected $config;

 //    /**
 //     * @param Config_ForClass $config
 //     */
 //    public function __construct(Config_ForClass $config = null)
 //    {
 //        parent::__construct();
    
 //        if ($memLimit = Config::inst()->get('SilverStripe\Assets\Image', 'memory') ){
 //            increase_memory_limit_to($memLimit);
 //        }
 //    }

 //    /**
 //     * Get the max Y dimensions for image resampling from the yaml configs
 //     *
 //     * @return int
 //     */
 //    public function getMaxX()
 //    {
 //        return (int) Config::inst()->get('SilverStripe\Assets\Image', 'max_x');
 //    }

 //    /**
 //     * Get the max Y dimensions for image resampling from the yaml configs
 //     *
 //     * @return int
 //     */
 //    public function getMaxY()
 //    {
 //        return (int) Config::inst()->get('SilverStripe\Assets\Image', 'max_y');
 //    }

 //    /**
 //     * Resamples the image to the maximum Height and Width
 //     */
 //    public function resampleImage()
 //    {
 //          $variant = $this->owner->variantName(__FUNCTION__);
 //          $X = $this->owner->getMaxX();
 //          $Y = $this->owner->getMaxY();
 //        return $this->owner->manipulateImage($variant, function (\SilverStripe\Assets\Image_Backend $backend) use ($X,$Y){
 //            $clone = clone $backend;
 //            $resource = clone $backend->getImageResource();
 //            $clone->resizeRatio($X,$Y);
 //            $clone->setImageResource($resource);
 //            return $clone;
 //        });
 //    }

	public function SameImage()
    {
        //to do ?
    }


    public function onAfterUpload(){
    	//$this->owner->resampleImage();
        $this->owner->renderWith('ImageThumbnails');
    }

    public function onAfterWrite(){
    	//$this->owner->resampleImage();
        $this->owner->renderWith('ImageThumbnails');
    }


    public function ImageTags($fallback){
        $text = ($this->owner->Description) ? $this->owner->Description : $fallback;
        $text = strip_tags(preg_replace( "/\r|\n/", "", $text ));
        return  'alt="'.$text.'" title="'.$this->owner->Name.'"' ;
    }

     
}