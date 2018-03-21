<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\HTMLEditor\TinyMCEConfig;
use SilverStripe\View\ArrayData;
use SilverStripe\Forms\DropdownField;
use SilverStripe\View\Requirements;
use SilverStripe\Core\Convert;
use SilverStripe\CMS\Model\SiteTree;
use Sheadawson\Linkable\Forms\LinkField;
use Sheadawson\Linkable\Models\Link;

class Linkable extends DataExtension
{

    // private static $db = [
    //     'CallToActionLink' => 'Link'
    // ];

    private static $has_one = [
        'LinkableLink' => Link::class
    ];


    function updateFieldLabels(&$labels) {
        $labels['CallToActionLink'] = _t(__CLASS__.'.CTA', 'Link');
    }


    public function updateCMSFields(FieldList $fields){
    	// $fields->removeByName('CallToActionLink');
        $fields->removeByName('LinkableLinkID');
         // Ensure TinyMCE's javascript is loaded before the blocks overrides
        // Requirements::javascript(TinyMCEConfig::get()->getScriptURL());
        // Requirements::javascript('silverstripe/elemental-blocks:client/dist/js/bundle.js');
        // Requirements::css('silverstripe/elemental-blocks:client/dist/styles/bundle.css');
         $fields->addFieldToTab('Root.Main', LinkField::create('LinkableLinkID', _t(__CLASS__.'.CTA', 'Link')));
    }


    /**
     * For the frontend, return a parsed set of data for use in templates
     *
     * @return ArrayData|null
     */
    public function CallToActionLink()
    {
        return $this->decodeLinkData($this->owner->getField('CallToActionLink'));
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
            $data->setField('Page', DataObject::get_by_id(SiteTree::class, $data->PageID));
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