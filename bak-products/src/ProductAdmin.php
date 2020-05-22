<?php

namespace Bak\Products;
use SplFileObject;
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
use Bak\Products\Models\ProductUsage;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Folder;
use SilverStripe\Control\Director;

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

        // //Files references
        // $file = File::get()->byId(585);
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

        // //Products / Categories
        // $file = File::get()->byId(1136);
        // if ($file->exists()){
        //     if(($handle = fopen($file->getAbsoluteURL(), "r")) !== FALSE) {
        //         $delimiter = self::getFileDelimiter($file->getAbsoluteURL());
        //         $headers = fgetcsv($handle, 0, $delimiter);
        //         while (($line = fgetcsv($handle,0,$delimiter)) !== FALSE) {
        //             if ($line[0] != ""){
        //                 $product = Product::get()->filter('RefID',$line[1])->first();
        //                 $category = ProductCategory::get()->byId($line[2]);
        //                 if ($product && $category){
        //                   $category->Products()->add($product);
        //                 }
        //             }
        //         }
        //         fclose($handle);
        //     }
        // }

        // //Products / Usages
        // $file = File::get()->byId(1135);
        // if ($file->exists()){
        //     if(($handle = fopen($file->getAbsoluteURL(), "r")) !== FALSE) {
        //         $delimiter = self::getFileDelimiter($file->getAbsoluteURL());
        //         $headers = fgetcsv($handle, 0, $delimiter);
        //         while (($line = fgetcsv($handle,0,$delimiter)) !== FALSE) {
        //             if ($line[0] != ""){
        //                 $product = Product::get()->filter('RefID',$line[1])->first();
        //                 $usage = ProductUsage::get()->filter('RefID',$line[2])->first();
        //                 if ($product && $usage){
        //                   $usage->Products()->add($product);
        //                 }
        //             }
        //         }
        //         fclose($handle);
        //     }
        // }

        // //Products / Downloads
        // $file = File::get()->byId(1209);
        // if ($file->exists()){
        //     if(($handle = fopen($file->getAbsoluteURL(), "r")) !== FALSE) {
        //         $delimiter = self::getFileDelimiter($file->getAbsoluteURL());
        //         $headers = fgetcsv($handle, 0, $delimiter);
        //         while (($line = fgetcsv($handle,0,$delimiter)) !== FALSE) {
        //             if ($line[0] != ""){
        //                 $product = Product::get()->filter('RefID',$line[1])->first();
        //                 $file = isset($files[$line[2]]) ? $files[$line[2]] : null;
        //                 if ($product && $file){

        //                      $filepath = str_replace("assets/Uploads", Director::baseFolder(),$file);
                             
                            
        //                      if (file_exists($filepath)){
        //                          $file = new File();
        //                          $file->setFromLocalFile($filepath);
        //                          $name = ltrim(strrchr($file,"/"), '/');
        //                          $folder = Folder::find_or_make($product->getFolderName());
        //                          $file->ParentID = $folder->ID;
        //                          $file->write();
        //                          $file->publishSingle();
        //                          $product->Downloads()->add($file,['SortOrder' => $line[3]]);
        //                      }
        //                      else{
        //                        ob_start();
        //                               print_r('no file: '.$filepath);
        //                               $result = ob_get_clean();
        //                               file_put_contents($_SERVER['DOCUMENT_ROOT']."/log-downloads.txt", $result,FILE_APPEND);
        //                      }
        //                  }
        //                  else{
        //                               ob_start();
        //                               print_r('not found: '.$line[0]);
        //                               $result = ob_get_clean();
        //                               file_put_contents($_SERVER['DOCUMENT_ROOT']."/log-downloads.txt", $result,FILE_APPEND);
        //                  }
        //               }
                    
        //         }
        //         fclose($handle);
        //     }
        // }

        //Products / Downloads US
        // $file = File::get()->byId(1210);
        // if ($file->exists()){
        //     if(($handle = fopen($file->getAbsoluteURL(), "r")) !== FALSE) {
        //         $delimiter = self::getFileDelimiter($file->getAbsoluteURL());
        //         $headers = fgetcsv($handle, 0, $delimiter);
        //         while (($line = fgetcsv($handle,0,$delimiter)) !== FALSE) {
        //             if ($line[0] != ""){
        //                 $product = Product::get()->filter('RefID',$line[1])->first();
        //                 $file = isset($files[$line[2]]) ? $files[$line[2]] : null;
        //                 if ($product && $file){

        //                      $filepath = str_replace("assets/Uploads", Director::baseFolder(),$file);
                             
                            
        //                      if (file_exists($filepath)){
        //                          $file = new File();
        //                          $file->setFromLocalFile($filepath);
        //                          $name = ltrim(strrchr($file,"/"), '/');
        //                          $folder = Folder::find_or_make($product->getFolderName());
        //                          $file->ParentID = $folder->ID;
        //                          $file->write();
        //                          $file->publishSingle();
        //                          $product->Downloads__en_US()->add($file,['SortOrder' => $line[3]]);
        //                      }
        //                      else{
        //                        ob_start();
        //                               print_r('no file: '.$filepath);
        //                               $result = ob_get_clean();
        //                               file_put_contents($_SERVER['DOCUMENT_ROOT']."/log-downloads.txt", $result,FILE_APPEND);
        //                      }
        //                  }
        //                  else{
        //                               ob_start();
        //                               print_r('not found: '.$line[0]);
        //                               $result = ob_get_clean();
        //                               file_put_contents($_SERVER['DOCUMENT_ROOT']."/log-downloads.txt", $result,FILE_APPEND);
        //                  }
        //               }
                    
        //         }
        //         fclose($handle);
        //     }
        // }

        //Products / Downloads ES
        // $file = File::get()->byId(1211);
        // if ($file->exists()){
        //     if(($handle = fopen($file->getAbsoluteURL(), "r")) !== FALSE) {
        //         $delimiter = self::getFileDelimiter($file->getAbsoluteURL());
        //         $headers = fgetcsv($handle, 0, $delimiter);
        //         while (($line = fgetcsv($handle,0,$delimiter)) !== FALSE) {
        //             if ($line[0] != ""){
        //                 $product = Product::get()->filter('RefID',$line[1])->first();
        //                 $file = isset($files[$line[2]]) ? $files[$line[2]] : null;
        //                 if ($product && $file){

        //                      $filepath = str_replace("assets/Uploads", Director::baseFolder(),$file);
                             
                            
        //                      if (file_exists($filepath)){
        //                          $file = new File();
        //                          $file->setFromLocalFile($filepath);
        //                          $name = ltrim(strrchr($file,"/"), '/');
        //                          $folder = Folder::find_or_make($product->getFolderName());
        //                          $file->ParentID = $folder->ID;
        //                          $file->write();
        //                          $file->publishSingle();
        //                          $product->Downloads__es_ES()->add($file,['SortOrder' => $line[3]]);
        //                      }
        //                      else{
        //                        ob_start();
        //                               print_r('no file: '.$filepath);
        //                               $result = ob_get_clean();
        //                               file_put_contents($_SERVER['DOCUMENT_ROOT']."/log-downloads.txt", $result,FILE_APPEND);
        //                      }
        //                  }
        //                  else{
        //                               ob_start();
        //                               print_r('not found: '.$line[0]);
        //                               $result = ob_get_clean();
        //                               file_put_contents($_SERVER['DOCUMENT_ROOT']."/log-downloads.txt", $result,FILE_APPEND);
        //                  }
        //               }
                    
        //         }
        //         fclose($handle);
        //     }
        // }

        // ob_start();
        //             print_r($files);
        //             $result = ob_get_clean();
        //             file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);

        //Import Products
        // $file = File::get()->byId(584);
        // if ($file->exists()){
        //     if(($handle = fopen($file->getAbsoluteURL(), "r")) !== FALSE) {
        //         $delimiter = self::getFileDelimiter($file->getAbsoluteURL());
        //         $headers = fgetcsv($handle, 0, $delimiter);
        //         $imported = [0,4,5,6,7,8,9,11,12,14,15,16,17,18,19,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,37,38,39,40,41,42,43,44,45,46,48,49,50,51];
        //         $products = [];
        //         while (($line = fgetcsv($handle,0,$delimiter)) !== FALSE) {
        //             if ($line[0] != ""){
        //                 $array = [];
        //                 foreach ($imported as $key => $index) {
        //                     $array[$headers[$index]] = ($line[$index] == "NULL" ) ? null : trim($line[$index]);
        //                 }
        //                 $products[] = $array;
        //             }
        //         }
        //         fclose($handle);
                
                // foreach (Product::get() as $p) {
                //     $p->delete();
                // }
                // foreach ($products as $key => $ref) {
                //    $product = Product::get()->filter('RefID' , $ref['ID'])->first();
                //    if (!$product){
                //     $product = new Product();
                //    }
                   // $product->RefID = $ref['ID'];
                   // $product->Name = $ref['Name'];
                   // $product->HeaderText = $ref['HeaderText'];
                   // $product->Lead = $ref['Lead'];
                   // $product->Description = $ref['Description'];
                   // $product->Features = $ref['Features'];
                   // $product->Table = $ref['Table'];
                   // $product->Videos = $ref['Videos'];
                   // $product->Number = $ref['Number'];
                   // $product->MetaDescription = $ref['MetaDescription'];
                   // $product->MetaTitle = $ref['MetaTitle'];
                   // $product->Sort = $ref['SortOrder'];
                   
                   // $product->Name = $ref['Name__en_US'];
                   // $product->HeaderText = $ref['HeaderText__en_US'];
                   // $product->Lead = $ref['Lead__en_US'];
                   // $product->Description = $ref['Description__en_US'];
                   // $product->Features = $ref['Features__en_US'];
                   // $product->Table = $ref['Table__en_US'];
                   // $product->Videos = $ref['Videos__en_US'];
                   // $product->Number = $ref['Number__en_US'];
                   // $product->MetaDescription = $ref['MetaDescription__en_US'];
                   // $product->MetaTitle = $ref['MetaTitle__en_US'];

                   // $product->Name = $ref['Name__es_ES'];
                   // $product->HeaderText = $ref['HeaderText__es_ES'];
                   // $product->Lead = $ref['Lead__es_ES'];
                   // $product->Description = $ref['Description__es_ES'];
                   // $product->Features = $ref['Features__es_ES'];
                   // $product->Table = $ref['Table__es_ES'];
                   // $product->Videos = $ref['Videos__es_ES'];
                   // $product->Number = $ref['Number__es_ES'];
                   // $product->MetaDescription = $ref['MetaDescription__es_ES'];
                   // $product->MetaTitle = $ref['MetaTitle__es_ES'];

                   // Files
                   // if ($product && !$product->MainImage()->exists()){
                   //  if ($ref['MainImageID'] > 0 && isset($files[$ref['MainImageID']])){

                   //      $filepath = str_replace("assets/Uploads", Director::baseFolder(),$files[$ref['MainImageID']]);
                        
                       
                   //      if (file_exists($filepath)){
                   //          $image = new Image();
                   //          $image->setFromLocalFile($filepath);
                   //          $name = ltrim(strrchr($files[$ref['MainImageID']],"/"), '/');
                   //          $folder = Folder::find_or_make($product->getFolderName());
                   //          $image->ParentID = $folder->ID;
                   //          $image->write();
                   //          $image->publishSingle();
                   //          $product->MainImageID = $image->ID;
                   //          $product->{'MainImage.ID'} = $image->ID;
                   //      }
                   //  }
                   // }

        //            $product->write();
        //         }
        //     }
        // }

       
        // //Import Usages
        // $file = File::get()->byId(586);
        // if ($file->exists()){
        //     if(($handle = fopen($file->getAbsoluteURL(), "r")) !== FALSE) {
        //         $delimiter = self::getFileDelimiter($file->getAbsoluteURL());
        //         $headers = fgetcsv($handle, 0, $delimiter);
        //         $imported = [0,4,5,6,8,9,11,12,13,14,15,16,17,19];
        //         $usages = [];
        //         while (($line = fgetcsv($handle,0,$delimiter)) !== FALSE) {
        //             if ($line[0] != ""){
        //                 $array = [];
        //                 foreach ($imported as $key => $index) {
        //                     $array[$headers[$index]] = trim($line[$index]);
        //                 }
        //                 $usages[] = $array;
        //             }
        //         }
        //         fclose($handle);
        //     }
            
        //     foreach ($usages as $key => $ref) {
        //        $usage = ProductUsage::get()->filter('RefID' , $ref['ID'])->first();
        //        if (!$usage){
        //         $usage = new ProductUsage();
        //        }
        //        // $usage->RefID = $ref['ID'];
        //        // $usage->Title = $ref['Title__es_ES'];
        //        // $usage->Sort = $ref['SortOrder'];
        //        // $usage->Description = $ref['Description__es_ES'];
        //        // $usage->UseAreaID = $ref['UseAreaID'];
        //        // $usage->MetaTitle = $ref['MetaTitle__en_US'];

        //         if ($ref['ImageID'] > 0 && isset($files[$ref['ImageID']])){

        //             $filepath = str_replace("assets/Uploads", Director::baseFolder(),$files[$ref['ImageID']]);
                    
                   
        //             if (file_exists($filepath)){
        //                 $image = new Image();
        //                 $image->setFromLocalFile($filepath);
        //                 $name = ltrim(strrchr($files[$ref['ImageID']],"/"), '/');
        //                 $folder = Folder::find_or_make("Uploads/anwendungsbilder");
        //                 $image->ParentID = $folder->ID;
        //                 $image->write();
        //                 $image->publishSingle();
        //                 $usage->ImageID = $image->ID;
        //                 $usage->{'Image.ID'} = $image->ID;
        //             }
        //         }
               

        //        $usage->write();
        //     }
        // }



        if($this->modelClass == Product::class && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
            if($gridField instanceof GridField) {
                $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'));
                $gridField->getConfig()->removeComponentsByType(GridFieldExportButton::class);
                $gridField->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
            }        
        }

        if($this->modelClass == ProductCategory::class && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass)))  {
            if($gridField instanceof GridField) {
                $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'));
                $gridField->getConfig()->removeComponentsByType(GridFieldExportButton::class);
	            $gridField->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
            }
        }

        if($this->modelClass == ProductUseArea::class && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
            if($gridField instanceof GridField) {
                $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'));
                $gridField->getConfig()->removeComponentsByType(GridFieldExportButton::class);
                $gridField->getConfig()->removeComponentsByType(GridFieldPrintButton::class);
            }
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



