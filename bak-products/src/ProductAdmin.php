<?php

namespace Bak\Products;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\Forms\GridField\GridFieldPrintButton;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\ridFieldPageCount;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Bak\Products\Models\Product;
use Bak\Products\Models\ProductCategory;
use Bak\Products\Models\ProductUseArea;
use SilverStripe\Assets\File;

class ProductAdmin extends ModelAdmin {

    private static $managed_models = array(
        Product::class,
        ProductCategory::class,
        ProductUseArea::class
    );

    private static $menu_priority = 3;

    private static $url_segment = 'product';
    private static $menu_title = 'Produkte';
    private static $menu_icon = 'bak-products/img/icon-products.png';
    
    public $showImportForm = false;

    public function getEditForm($id = null, $fields = null) {
        $form = parent::getEditForm($id, $fields);


        //Import Usages
        $file = File::get()->byId(49);
        if ($file->exists()){
            if(($handle = fopen($file->getAbsoluteURL(), "r")) !== FALSE) {
                $delimiter = self::getFileDelimiter($file->getAbsoluteURL());
                $headers = fgetcsv($handle, 0, $delimiter);
                $imported = [0,4,5,6,8,9,11,12,13,14,15,16,17,19];
                $usages = [];
                while (($line = fgetcsv($handle,0,$delimiter)) !== FALSE) {
                    if ($line[0] != ""){
                        foreach ($imported as $key => $index) {
                            $usages[] = [$headers[$index] => $line[$index]];
                        }
                        
                    }
                }
                fclose($handle);
            }
            ob_start();
                        print_r($usages);
                        $result = ob_get_clean();
                        file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
        }

        if($this->modelClass=='Product' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
            if($gridField instanceof GridField) {
                $gridField->getConfig()->addComponent(new GridFieldOrderableRows('SortOrder'));
            }
            $form->Fields()->fieldByName("Product")->getConfig()->removeComponentsByType(GridFieldExportButton::class);
            $form->Fields()->fieldByName("Product")->getConfig()->removeComponentsByType(GridFieldPrintButton::class);           
            $form->Fields()->fieldByName("Product")->getConfig()->removeComponentsByType(GridFieldPaginator::class);
            $form->Fields()->fieldByName("Product")->getConfig()->removeComponentsByType(GridFieldPageCount::class);
        }

        if($this->modelClass=='ProductCategory' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass)))  {
            if($gridField instanceof GridField) {
                $gridField->getConfig()->addComponent(new GridFieldOrderableRows('SortOrder'));
            }
            $form->Fields()->fieldByName("ProductCategory")->getConfig()->removeComponentsByType(GridFieldExportButton::class);
	        $form->Fields()->fieldByName("ProductCategory")->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
        }

        if($this->modelClass=='ProductUseArea' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
            if($gridField instanceof GridField) {
                $gridField->getConfig()->addComponent(new GridFieldOrderableRows('SortOrder'));
            }
            $form->Fields()->fieldByName("ProductUseArea")->getConfig()->removeComponentsByType(GridFieldExportButton::class);
            $form->Fields()->fieldByName("ProductUseArea")->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
        }
        
        return $form;
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



