<?php
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridFieldPrintButton;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use SilverStripe\Forms\GridField\GridFieldPageCount;

class EmployerAdmin extends ModelAdmin {

   private static $managed_models = array(
      'Employer' => array(
            'title' => 'Arbeitgeber'),

      'EmployerConfig'  => array(
            'title' => 'Konfiguration'),
   );


   private static $menu_priority = 3;

   private static $url_segment = 'employer';
   private static $menu_title = 'Arbeitgeber';
   private static $menu_icon = 'deskall-koecheportal/images/icon-employer.png';
   
   public $showImportForm = false;

      public function getEditForm($id = null, $fields = null) {
       $form = parent::getEditForm($id, $fields);


       if($this->modelClass=='Employer' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
//           $form->Fields()->fieldByName("Cook")->getConfig()->removeComponentsByType('GridFieldExportButton');
           $form->Fields()->fieldByName("Employer")->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
           $form->Fields()->fieldByName("Employer")->getConfig()->removeComponentsByType(GridFieldPaginator::class);
           $form->Fields()->fieldByName("Employer")->getConfig()->removeComponentsByType(GridFieldPageCount::class);
       }


       return $form;
       //'<div id="calendar"></div>';
   }
}
