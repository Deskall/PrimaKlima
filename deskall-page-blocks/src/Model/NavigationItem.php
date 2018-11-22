<?php

use SilverStripe\ORM\DataObject;
use DNADesign\Elemental\Models\BaseElement;

class NavigationItem extends DataObject{
	private static $db = [
		'BackgroundColor' => 'Varchar',
		'Title' => 'Varchar',
		'ItemType' => 'Varchar',
		'Link' => 'Link',
	];

	private static $has_one = [
		'Target' => BaseElement::class,
		'Parent' => NavigationBlock::class
	];

	private static $extensions = ['Sortable'];

	public function TargetLink(){
		switch ($this->ItemType) {
			case 'block':
				return $this->Target()->Anchor;
			break;
			case 'target':
				switch ($this->Target()->InteractionType) {
					case 'modal':
						return "#content-container-".$this->TargetID;
						break;
					case 'offcanvas':
						return "#offcanvas-container-".$this->TargetID;
						break;
					case 'toggle':
						return "#toggle-container-".$this->TargetID;
						break;
					default:
						return "#".$this->TargetID;
					break;
				}
			break;
			default:
				return null;
				break;
		}
	}
}