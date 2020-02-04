<?php

use SilverStripe\Admin\ShopAdmin;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\Forms\GridField\GridFieldPrintButton;

class ShopAdmin extends ModelAdmin {

    // public function subsiteCMSShowInMenu(){
    //     return true;
    // }

   private static $managed_models = array(
       'Shop' => array ('title' => 'Shop')
   );



    static $menu_priority = 6;
//    static $menu_icon = 'deskall-news/img/news-16x16.png';
    // static $menu_icon = 'yplay-shop-finder/images/icon-shop.png';
    private static $url_segment = 'shop-finder';
    private static $menu_title = 'Shop Finder';
    public $showImportForm = false;

    public function getEditForm($id = null, $fields = null) {
        $form = parent::getEditForm($id, $fields);

        if($this->modelClass=='Shop' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) 
        {
           
            $form->Fields()->fieldByName("Shop")->getConfig()->removeComponentsByType(GridFieldExportButton::class);
            $form->Fields()->fieldByName("Shop")->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
            $form->Fields()->fieldByName("Shop")->getConfig()->addComponent(new GridFieldDuplicateAction());

            //Import Shops
            
            // $file = File::get()->byId(16820);
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


        return $form;
    }

    public function getList(){
        $list = parent::getList();
        // $list =  $list->filter('SubsiteID',Subsite::currentSubsiteID());
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

