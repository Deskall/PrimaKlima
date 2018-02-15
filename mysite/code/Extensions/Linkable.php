<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\HTMLEditor\TinyMCEConfig;
use SilverStripe\View\ArrayData;
use SilverStripe\Forms\DropdownField;
use SilverStripe\View\Requirements;
use SilverStripe\Core\Convert;
use SilverStripe\CMS\Model\SiteTree;

class Linkable extends DataExtension
{

    private static $db = [
        'CallToActionLink' => 'Link'
    ];

    public function updateCMSFields(FieldList $fields){
    	$fields->removeByName('CallToActionLinkID');
         // Ensure TinyMCE's javascript is loaded before the blocks overrides
        Requirements::javascript(TinyMCEConfig::get()->getScriptURL());
        Requirements::javascript('silverstripe/elemental-blocks:client/dist/js/bundle.js');
        Requirements::css('silverstripe/elemental-blocks:client/dist/styles/bundle.css');

    }


    /**
     * For the frontend, return a parsed set of data for use in templates
     *
     * @return ArrayData|null
     */
    public function CallToActionLink()
    {
        return $this->owner->decodeLinkData($this->getField('CallToActionLink'));
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
        $data = $this->owner->CallToActionLink();
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