<?php



use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Security\Group;

class MenuConfig extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar'
    );

    private static $singular_name = "Einstellungen";
    private static $plural_name = "Einstellungen";

    private static $has_one = [
       'CarteFile' => File::class
      
    ];

    private static $owns = [
        'CarteFile'
    ];

    private static $summary_fields = [
        'Title' => ['title' => 'Titel']
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Title'] = _t(__CLASS__.'.Title','Titel');
    $labels['CarteFile'] = _t(__CLASS__.'.CarteFile','Karte Vorlage');
    
    return $labels;
    }

   

    public function onBeforeWrite(){
        parent::onBeforeWrite();
       
    }

    public function onAfterWrite()
    {
       
        parent::onAfterWrite();
       
    }



    public function getCMSFields()
    {
       $fields = parent::getCMSFields();

       $fields->addFieldToTab('Root.Main',UploadField::create('CarteFile',$this->fieldLabels()['CarteFile'])->setFolderName('Uploads/Vorlagen'));
    

       return $fields;
    }



}