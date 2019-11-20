<?php

use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class ConfiguratorPage extends Page {
	private static $singular_name = "Abo Konfigurator";

	private static $db = [
		'OtherOffersTitle' => 'Varchar',
		'OtherOffersLabel' => 'HTMLText',
		'ConditionsText' => 'HTMLText'
	];

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['OtherOffersTitle'] = 'Weitere Angebote Titel';
		$labels['OtherOffersLabel'] = 'Weitere Angebote Text';
		$labels['ConditionsText'] = 'Konditionen';

		return $labels;
	}

	public function canCreate($member = null, $context = array()){
		return ConfiguratorPage::get()->count() == 0;
	}

	public function activeCategories(){
		return ProductCategory::get()->filter('isVisible',1);
	}

	public function alternativePackage(){
		$availability = ($this->activePLZ()) ? $this->activePLZ()->AlternateOffer : "Cable";
		print_r($availability);
		return Package::get()->filter(['isVisible' => 1, 'Availability' => ['Immer',$availability]])->filterByCallback(function($item, $list) {
		    return ($item->shouldDisplay());
		});;
	}


	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('BlockTitle');
		$fields->removeByName('ElementalArea');
		$fields->addFieldsToTab('Root.Main',[
			TextField::create('OtherOffersTitle',$this->fieldLabels()['OtherOffersTitle']),
			HTMLEditorField::create('OtherOffersLabel',$this->fieldLabels()['OtherOffersLabel']),
			HTMLEditorField::create('ConditionsText',$this->fieldLabels()['ConditionsText'])
		]);

		return $fields;
	}
}