<?php



use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Security\Group;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\CMS\Model\SiteTree;

class EventConfig extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar'
    );

    private static $singular_name = "Einstellungen";
    private static $plural_name = "Einstellungen";

    private static $has_one = [
       'MainPage' => SiteTree::class,
       'AllEventsPage' => SiteTree::class
    ];


    private static $summary_fields = [
        'Title' => ['title' => 'Titel']
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Title'] = _t(__CLASS__.'.Title','Titel');
    $labels['MainPage'] = _t(__CLASS__.'.MainPage','Haupt Kurse Seite');
    $labels['AllEventsPage'] = _t(__CLASS__.'.AllEventsPage','Kurse Termine Seite');
   

    
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
       $fields->addFieldToTab('Root.Main',TreeDropdownField::create('MainPageID',$this->fieldLabels()['MainPage']));
       $fields->addFieldToTab('Root.Main',TreeDropdownField::create('MainPageID',$this->fieldLabels()['MainPage']));
       
      

       return $fields;
    }

    public function parseString($string)
    {
        $variables = array(
            
        );
        

        return str_replace(array_keys($variables), array_values($variables), $string);
    }
    


}