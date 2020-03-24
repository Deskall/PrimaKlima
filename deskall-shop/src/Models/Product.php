<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropDownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\i18n\i18n;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\Assets\Image;

class Product extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(255)',
        'Lead' => 'HTMLText',
        'Description' => 'HTMLText',
        'Price' => 'Currency',
        'TransportPrice' => 'Currency',
        'URLSegment' => 'Varchar(255)'
    );


    private static $summary_fields = array(
        'Title' => 'Titel',
    );

    private static $has_one = array(
        'Category' =>  ProductCategory::class,
        'MainBild' => Image::class
    );

    private static $many_many = ['Images' => Image::class];

    private static $many_many_extraFields = ['Images' => ['Sort' => 'Int']];

    private static $singular_name = 'Produkt';
    private static $plural_name = 'Produkte';

    private static $extensions = [
        'Activable',
        'Sortable'
    ];

    public function fieldLabels($includerelation = true){
        $labels = parent::fieldLabels($includerelation);
        $labels['Title'] = _t('Product.Title', 'Titel');
        $labels['Lead'] = _t('Product.Lead', 'Einstiegstext');
        $labels['Description'] = _t('Product.Description', 'Beschreibung');
        $labels['Price'] = _t('Product.Price', 'Preis');
        $labels['TransportPrice'] = _t('Product.TransportPrice', 'Versandkosten');
        $labels['Category'] = _t('Product.Category', 'Kategorie');
        $labels['MainBild'] = _t('Product.MainBild', 'Hauptbild');
        $labels['Images'] =  _t('Product.Images', 'Bilder');
        return $labels;
    }



    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('URLSegment');
        $fields->removeByName('CategoryID');
        $fields->removeByName('Images');
        $fields->insertAfter('MainBild',SortableUploadField::create('Images',$this->fieldLabels()['Images'])->setIsMultiUpload(true)->setFolderName($this->getFolderName()));
        

        return $fields;
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        $this->URLSegment = URLSegmentFilter::create()->filter($this->Title);
        $changedFields = $this->getChangedFields();
        if ($this->isChanged('Title') && ($changedFields['Title']['before'] != $changedFields['Title']['after']) ){
            if ($changedFields['Title']['before']){
                $oldFolderPath = $this->Category()->getFolderName().'/'.URLSegmentFilter::create()->filter($changedFields['Title']['before']);
            }
            else{
                $oldFolderPath = $this->Category()->getFolderName().'/tmp';
            }
            $newFolder = Folder::find_or_make($oldFolderPath);
            $newFolder->Name = URLSegmentFilter::create()->filter($changedFields['Title']['after']);
            $newFolder->write();
        }
    }

    public function getFolderName(){
        if($this->URLSegment){
            return $this->Category()->getFolderName().'/'.$this->URLSegment;
        }
        else{
            return $this->Category()->getFolderName().'/tmp';
        }
        
    }

    public function Link(){
        return 'shop/produkt/'.$this->URLSegment;
    }


    public function OrderLink(){
        return ShopPage::get()->first()->Link();
    }

}


