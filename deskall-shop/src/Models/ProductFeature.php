<?php
use SilverStripe\ORM\DataObject;


class ProductFeature extends DataObject{
	    private static $singular_name = 'Produkt Feature';

	    private static $plural_name = 'Produkte Features';

	    private static $db = [
	        'Title' => 'Varchar',
	    ];

	    public function canView($member = null) {
	        return true;
	    }


	    function fieldLabels($includerelations = true) {
	        $labels = parent::fieldLabels($includerelations);
	     
	        $labels['Title'] = _t(__CLASS__.'.Title','Feature Name');

	        return $labels;
	    }

	    public function onBeforeWrite(){
	        parent::onBeforeWrite();
	        $this->URLSegment = URLSegmentFilter::create()->filter($this->MenuTitle);
	    }


	    public function getCMSFields()
	    {
	        $fields = parent::getCMSFields();
	       
	        
	        return $fields;
	    }

	    public function getCMSValidator(){
	        return new RequiredFields(
	        'Title'
	        );
	    }
}
