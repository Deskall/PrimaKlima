<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridFieldPrintButton;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldPageCount;

class CookAdmin extends ModelAdmin {

   private static $managed_models = array(
      'Cook' => array(
            'title' => 'Köche'),

      'CookConfig'  => array(
            'title' => 'Konfiguration'),


      'CookApplication'  => array(
            'title' => 'Bewerbungen'),
   );


   private static $menu_priority = 3;

   private static $url_segment = 'cook';
   private static $menu_title = 'Köche';
   private static $menu_icon = 'deskall-koecheportal/images/icon-cooks.png';
   
   public $showImportForm = false;

      public function getEditForm($id = null, $fields = null) {
       $form = parent::getEditForm($id, $fields);


       if($this->modelClass=='Cook' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
//           $form->Fields()->fieldByName("Cook")->getConfig()->removeComponentsByType('GridFieldExportButton');
           $form->Fields()->fieldByName("Cook")->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
           $form->Fields()->fieldByName("Cook")->getConfig()->removeComponentsByType(GridFieldPaginator::class);
           $form->Fields()->fieldByName("Cook")->getConfig()->removeComponentsByType(GridFieldPageCount::class);
       }

       if($this->modelClass=='CookApplication' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
//           $form->Fields()->fieldByName("Cook")->getConfig()->removeComponentsByType('GridFieldExportButton');
           $form->Fields()->fieldByName("CookApplication")->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
           $form->Fields()->fieldByName("CookApplication")->getConfig()->removeComponentsByType(GridFieldPaginator::class);
           $form->Fields()->fieldByName("CookApplication")->getConfig()->removeComponentsByType(GridFieldPageCount::class);
       }


       return $form;
       //'<div id="calendar"></div>';
   }
}
