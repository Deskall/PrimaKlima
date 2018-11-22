<?php

use SilverStripe\ORM\DataObject;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\FormField;
use SilverStripe\View\ArrayData;
use SilverStripe\Core\Convert;
use SilverStripe\CMS\Model\SiteTree;

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

	    /**
	 * For the frontend, return a parsed set of data for use in templates
	 *
	 * @return ArrayData|null
	 */
	public function CallToActionLink()
	{
	    return $this->decodeLinkData($this->getField('Link'));
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
}