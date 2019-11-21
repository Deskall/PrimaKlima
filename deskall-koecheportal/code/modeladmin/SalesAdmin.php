<?php
use SilverStripe\Admin\ModelAdmin;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldPrintButton;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldPageCount;

class SalesAdmin extends ModelAdmin {

   private static $managed_models = array(
      'Package' => array(
            'title' => 'Pakete'),

      'PackageConfigItem'  => array(
            'title' => 'Pakete-Features'),

      'PackageOrder'  => array(
            'title' => 'Bestellungen'),

      'Coupon'  => array(
            'title' => 'Gutscheine'),
   );


   private static $menu_priority = 3;

   private static $url_segment = 'sales';
   private static $menu_title = 'Verkauf';
   private static $menu_icon = 'deskall-koecheportal/images/icon-verkauf.png';
   
   public $showImportForm = false;

      public function getEditForm($id = null, $fields = null) {
       $form = parent::getEditForm($id, $fields);


       if($this->modelClass=='Package' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
           $form->Fields()->fieldByName("Package")->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
           $form->Fields()->fieldByName("Package")->getConfig()->removeComponentsByType(GridFieldPaginator::class);
           $form->Fields()->fieldByName("Package")->getConfig()->removeComponentsByType(GridFieldPageCount::class);
           $form->Fields()->fieldByName("Package")->getConfig()->addComponent(new GridFieldOrderableRows('SortOrder'));
       }

       if($this->modelClass=='PackageConfigItem' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
           $form->Fields()->fieldByName("PackageConfigItem")->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
           $form->Fields()->fieldByName("PackageConfigItem")->getConfig()->removeComponentsByType(GridFieldPaginator::class);
           $form->Fields()->fieldByName("PackageConfigItem")->getConfig()->removeComponentsByType(GridFieldPageCount::class);
           $form->Fields()->fieldByName("PackageConfigItem")->getConfig()->addComponent(new GridFieldOrderableRows('SortOrder'));
       }

       if($this->modelClass=='PackageOrder' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
           $form->Fields()->fieldByName("PackageOrder")->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
           $form->Fields()->fieldByName("PackageOrder")->getConfig()->removeComponentsByType(GridFieldPaginator::class);
           $form->Fields()->fieldByName("PackageOrder")->getConfig()->removeComponentsByType(GridFieldPageCount::class);
           $form->Fields()->fieldByName("PackageOrder")->getConfig()->addComponent(new GridFieldPayOrder());

       }



       return $form;

   }
}
