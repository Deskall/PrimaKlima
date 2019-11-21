<?php



use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\Forms\TextField;
use SilverStripe\Assets\File;
use SilverStripe\ORM\FieldType\DBHTMLText;

class Week extends DataObject
{
    private static $db = array(
        'Number' => 'Varchar',
        'Start' => 'Date',
        'End' => 'Date',
        'Status' => 'Varchar',
        'isBilled' => 'Boolean(0)'
    );

    private static $singular_name = "Woche";
    private static $plural_name = "Wochen";

    private static $has_one = [
        'Mission' => Mission::class,
        'File' => File::class
    ];

    private static $summary_fields = [
        'Number',
        'Start',
        'End',
        'File' => ['title' => 'Datei'],
        'NiceStatus'
    ];


    public function fieldLabels($includerelation = true){
        $labels = parent::fieldLabels($includerelation);
       
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
       
       return $fields;
    }


    public function NiceStatus(){
        if ($this->Start > date('Y-m-d')){
            return 'nicht angefangen';
        }
        if ($this->End > date('Y-m-d') && $this->Start >= date('Y-m-d')){
            return DBHTMLText::create()->setValue('<span class="btn btn-default">Offen</span>');
        }
        if ($this->End < date('Y-m-d') && !$this->File()->exists()){
            return DBHTMLText::create()->setValue('<span class="btn btn-danger">Fällig</span>');
        }
        if ($this->File()->exists() && !$this->isBilled){
            return DBHTMLText::create()->setValue('<span class="btn btn-warning">Zu verrechnen</span>');
        }
        if ($this->isBilled){
            return DBHTMLText::create()->setValue('<span class="btn btn-success">Verrechnet</span>');
        }
    }

    public function canBill(){
        return ($this->File()->exists() && !$this->isBilled);
    }

    public function Bill(){
        $this->isBilled = true;
        $this->write();
    }


}