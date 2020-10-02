<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\Forms\GridField\GridFieldPrintButton;
use SilverStripe\Forms\GridField\GridFieldPageCount;
use SilverStripe\Forms\GridField\GridFieldPaginator;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;


use SilverStripe\Assets\File;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\Image;
use SilverStripe\Control\Director;

class PortfolioAdmin extends ModelAdmin {

    private static $managed_models = [
        PortfolioCategory::class,
        PortfolioClient::class
    ];

    private static $menu_priority = 4;

    private static $url_segment = 'portfolio';
    private static $menu_title = 'Arbeiten (Portfolio)';

    public function getEditForm($id = null, $fields = null) {
        $this->makeImport();

        $form = parent::getEditForm($id, $fields);

        if($this->modelClass==PortfolioCategory::class && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
            if($gridField instanceof GridField) {
                $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'));
                $form->Fields()->fieldByName("PortfolioCategory")->getConfig()->removeComponentsByType(GridFieldExportButton::class);
                $form->Fields()->fieldByName("PortfolioCategory")->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
            }
        }

        if($this->modelClass==PortfolioClient::class && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
            if($gridField instanceof GridField) {
                $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'));
            }
            $form->Fields()->fieldByName("PortfolioClient")->getConfig()->removeComponentsByType(GridFieldExportButton::class);
            $form->Fields()->fieldByName("PortfolioClient")->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
            $form->Fields()->fieldByName("PortfolioClient")->getConfig()->removeComponentsByType(GridFieldPaginator::class);
            $form->Fields()->fieldByName("PortfolioClient")->getConfig()->removeComponentsByType(GridFieldPageCount::class);
        }

        return $form;
    }

    public function makeImport(){
        // Files references
        // $file = File::get()->byId(98);
        // if ($file->exists()){
        //     if(($handle = fopen($file->getAbsoluteURL(), "r")) !== FALSE) {
        //         $delimiter = self::getFileDelimiter($file->getAbsoluteURL());
        //         $headers = fgetcsv($handle, 0, $delimiter);
        //         $imported = [0,6];
        //         $files = [];
        //         while (($line = fgetcsv($handle,0,$delimiter)) !== FALSE) {
        //             if ($line[0] != "" && $line[1] != "Folder"){
        //                 $array = [];
        //                 foreach ($imported as $key => $index) {
        //                     $array[$headers[$index]] = trim($line[$index]);
        //                 }
        //                 $files[$line[0]] = trim($line[6]);
        //             }
        //         }
        //         fclose($handle);
        //     }
        // }


        //Import Categories
        // $file = File::get()->byId(95);
        // if ($file->exists()){
        //     if(($handle = fopen($file->getAbsoluteURL(), "r")) !== FALSE) {
        //         $delimiter = self::getFileDelimiter($file->getAbsoluteURL());
        //         $headers = fgetcsv($handle, 0, $delimiter);
        //         $imported = [0,4,5,6,7];
        //         $categories = [];
        //         while (($line = fgetcsv($handle,0,$delimiter)) !== FALSE) {
        //             if ($line[0] != ""){
        //                 $array = [];
        //                 foreach ($imported as $key => $index) {
        //                     $array[$headers[$index]] = ($line[$index] == "NULL" ) ? null : trim($line[$index]);
        //                 }
        //                 $categories[] = $array;
        //             }
        //         }
        //         fclose($handle);
               
        //         foreach ($categories as $key => $ref) {
        //            $category = PortfolioCategory::get()->filter('RefID' , $ref['ID'])->first();
        //            if (!$category){
        //             $category = new PortfolioCategory();
        //            }
        //            $category->RefID = $ref['ID'];
        //            $category->Title = $ref['Title'];
        //            $category->URLSegment = $ref['URLSegment'];
        //            $category->Sort = $ref['SortOrder'];
        //            $category->write();
        //         }
        //     }
        // }

        //Import Clients
        // $file = File::get()->byId(96);
        // if ($file->exists()){
        //     if(($handle = fopen($file->getAbsoluteURL(), "r")) !== FALSE) {
        //         $delimiter = self::getFileDelimiter($file->getAbsoluteURL());
        //         $headers = fgetcsv($handle, 0, $delimiter);
        //         $imported = [0,4,5,6,7,8,9,10,11,12,13,14,15,17];
        //         $clients = [];
        //         while (($line = fgetcsv($handle,0,$delimiter)) !== FALSE) {
        //             if ($line[0] != ""){
        //                 $array = [];
        //                 foreach ($imported as $key => $index) {
        //                     $array[$headers[$index]] = ($line[$index] == "NULL" ) ? null : trim($line[$index]);
        //                 }
        //                 $clients[] = $array;
        //             }
        //         }
        //         fclose($handle);
               
        //         foreach ($clients as $key => $ref) {
        //            $client = PortfolioClient::get()->filter('RefID' , $ref['ID'])->first();
        //            if (!$client){
        //             $client = new PortfolioClient();
        //            }
        //            $client->RefID = $ref['ID'];
        //            $client->Address = $ref['Address'];
        //            $client->Website = $ref['Website'];
        //            $client->ClientActive = $ref['ClientActive'];
        //            $client->Title = $ref['Title'];
        //            $client->URLSegment = $ref['URLSegment'];
        //            $client->Sort = $ref['SortOrder'];
        //            $client->isVisible = $ref['isVisible'];
        //            $client->write();
        //         }
        //     }
        // }

        //Import Products Images
        // $file = File::get()->byId(97);
        // if ($file->exists()){
        //     if(($handle = fopen($file->getAbsoluteURL(), "r")) !== FALSE) {
        //         $delimiter = self::getFileDelimiter($file->getAbsoluteURL());
        //         $headers = fgetcsv($handle, 0, $delimiter);
        //         $imported = [0,1,2,3];
        //         $assignments = [];
        //         while (($line = fgetcsv($handle,0,$delimiter)) !== FALSE) {
        //             if ($line[0] != ""){
        //                 $array = [];
        //                 foreach ($imported as $key => $index) {
        //                     $array[$headers[$index]] = ($line[$index] == "NULL" ) ? null : trim($line[$index]);
        //                 }
        //                 $assignments[] = $array;
        //             }
        //         }
        //         fclose($handle);

                

        //         foreach ($assignments as $key => $ref) {
        //            $client = PortfolioClient::get()->filter('RefID' , $ref['PortfolioClientID'])->first();
        //            if (!$client){
        //             continue;
        //            }
        //            $client->GalleryImages()->removeAll();
        //            $file = isset($files[$ref['ImageID']]) ? $files[$ref['ImageID']] : null;
        //            if (!$file){
        //             continue;
        //            }
        //            $filepath = str_replace("assets/Uploads", Director::baseFolder(),$file);

        //            $filepath = substr_replace($filepath,"/_resampled/SameImageW10/",strrpos($filepath, "/"),0);
        //            ob_start();
        //            print_r($filepath);
        //            $result = ob_get_clean();
        //            file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result,FILE_APPEND);

        //             if (file_exists($filepath)){
        //                 $file = new Image();
        //                 $file->setFromLocalFile($filepath);
        //                 $name = ltrim(strrchr($file,"/"), '/');
        //                 $folder = Folder::find_or_make("Uploads/portfolio/".$client->URLSegment);
        //                 $file->ParentID = $folder->ID;
        //                 $file->write();
        //                 $file->publishSingle();
        //                 $client->GalleryImages()->add($file,['SortOrder' => $ref['SortOrder']]);
        //             }

        //            $client->write();
        //         }
        //     }
        // }

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

