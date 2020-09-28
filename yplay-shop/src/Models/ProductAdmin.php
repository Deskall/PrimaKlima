<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Folder;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\DB;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\Forms\GridField\GridFieldPrintButton;

class ProductAdmin extends ModelAdmin{

	private static $menu_icon = "yplay-shop/images/icon-verkauf.png";
	private static $url_segment = "shop";
	private static $menu_title = "Shop";

	public function subsiteCMSShowInMenu(){
		return true;
	}
	
	private static $managed_models = [
		'ShopOrder' => [
			'title' => 'Bestellungen'
		],
		'ShopCustomer' => [
			'title' => 'Kunden'
		],
		'ShopCart' => [
			'title' => 'Warenkorben'
		],
		'ProductCategory' => [
			'title' => 'Kategorien'
		],
		'Package'  => [
			'title' => 'Pakete'
		],
		'PostalCode' => [
			'title' => 'Ortschaften'
		],
		'ShopAction' => [
			'title' => 'Aktionen'
		],
		'Shop' => [ 
			'title' => 'Shops'
		]
	];

	

	public function getEditForm($id = null, $fields = null) {
	    $form = parent::getEditForm($id, $fields);
	   
	    if($this->modelClass == 'ShopOrder' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
	       $gridField->getConfig()->removeComponentsByType([GridFieldAddNewButton::class])->addComponent(new GridFieldDeleteAllAction('before'));
	    }

	    if($this->modelClass == 'ProductCategory' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
	       $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction())->addComponent(new GridFieldDuplicateAction());
	    }
	    if($this->modelClass == 'Package' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
	       $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction())->addComponent(new GridFieldDuplicateAction());
	    }
	    if($this->modelClass == 'ShopCart' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
	       $gridField->getConfig()->removeComponentsByType([GridFieldAddExistingAutocompleter::class,GridFieldDeleteAction::class])->addComponent(new GridFieldDeleteAction())->addComponent(new GridFieldDeleteAllAction('before'));
	    }
	    if($this->modelClass == 'ShopAction' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
	       $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction());
	    }

	    if($this->modelClass=='Shop' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) 
	    {
	       
	        $form->Fields()->fieldByName("Shop")->getConfig()->removeComponentsByType(GridFieldExportButton::class);
	        $form->Fields()->fieldByName("Shop")->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
	        $form->Fields()->fieldByName("Shop")->getConfig()->addComponent(new GridFieldDuplicateAction());

	        //Import Shops
	        
	        // $file = File::get()->byId(102);
	        // if(($handle = fopen($file->getAbsoluteURL(), "r")) !== FALSE) {
	        //     $delimiter = self::getFileDelimiter($file->getAbsoluteURL());
	        //     $headers = fgetcsv($handle, 0, $delimiter);
	        //     while (($line = fgetcsv($handle,0,$delimiter)) !== FALSE) {
	        //         $shop = Shop::get()->filter('Ref',$line[0])->first();
	        //         if (!$shop){
	        //             $shop = new Shop();
	        //             $shop->Ref = $line[0];
	        //         } 
	        //         $shop->Title = $line[1];
	        //         $shop->AdresseTitle = $line[2];
	        //         $shop->Adresse = $line[3];
	        //         $shop->PLZ = $line[4];
	        //         $shop->City = $line[5];
	        //         $shop->Offnungszeiten = $line[6];
	        //         $shop->write();
	        //     }
	        // }
	    }

	    if($this->modelClass=='PostalCode' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) 
	    {
	       
	        //Import Codes
	        
	        // $file = File::get()->byId(109);
	        // if(($handle = fopen($file->getAbsoluteURL(), "r")) !== FALSE) {
	        //     $delimiter = self::getFileDelimiter($file->getAbsoluteURL());
	        //     $headers = fgetcsv($handle, 0, $delimiter);
	        //     while (($line = fgetcsv($handle,0,$delimiter)) !== FALSE) {
	        //         $plz = PostalCode::get()->filter('OldID',$line[0])->first();
	        //         if (!$plz){
	        //             $plz = new PostalCode();
	        //             $plz->OldID = $line[0];
	        //         }
	        //         $plz->Code = $line[4];
	        //         $plz->City = $line[7];
	        //         $plz->URL = ($line[8] != "NULL") ? $line[8] : null;
	        //         $plz->StandardOffer = ($line[6] == "FTTH") ? 'Fiber' : 'Cable';
	        //         $plz->TVType = ($line[11] == "ReplayTV") ? 'IPTV' : 'DVBC';
	        //         $plz->write();
	        //     }
	        // }
	    }

	    return $form;
	}

	public function getList(){
		$list = parent::getList();
		if($this->modelClass == 'Product') {
	      $list = $list->filter('ClassName','Product');
	    }
	    if($this->modelClass == 'ShopCart') {
	      $list = $list->filter('Purchased',0);
	    }
		return $list;
	}

	public static function getFileDelimiter($file, $checkLines = 2){
	    $file = new SplFileObject($file);
	    $delimiters = array(
	        ',',
	        '\t',
	        ';',
	        '|',
	        ':'
	    );
	    $results = array();
	    $i = 0;
	    while($file->valid() && $i <= $checkLines){
	        $line = $file->fgets();
	        foreach ($delimiters as $delimiter){
	            $regExp = '/['.$delimiter.']/';
	            $fields = preg_split($regExp, $line);
	            if(count($fields) > 1){
	                if(!empty($results[$delimiter])){
	                    $results[$delimiter]++;
	                } else {
	                    $results[$delimiter] = 1;
	                }   
	            }
	        }
	        $i++;
	    }
	    $results = array_keys($results, max($results));
	    return $results[0];
	}

}