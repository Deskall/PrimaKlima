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
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
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
use SilverStripe\Assets\Folder;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\ORM\FieldType\DBCurrency;

class Product extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(255)',
        'Lead' => 'HTMLText',
        'Description' => 'HTMLText',
        'Price' => 'Currency',
        'URLSegment' => 'Varchar(255)',
        'Stock' => 'Varchar(255)'
    );


    private static $summary_fields = array(
        'Title' => 'Titel',
    );

    private static $defaults = ['Stock' => 'onStock'];

    private static $has_one = array(
        'Category' =>  ProductCategory::class,
        'MainBild' => Image::class
    );

    private static $many_many = ['Images' => Image::class];

    private static $many_many_extraFields = ['Images' => ['Sort' => 'Int']];

    private static $has_many = ['Variants' => ProductVariant::class];

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
        $labels['Category'] = _t('Product.Category', 'Kategorie');
        $labels['MainBild'] = _t('Product.MainBild', 'Hauptbild');
        $labels['Images'] =  _t('Product.Images', 'Bilder');
        $labels['Variants'] =  _t('Product.Variants', 'Produkt Varianten');
        $labels['Stock'] =  _t('Product.Stock', 'Lagerbestand');
        return $labels;
    }


    public function HeaderSlide(){
        return $this->Category()->getSiteConfig()->ShopPage()->HeaderSlide();
    }


    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('CategoryID');
        $fields->removeByName('Images');
        $fields->insertAfter('MainBild',SortableUploadField::create('Images',$this->fieldLabels()['Images'])->setIsMultiUpload(true)->setFolderName($this->getFolderName()));
        $config = new GridFieldConfig_Base();
        $config->removeComponentsByType([GridFieldDataColumns::class])
            ->addComponent(new GridFieldButtonRow('before'))
            ->addComponent(new GridFieldEditableColumns())
            ->addComponent(new GridFieldAddNewInlineButton())
            ->addComponent(new GridFieldOrderableRows('Sort'))
            ->addComponent(new GridFieldStockAction())
            ->addComponent(new GridFieldStandardVariantAction())
            ->addComponent(new GridFieldDeleteAction());
        $fields->fieldbyName('Root.Variants.Variants')->setConfig($config);
        return $fields;
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        if ($this->isChanged('Title') || !$this->URLSegment){
            $this->URLSegment = URLSegmentFilter::create()->filter($this->Title);
        }
        $changedFields = $this->getChangedFields();
        if ($this->isChanged('URLSegment') && ($changedFields['URLSegment']['before'] != $changedFields['URLSegment']['after']) ){
            if ($changedFields['URLSegment']['before']){
                $oldFolderPath = $this->Category()->getFolderName().'/'.$changedFields['URLSegment']['before'];
            }
            else{
                $oldFolderPath = $this->Category()->getFolderName().'/tmp';
            }
            $newFolder = Folder::find_or_make($oldFolderPath);
            $newFolder->Name = $changedFields['URLSegment']['after'];
            $newFolder->write();
        }
        if ($this->Variants()->exists()){
            if (!$this->StandardVariant()){
                $standard = $this->Variants()->first();
                $standard->Default = true;
                $standard->write();
            }
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

    public function StandardVariant(){
        return $this->Variants()->filter('Default',1)->first();
    }


    public function LowerPrice(){
        if ($this->Variants()->exists()){
            $price = $this->Variants()->sort('Price','ASC')->Price;
        }
        else{
            $price = $this->Price;
        }
        return DBCurrency::create()->setValue($price);
    }

    public function soldoff(){
        $this->Stock = "soldOff";
        $this->write();
    }

    public function onstock(){
        $this->Stock = "onStock";
        $this->write();
    }

}


