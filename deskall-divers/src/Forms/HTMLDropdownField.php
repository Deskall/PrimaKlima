<?php

use SilverStripe\Forms\DropdownField;
use SilverStripe\View\Requirements;
use SilverStripe\Core\Config\Config;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Forms\FormField;
use SilverStripe\ORM\FieldType\DBHTMLText;

class HTMLDropdownField extends DropdownField{
	protected $template = 'Forms/HTMLDropdownField';

	protected $extraClasses = [];

	private static $iconsList = [
		'none' => 'keine',
		'500px' => '500px',
		'album' => 'album',
		'arrow-down' => 'arrow-down',
		'arrow-left' => 'arrow-left',
		'arrow-right' => 'arrow-right',
		'arrow-up' => 'arrow-up',
		'ban' => 'ban',
		'behance' => 'behance',
		'bell' => 'bell',
		'bold' => 'bold',
		'bolt' => 'bolt',
		'bookmark' => 'bookmark',
		'calendar' => 'calendar',
		'camera' => 'camera',
		'cart' => 'cart',
		'check' => 'check',
		'chevron-down' => 'chevron-down',
		'chevron-left' => 'chevron-left',
		'chevron-right' => 'chevron-right',
		'chevron-up' => 'chevron-up',
		'clock' => 'clock',
		'close' => 'close',
		'cloud-download' => 'cloud-download',
		'cloud-upload' => 'cloud-upload',
		'code' => 'code',
		'cog' => 'cog',
		'comment' => 'comment',
		'commenting' => 'commenting',
		'comments' => 'comments',
		'copy' => 'copy',
		'credit-card' => 'credit-card',
		'database' => 'database',
		'desktop' => 'desktop',
		'download' => 'download',
		'dribbble' => 'dribbble',
		'expand' => 'expand',
		'facebook' => 'facebook',
		'file' => 'file',
		'file-edit' => 'file-edit',
		'flickr' => 'flickr',
		'folder' => 'folder',
		'forward' => 'forward',
		'foursquare' => 'foursquare',
		'future' => 'future',
		'github' => 'github',
		'git-branch' => 'git-branch',
		'git-fork' => 'git-fork',
		'github-alt' => 'github-alt',
		'gitter' => 'gitter',
		'google' => 'google',
		'google-plus' => 'google-plus',
		'grid' => 'grid',
		'happy' => 'happy',
		'hashtag' => 'hashtag',
		'heart' => 'heart',
		'history' => 'history',
		'home' => 'home',
		'image' => 'image',
		'info' => 'info',
		'instagram' => 'instagram',
		'italic' => 'italic',
		'joomla' => 'joomla',
		'laptop' => 'laptop',
		'lifesaver' => 'lifesaver',
		'link' => 'link',
		'linkedin' => 'linkedin',
		'list' => 'list',
		'location' => 'location',
		'lock' => 'lock',
		'mail' => 'mail',
		'menu' => 'menu',
		'minus' => 'minus',
		'minus-circle' => 'minus-circle',
		'more-vertical' => 'more-vertical',
		'more' => 'more',
		'move' => 'move',
		'nut' => 'nut',
		'pagekit' => 'pagekit',
		'paint-bucket' => 'paint-bucket',
		'pencil' => 'pencil',
		'phone' => 'phone',
		'pinterest' => 'pinterest',
		'phone-landscape' => 'phone-landscape',
		'play' => 'play',
		'play-circle' => 'play-circle',
		'plus' => 'plus',
		'plus-circle' => 'plus-circle',
		'pull' => 'pull',
		'push' => 'push',
		'question' => 'question',
		'quote-right' => 'quote-right',
		'receiver' => 'receiver',
		'refresh' => 'refresh',
		'reply' => 'reply',
		'rss' => 'rss',
		'search' => 'search',
		'server' => 'server',
		'settings' => 'settings',
		'shrink' => 'shrink',
		'sign-in' => 'sign-in',
		'sign-out' => 'sign-out',
		'social' => 'social',
		'soundcloud' => 'soundcloud',
		'star' => 'star',
		'strikethrough' => 'strikethrough',
		'table' => 'table',
		'tablet' => 'tablet',
		'tablet-landscape' => 'tablet-landscape',
		'tag' => 'tag',
		'thumbnails' => 'thumbnails',
		'trash' => 'trash',
		'triangle-down' => 'triangle-down',
		'triangle-left' => 'triangle-left',
		'triangle-right' => 'triangle-right',
		'triangle-up' => 'triangle-up',
		'tripadvisor' => 'tripadvisor',
		'tumblr' => 'tumblr',
		'tv' => 'tv',
		'twitter' => 'twitter',
		'uikit' => 'uikit',
		'unlock' => 'unlock',
		'upload' => 'upload',
		'user' => 'user',
		'users' => 'users',
		'video-camera' => 'video-camera',
		'vimeo' => 'vimeo',
		'warning' => 'warning',
		'whatsapp' => 'whatsapp',
		'wordpress' => 'wordpress',
		'world' => 'world',
		'xing' => 'xing',
		'yelp' => 'yelp',
		'youtube' => 'youtube'
	];

	public function __construct($name, $title = null, $value = null)
    {
    	Requirements::javascript("deskall-divers/javascript/htmldropdown.js");
        Requirements::css("deskall-divers/css/htmldropdown.css");

        parent::__construct($name, $title, $value);
    }
 	

 	public function Field($properties = array()) {
		$source = $this->getSource();
		$options = array();
        
        if ($this->getHasEmptyDefault()) {
			$selected = ($this->value === '' || $this->value === null);
			$disabled = (in_array('', $this->disabledItems, true)) ? 'disabled' : false;
			$empty = $this->getEmptyString();
			
			$options[] = array(
				'Value' => '',
				'Title' => $empty,
				'Selected' => $selected,
				'Disabled' => $disabled,
				'HTML' => $empty,
				'Attributes' => $this->createOptionAttributes($empty)
			);
		}
        
		if($source) {
			foreach($source as $value => $params) {
				$selected = false;
				if($value === '' && ($this->value === '' || $this->value === null)) {
					$selected = true;
				} else {
					// check against value, fallback to a type check comparison when !value
					if($value) {
						$selected = ($value == $this->value);
					} else {
						$selected = ($value === $this->value) || (((string) $value) === ((string) $this->value));
					}
					$this->isSelected = $selected;
				}
				
				$disabled = false;
				if(in_array($value, $this->disabledItems) && $params['Title'] != $this->emptyString ){
					$disabled = 'disabled';
				}
				$html = new DBHTMLText();
				$html->setValue($params['HTML']);
				$options[] = array(
					'Title' => $params['Title'],
					'Value' => $value,
					'Selected' => $selected,
					'Disabled' => $disabled,
					'HTML' => $html ,
					'Attributes' => $this->createOptionAttributes($params)
				);
			}
		}
		$properties = array_merge($properties, array('Options' => $options));
		return FormField::Field($properties);
	}
	public function createOptionAttributes($params) {
		$attributes = [];
		// if(isset($params['Attributes'])) {
		if(is_array($params['Attributes'])) {
		// 		$attributes = $params['Attributes'];
		// 	} else {
				foreach($params['Attributes'] as $k => $v) {
					$attributes[] = array(
						'Name' => $k,
						'Value' => $v
					);
				}
		// 	}
		}
		return $attributes;
	}

	public static function getSourceIcones(){
		$source = [];
		$iconsList = Config::inst()->get(__CLASS__,'iconsList');
      

        foreach($iconsList as $icon => $name){
            $html = '<div class="option-html">
        			<span data-uk-icon="'.$icon.'"></span>'.$name.'
      			</div>';
       
            $source[$icon] = [
                'Title' => $name,
                'HTML' => $html
                
            ];
        }

		return $source;
	}
}