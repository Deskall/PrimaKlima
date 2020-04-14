<?php

namespace Bak\Products;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\Forms\GridField\GridFieldPrintButton;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\ridFieldPageCount;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class ProductAdmin extends ModelAdmin {

    private static $managed_models = array(
        'Product',
        'ProductCategory',
        'ProductUseArea'
    );

    static $menu_priority = 3;

    private static $url_segment = 'product';
    private static $menu_title = 'Produkte';
    static $menu_icon = 'bak-products/img/icon-products.png';
    
    public $showImportForm = false;

    public function getEditForm($id = null, $fields = null) {
        $form = parent::getEditForm($id, $fields);

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
}



