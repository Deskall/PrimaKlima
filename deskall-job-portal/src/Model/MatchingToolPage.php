<?php
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class MatchingToolPage extends Page {

	private static $db = [
		'MatchingToolExplanation' => 'HTMLText'
	];

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['MatchingToolExplanation'] = _t(__CLASS__.'.MatchingToolExplanation','Matching Tool Prozess Erklärung');
		return $labels;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.MatchingToolSettings',HTMLEditorField::create('MatchingToolExplanation',$this->fieldLabels()['MatchingToolExplanation'])->setRows(5));
		return $fields;
	}
	
	public function canCreate( $member = null, $context = []){
	    if (MatchingToolPage::get()->count() == 0){
	    	return true;
	    }
	    return false;
	}
}