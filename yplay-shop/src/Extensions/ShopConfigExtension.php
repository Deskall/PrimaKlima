<?php



use SilverStripe\ORM\DataExtension;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Security\Group;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;

class ShopConfigExtension extends DataExtension
{
    private static $db = array(
       'OrderNumberOffset' => 'Varchar',
       'OrderEmailBody' => 'HTMLText',
       'Conditions' => 'HTMLText'
    );

    private static $has_one = [
      
       'AGBFile' => File::class
       
    ];

    private static $owns = [
       
        'AGBFile'
       
    ];


    public function updateFieldLabels(&$labels){
   
      $labels['AGBFile'] = _t(__CLASS__.'.AGBFile','AGB Datei');
      $labels['OrderNumberOffset'] = _t(__CLASS__.'.OrderNumberOffset','Bestellung Nummer Format');
    
    }

   

    public function onBeforeWrite(){
        parent::onBeforeWrite();
       
    }

    public function onAfterWrite()
    {
       
        parent::onAfterWrite();
       
    }



    public function updateCMSFields(FieldList $fields)
    {
       
       $fields->addFieldToTab('Root.Shop',UploadField::create('AGBFile',$this->owner->fieldLabels()['AGBFile'])->setIsMultiUpload(false)->setFolderName('Uploads/Shop'));
       $fields->addFieldToTab('Root.Shop',TextField::create('OrderNumberOffset',$this->owner->fieldLabels()['OrderNumberOffset']));
      
      

       
    }


    public function parseString($string,$order)
    {


        $variables = array(
            '$SiteName'       => $this->owner->Title,
            '$Datum'          => date('d.m.Y')
            // '$LoginLink'      => Controller::join_links(
            //     $absoluteBaseURL,
            //     singleton(Security::class)->Link('login')
            // ),
           
        );
        if ($order){
           foreach (array('Name', 'Vorname', 'Email','Gender','Price') as $field) {
              $variables["\$Order.$field"] = $order->$field;
           }
        }


        if ($order->Customer()){
           foreach (array('Gender','Name','FirstName','Email', 'Birthday','Address','City','PostalCode') as $field) {
              $variables["\$Customer.$field"] = $order->Customer()->$field;
           }
        

           foreach (array('printAddress','printTitle') as $method) {
              $variables["\$Customer.$method"] = $order->Customer()->{$method}();
           }
        }
        
        

        return str_replace(array_keys($variables), array_values($variables), $string);
    }
  


}