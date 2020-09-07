<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
Use SilverStripe\Forms\DropdownField;

class OverlayPageExtension extends DataExtension {
	private static $has_one = [
		'Overlay' => Overlay::class
	];

	public function updateCMSFields(FieldList $fields) {
		$source = Overlay::get();
		$fields->addFieldToTab('Root.Main.Overlay', DropdownField::create('OverlayID','Overlay',$source)->setEmptyString('Bitte wählen'));
	}
}
