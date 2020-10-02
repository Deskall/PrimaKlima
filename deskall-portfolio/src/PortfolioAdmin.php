<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\Forms\GridField\GridFieldPrintButton;
use SilverStripe\Forms\GridField\GridFieldPageCount;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class PortfolioAdmin extends ModelAdmin {

    private static $managed_models = array(
        PortfolioCategory::class
        PortfolioClient::class
    );

    static $menu_priority = 4;

    private static $url_segment = 'portfolio';
    private static $menu_title = 'Arbeiten (Portfolio)';
    public $showImportForm = false;

    public function getEditForm($id = null, $fields = null) {
        $form = parent::getEditForm($id, $fields);

        if($this->modelClass==PortfolioCategory::class && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
            if($gridField instanceof GridField) {
                $gridField->getConfig()->addComponent(new GridFieldOrderableRows('SortOrder'));
                $form->Fields()->fieldByName("PortfolioCategory")->getConfig()->removeComponentsByType(GridFieldExportButton::class);
                $form->Fields()->fieldByName("PortfolioCategory")->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
            }
        }

        if($this->modelClass==PortfolioClient::class && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
            if($gridField instanceof GridField) {
                $gridField->getConfig()->addComponent(new GridFieldOrderableRows('SortOrder'));
            }
            $form->Fields()->fieldByName("PortfolioClient")->getConfig()->removeComponentsByType(GridFieldExportButton::class);
            $form->Fields()->fieldByName("PortfolioClient")->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
            $form->Fields()->fieldByName("PortfolioClient")->getConfig()->removeComponentsByType(GridFieldPaginator::class);
            $form->Fields()->fieldByName("PortfolioClient")->getConfig()->removeComponentsByType(GridFieldPageCount::class);
        }

        return $form;
    }
}

