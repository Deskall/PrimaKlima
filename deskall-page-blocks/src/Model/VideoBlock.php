<?php


use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\FieldType\DBHTMLText;

use Embed\Embed;

class VideoBlock extends BaseElement
{
	private static $icon = 'font-icon-block-media';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $table_name = 'VideoBlock';

    private static $singular_name = 'Videogalerie';

    private static $plural_name = 'Videogalerien';

    private static $description = 'Video Karousel';

	private static $db = [
		'HTML' => 'HTMLText',
        'VideoList' => 'Text',
        'VideoPerLine' => 'Varchar(255)'
	];

	private static $defaults = [
		'Layout' => 'carousel',
		'VideoPerLine' => 'uk-child-width-1-2@s'
	];

	private static $block_layouts = [
        'carousel' => 'Carousel',
        'grid' => 'Grid'
    ];

    private static $videos_per_line = [
    	'uk-child-width-1-1' => '1',
        'uk-child-width-1-2@s' => '2',
        'uk-child-width-1-3@s' => '3'
    ];

    private static $cascade_duplicates = [];

	/**
	 * Color to customize the vimeo player.
	 * Can be set via config.yml
	 * @var string
	 */
	private static $player_color = '44BBFF';

	public function getCMSFields() {
		$this->beforeUpdateCMSFields(function ($fields) {
            // field to enter the video URL
			$fields->addFieldToTab('Root.Main', new TextareaField('VideoList', _t(__CLASS__.'.VideosURL','Videos (1 URL pro Zeile) ')));
			$fields->addFieldToTab('Root.Layout',DropdownField::create('VideoPerLine',_t(__CLASS__.'.VideoPerLine','Videos per Linie'), $this->getTranslatedSourceFor(__CLASS__,'videos_per_line')));
        });
        
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Layout',LayoutField::create('Layout','Format', $this->getTranslatedSourceFor(__CLASS__,'block_layouts')));
        return $fields;
	}

	public function getThumbnailURL( $url ){
		$media =  $this->Media($url);
		$ThumbnailUrl = ($media) ? $media->thumbnail_url : false;
		return $ThumbnailUrl;
	}

	function GetVideoThumbs(){
		$content = '';
		if( $this->countVideos() < 2){
		    $thumbnail = $this->getThumbnailURL(trim($this->VideoList));
		    if( $thumbnail ){
		        $content .= '<img src="'.$thumbnail.'" class="img-full"/>';
		    }
		}else{
			$count = 0;
			foreach (explode("\n",$this->VideoList) as $url){
			    $thumbnail = $this->getThumbnailURL(trim($url));
			    if( $thumbnail ){
			        $content .= '<img src="'.$thumbnail.'" class="img-left"/>';
			    }
			    $count++;
			    if( $count == 2 ){
			    	break;
			    }
			}
		}

		return $content;
	}

	function GetVideos(){
		$videos = '';
		foreach (explode("\n",$this->VideoList) as $url){
			$videoObject = $this->Media(trim($url));
		    if( $videoObject ){
			    $videos .= '<li class="uk-height-1-1">'.$videoObject->code.'</li>';
			}
		}
		$html = DBHTMLText::create();
		$html->setValue($videos);
		return $html;
	}

	public function Media($url) {
		return Embed::create($url);
	}

	 public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Videogalerie');
    }
    /************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('block_layouts') as $key => $value) {
          $entities[__CLASS__.".block_layouts_{$key}"] = $value;
        }
         foreach($this->stat('videos_per_line') as $key => $value) {
          $entities[__CLASS__.".videos_per_line_{$key}"] = $value;
        }
       
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}