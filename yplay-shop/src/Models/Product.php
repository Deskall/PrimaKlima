<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\DropdownField;

class Product extends DataObject {

	private static $singular_name = 'Produkt';
	private static $plural_name = 'Produkte';

	private static $db = [
	'ProductCode' => 'Varchar',
	'Title' => 'Varchar',
	'Subtitle' => 'Text',
	'Preselected' => 'Boolean(0)',
	'BestSeller' => 'Boolean(0)',
	'RecurringPrice' => 'Boolean(1)',
	'Price' => 'Currency',
	'UniquePrice' => 'Currency',
	'UniquePriceLabel' => 'Varchar',
	'ActivationPrice' => 'Currency',
	'ActivationPriceLabel' => 'Varchar',
	'Unit' => 'Varchar',
	'FooterText' => 'HTMLText',
	'Availability' => 'Varchar'
	];

	private static $has_one = [
		'Category' => ProductCategory::class
	];

	private static $extensions = [
		'Sortable',
		'Activable',
		'PLZFilterable',
		'Itemable'
	];

	private static $summary_fields = [
		'Availability',
		'Title',
		'Subtitle',
		'Specific',
		'PrintPriceString'
	];

	private static $searchable_fields = [
		'Title'
	];

	public function onBeforeWrite(){
	    if (!$this->ProductCode || $this->ID == 0){
	    	//TO DO Increment for doublon
	    	$this->ProductCode = URLSegmentFilter::create()->filter($this->Title);
	    }
	    if ($this->Preselected){
	    	$previous = $this->Category()->getPreselected();
	    	if ($previous && $previous->ID != $this->ID && $previous->Availability == $this->Availability){
	    		$previous->Preselected = false;
	    		$previous->write();
	    	}
	    }
	    if ($this->BestSeller){
	    	$previous = $this->Category()->getBestSeller();
	    	if ($previous && $previous->ID != $this->ID && $previous->Availability == $this->Availability){
	    		$previous->BestSeller = false;
	    		$previous->write();
	    	}
	    }
		parent::onBeforeWrite();
	}

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Title'] = 'Name';
		$labels['Subtitle'] = 'Untertitel';
		$labels['UniquePrice'] = 'Einmaliger Preis';
		$labels['UniquePriceLabel'] = 'Einmaliger Preis Erklärung';
		$labels['ActivationPrice'] = 'Grundgebühr';
		$labels['ActivationPriceLabel'] = 'Grundgebühr Preis Erklärung';
		$labels['Price'] = 'Preis';
		$labels['Unit'] = 'Einheit';
		$labels['RecurringPrice'] = 'Monatlicher Preis?';
		$labels['PrintPriceString'] = 'Preis';
		$labels['BestSeller'] = 'Bestseller?';
		$labels['FooterText'] = 'Weitere Informationen (wird im Produkt Kart zeigt an boden.)';
		$labels['Preselected'] = 'standardmäßig ausgewählt?';
		$labels['Availability'] = 'Verfügbarkeit';

		return $labels;
	}

	public function PrintPriceString(){
		if ($this->RecurringPrice){
			return DBText::create()->setValue('CHF '.$this->Price.' / Mt.');
		}
		else{
			return DBText::create()->setValue('CHF '.$this->Price);
		}
	}

	public function Specific(){
		$html = '';
		if ($this->BestSeller){
			$html .= '<label class="bestseller">Bestseller</label><br>';
		}
		if ($this->Preselected){
			$html .= '<label class="preselected">Standard</label>';
		}
		return DBHTMLText::create()->setValue($html);
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('ProductCode');
		$fields->removeByName('CategoryID');
		$fields->removeByName('FooterText');
		$fields->removeByName('Availability');
		$fields->insertBefore('Title',DropdownField::create('Availability',$this->fieldLabels()['Availability'],['all' => 'Beide', 'fiber' => 'Fiber', 'cable' => 'Cable']));
		$fields->fieldByName('Root.Main.Unit')->displayIf('RecurringPrice')->isNotChecked();
		$fields->fieldByName('Root.Main.UniquePriceLabel')->displayIf('RecurringPrice')->isChecked();
		if ($this->ID > 0){
			$fields->addFieldToTab('Root.Items',HTMLEditorField::create('FooterText',$this->fieldLabels()['FooterText'])->setRows(3));
		}
		
		return $fields;
	}

	//To do: elaborate with Actions
	public function getMonthlyPrice(){
		return $this->Price;
	}

	public function getPriceUnique(){
		return $this->UniquePrice;
	}

	public function getFees(){
		return $this->ActivationPrice;
	}

	public function inCart(){
		$request = Injector::inst()->get(HTTPRequest::class);
		$session = $request->getSession();
		if ($session->get('shopcart_id')){
			$cart = ShopCart::get()->byId($session->get('shopcart_id'));
			if ($cart){
				return $cart->Products()->byId($this->ID);
			}
		}
		return false;
	}
}