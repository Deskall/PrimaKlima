<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Assets\Image;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\View\ArrayData;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\RequiredFields;

class ProductOption extends Product {
	private static $singular_name = 'Option';
	private static $plural_name = 'Optionen';

	private static $db = [
		'hasOptions' => 'Boolean(0)',
		'Single' => 'Boolean(0)'
	];

	private static $has_one = ['Group' => ProductOption::class];

	private static $has_many = ['Options' => ProductOption::class];

	
	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['hasOptions'] = 'ist einen Grupp?';
		$labels['Group'] = 'Grupp';
		$labels['Options'] = 'Optionen';
		$labels['Single'] = 'Aus dieser Gruppe kann jeweils nur eine Option bestellt werden?';
		return $labels;
	}


	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('GroupID');
		$fields->dataFieldByName('Price')->hideIf('hasOptions')->isChecked();
		$fields->dataFieldByName('BestSeller')->hideIf('hasOptions')->isChecked();
		$fields->dataFieldByName('RecurringPrice')->hideIf('hasOptions')->isChecked();
		$fields->dataFieldByName('UniquePrice')->hideIf('hasOptions')->isChecked();
		// $fields->dataFieldByName('ActivationPrice')->hideIf('hasOptions')->isChecked();
		$fields->dataFieldByName('UniquePriceLabel')->hideIf('hasOptions')->isChecked();
		// $fields->dataFieldByName('ActivationPriceLabel')->hideIf('hasOptions')->isChecked();
		$fields->dataFieldByName('Multiple')->hideIf('hasOptions')->isChecked();
		$fields->dataFieldByName('Single')->displayIf('hasOptions')->isChecked();
		$fields->dataFieldByName('Unit')->hideIf('hasOptions')->isChecked();
		

		if ($this->ID > 0){
			$fields->dataFieldByName('Options')->displayIf('hasOptions')->isChecked();
			$fields->dataFieldByName('Options')->getConfig()->removeComponentsByType([GridFieldAddExistingAutocompleter::class,GridFieldDeleteAction::class])->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction())->addComponent(new GridFieldDuplicateAction())->addComponent(new GridFieldDeleteAction());

		}
		if ($this->GroupID > 0){
			$fields->removeByName('Options');
			$fields->removeByName('hasOptions');
			$fields->removeByName('Single');
		}
		return $fields;
	}

	public function getCMSValidator(){
	    return new RequiredFields(array('Title'));
	}

	public function getCategoryTitle(){
		return $this->Category()->Title;
	}

	public function getCategorySort(){
		return $this->Category()->Title;
	}

	public function PrintPriceString(){
		if (!$this->hasOptions){
			return parent::PrintPriceString();
		}
		return null;
	}

	public function inCart(){
		$request = Injector::inst()->get(HTTPRequest::class);
		$session = $request->getSession();
		if ($session->get('shopcart_id')){
			$cart = ShopCart::get()->byId($session->get('shopcart_id'));
			if ($cart){
				return $cart->Options()->byId($this->ID);
			}
		}
		return false;
	}
	
}

