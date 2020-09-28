<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Subsites\State\SubsiteState;

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
	'Multiple' => 'Boolean(0)'
	];

	private static $has_one = [
		'Category' => ProductCategory::class
	];

	private static $belongs_many_many= [
	    'Actions' => PriceDiscount::class
	];

	private static $has_many= [
	    'PriceVariations' => PriceVariation::class
	];

	private static $extensions = [
		'Sortable',
		'Activable',
		'PLZFilterable',
		'Itemable',
		'AvailabilityFilterable'
	];

	private static $summary_fields = [
		'Specific' => '',
		'Availability',
		'Title',
		'Subtitle',
		'PrintPriceString'
	];

	private static $searchable_fields = [
		'Title'
	];

	public function getCMSValidator(){
	    return new RequiredFields(array('Title','Price'));
	}

	public function onBeforeWrite(){
	    if ($this->isChanged('Title')){
	    	//Subsite prefix
	    	$prefix = '';
	    	if ($id = SubsiteState::singleton()->getSubsiteId() > 0){
	    		$prefix = Subsite::get()->byId($id)->Title . ' ';
	    	}
	    	$code = URLSegmentFilter::create()->filter($prefix . $this->Title);
	    	$newcode = $code;
	    	$exist = Product::get()->filter('ProductCode',$code)->exclude('ID',$this->ID)->count();
	    	$i = 1;
	    	while( $exist > 0){
	    		$newcode = $code."-".$i;
	    		$exist = Product::get()->filter('ProductCode',$newcode)->count();
	    		$i++;
	    	}
	    	$this->ProductCode = $newcode;
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
		$labels['Actions'] = 'Aktionen';
		$labels['PriceVariations'] = 'Preise pro Ortschaft';
		$labels['Multiple'] = 'kann in mehreren Exemplaren bestellt werden?';

		return $labels;
	}

	public function PrintPriceString(){
		if ($this->RecurringPrice){
			if ($this->getActionMonthlyPrice() ){
				return DBText::create()->setValue('CHF '.$this->getActionMonthlyPrice().' / Mt.');
			}
			return DBText::create()->setValue('CHF '.$this->getMonthlyPrice().' / Mt.');
		}
		else{
			return DBText::create()->setValue('CHF '.$this->getPriceUnique());
		}
	}

	public function Specific(){
		$html = '';
		if ($this->BestSeller){
			$html .= '<label class="bestseller">Bestseller</label>';
		}
		if ($this->Preselected){
			$html .= '<label class="preselected">Standard</label>';
		}
		return DBHTMLText::create()->setValue($html);
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		// $fields->removeByName('ProductCode');
		$fields->removeByName('CategoryID');
		$fields->removeByName('FooterText');
		$fields->removeByName('ActivationPrice');
		$fields->removeByName('ActivationPriceLabel');
		
		
		$fields->fieldByName('Root.Main.Unit')->displayIf('RecurringPrice')->isNotChecked();
		$fields->fieldByName('Root.Main.UniquePriceLabel')->displayIf('RecurringPrice')->isChecked();
		if ($this->ID > 0){
			$fields->addFieldToTab('Root.Items',HTMLEditorField::create('FooterText',$this->fieldLabels()['FooterText'])->setRows(3));

            $config = 
                GridFieldConfig::create()
                ->addComponent(new GridFieldButtonRow('before'))
                ->addComponent(new GridFieldToolbarHeader())
                ->addComponent(new GridFieldTitleHeader())
                ->addComponent(new GridFieldEditableColumns())
                ->addComponent(new GridFieldDeleteAction())
                ->addComponent(new GridFieldAddNewInlineButton());
            $config->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields([
		        'CodeID' => function($record, $column, $grid) {
		          return new DropdownField($column, 'Ortschaft',PostalCode::get()->map('ID','Code'));
		        },
		        'Price' => array(
		          'title' => 'Monatlicher Preis',
		          'field' => TextField::class
		        ),
		        'UniquePrice' => array(
		          'title' => 'Einmaliger Preis',
		           'field' => TextField::class
		        ),
		        'ActivationPrice' => array(
		          'title' => 'Aufschaltgebühr',
		           'field' => TextField::class
		        )
		    ]);
           $fields->addFieldToTab('Root.PriceVariations',new GridField('PriceVariations',$this->fieldLabels()['PriceVariations'],$this->PriceVariations(),$config));
		}
		
		return $fields;
	}

	//To do: elaborate with Actions
	public function getActionMonthlyPrice(){
		$discounts = $this->Actions();
		if ($discounts){
			if ($this->activePLZ()){
				$c = PostalCode::get()->byId($this->activePLZ());
				$ids = null;
				if ($c){
					$ids = $c->Actions()->column('ID');
				}
				if ($ids){
					$discounts->filter('ID',$ids);
				}
			}
			else{
				$discounts = $discounts->filter('AllCodes',1);
			}
		}
		if ($discounts->count() > 0){
			$discount = $discounts->first();
			return $discount->Value;
		}
		return null;
	}

	public function getMonthlyPrice(){
		$variation = ($this->activePLZ()) ? $this->PriceVariations()->filter('CodeID',$this->activePLZ())->first() : null;
		return ($variation ) ? $variation->Price : $this->Price;
	}

	public function getPriceUnique(){
		$variation = ($this->activePLZ()) ? $this->PriceVariations()->filter('CodeID',$this->activePLZ())->first() : null;
		return ($variation ) ? $variation->UniquePrice : $this->UniquePrice;
	}

	public function getFees(){
		$variation = ($this->activePLZ()) ? $this->PriceVariations()->filter('CodeID',$this->activePLZ())->first() : null;
		return ($variation ) ? $variation->ActivationPrice : $this->ActivationPrice;
	}

	public function activePLZ(){
		$request = Injector::inst()->get(HTTPRequest::class);
		$session = $request->getSession();
		return $session->get('active_plz');
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

	public function OrderLink(){
		$shop = ShopPage::get()->filter('SubsiteID',SubsiteState::singleton()->getSubsiteId())->first();
		if ($shop){
			switch ($this->ClassName){
				case "Package":
				 $link = $shop->Link()."paket/".$this->ID;
				 break;
				case "Product":
				 $link = $shop->Link()."produkt/".$this->ID;
				 break;
				case "ProductOption":
				 $link = $shop->Link()."option/".$this->ID;
				 break;
			}
			return $link;
		}
		return null;
	}

	//Check if a discount apply for this product
	public function hasAction(){
		// if ($this->Actions()->filter('AllCodes',1)->count() > 0){
		// 	return true;
		// }
		// else{
		// 	//TO DO
		// }
		return false;
	}

	public function currentActions(){
		// $ids = PriceVariation::get()->filter(['AllCodes' => 1, 'AllProducts' => 1])->column('ID');
		// $request = Injector::inst()->get(HTTPRequest::class);
		// $session = $request->getSession();
		// if ($session->get('active_plz')){
		// 	$codeIds = PriceVariation::get()->filter(['CodeID' => $session->get('active_plz'), 'AllProducts' => 1])->column('ID');
		// 	$ids = array_merge($codeIds,$ids);
		// }


	}

}