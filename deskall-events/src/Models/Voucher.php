<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Forms\RequiredFields;

class Voucher extends DataObject{

    private static $singular_name = 'Gutschein';

    private static $plural_name = 'Gutscheinen';

    private static $db = [
        'Title' => 'Varchar',
        // 'Price' => 'Currency',
        'Percent' => 'Decimal',
        'DateUntil' => 'Date',
        // 'isUsed' => 'Boolean(0)',
        'Token' => 'Varchar(8)' 
    ];

    private static $has_many = [
        'Orders' => Order::class
    ];


    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Title'] = _t(__CLASS__.'.Title','Titel');
        // $labels['Price'] = _t(__CLASS__.'.Price','Preis');
        $labels['Percent'] = _t(__CLASS__.'.Percent','Prozent (%)');
        $labels['DateUntil'] = _t(__CLASS__.'.DateUntil','Gültig bis');
        // $labels['isUsed'] = _t(__CLASS__.'.isUsed','benutzt');
        $labels['Token'] = _t(__CLASS__.'.Token','Gutschein-Nr.');
       
     
        return $labels;
    }

    private static $summary_fields = ['Title','Discount','DateUntil','Token','Orders.count' => ['title' => 'Bestellungen']];

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        if (!$this->Token){
            $token = $this->generateToken();
            while(Voucher::get()->filter('Token',$token)->count() > 0){
                $token = $this->generateToken();
            }
            $this->Token = $token;
        }
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->fieldByName('Root.Main.Token')->setReadonly(true);
        
        return $fields;
    }

    public function getCMSValidator(){
        return new RequiredFields(
        'Title',
        'Percent'
        );
    }

    public function Discount(){
        return DBField::create_field('Varchar','- '.$this->Percent.'%');
    }

    public function generateToken(){
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 8; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }

        return $res;
    }

    public function isValid(){
        if ($this->DateUntil){
            if ($this->DateUntil < date('Y-m-d')){
                return false;
            }
        }
        return true;
    }
}
