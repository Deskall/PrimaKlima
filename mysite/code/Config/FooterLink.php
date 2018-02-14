<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\HTMLEditor\TinyMCEConfig;
use SilverStripe\View\ArrayData;
use SilverStripe\Forms\DropdownField;
use SilverStripe\View\Requirements;
use SilverStripe\Core\Convert;
use SilverStripe\CMS\Model\SiteTree;

class FooterLink extends DataObject{

	private static $db = [
		'SortOrder' => 'Int',
		'CallToActionLink' => 'Link',
		'Content' => 'HTMLText',
		'Icon' => 'Varchar(255)'
	];

	private static $has_one = [
		'Parent' => 'FooterBlock'
	];

	private static $extensions = [
		'Activable'
	];

	private static $summary_fields = [
		'DisplayLink' => 'Link'
	];

	private static $icons = [
		'chevron-right' => 'chevron-right',
		'home' => 'home',
		'mail' => 'Email',
		'receiver' => 'Telefon',
		'location' => 'Marker',
		'facebook' => 'facebook',
		'twitter' => 'twitter',
		'google-plus' => 'google-plus',
		'linkedin' => 'linkedin',
		'xing' => 'xing'
	];

	public function getCMSFields(){
		$fields = parent::getCMSFields();
	 // Remove default scaffolded relationship fields
        $fields->removeByName('CallToActionLinkID');
        $fields->removeByName('SortOrder');
        $fields->removeByName('CallToActionLinkID');
        $fields->removeByName('ParentID');

         $fields->addFieldToTab('Root.Main',DropdownField::create('Icon','Icon',self::$icons)->setEmptyString('Icon hinzufügen'));
	    // Ensure TinyMCE's javascript is loaded before the blocks overrides
        Requirements::javascript(TinyMCEConfig::get()->getScriptURL());
        Requirements::javascript('silverstripe/elemental-blocks:client/dist/js/bundle.js');
        Requirements::css('silverstripe/elemental-blocks:client/dist/styles/bundle.css');

        return $fields;
    }

    /**
     * For the frontend, return a parsed set of data for use in templates
     *
     * @return ArrayData|null
     */
    public function CallToActionLink()
    {
        return $this->decodeLinkData($this->getField('CallToActionLink'));
    }

     /**
     * Given a set of JSON data, decode it, attach the relevant Page object and return as ArrayData
     *
     * @param string $linkJson
     * @return ArrayData|null
     */
    protected function decodeLinkData($linkJson)
    {
        if (!$linkJson || $linkJson === 'null') {
            return;
        }

        $data = ArrayData::create(Convert::json2obj($linkJson));

        // Link page, if selected
        if ($data->PageID) {
            $data->setField('Page', self::get_by_id(SiteTree::class, $data->PageID));
        }
        return $data;
    }

    public function DisplayLink(){
    	$output = new DBHTMLText();
    	$data = $this->CallToActionLink();
    	if ($data){
			$html = '<strong>'.$data->Text.'</strong>';
			    	if($data->Page){
			    		$html .='<span>/'.$data->Page->URLSegment.'</span>';
			    	}
    		$output->setValue($html);
    	}
    	
    	return $output;
    }
}
