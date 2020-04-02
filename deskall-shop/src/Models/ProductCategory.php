<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DB;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\SiteConfig\SiteConfig;

class ProductCategory extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(255)',
        'Description' => 'HTMLText',
        'URLSegment' => 'Varchar(255)'
    );


    private static $cascade_duplicates = ['Products'];

    private static $cascade_deletes = ['Products'];

    private static $summary_fields = array(
        'Title' => 'Titel',
    );


    private static $has_one = array(
        'Image' =>  Image::class,
    );

    private static $has_many = array(
        'Products' =>  Product::class,
    );

    private static $singular_name = 'Kategorie';
    private static $plural_name = 'Kategorien';

    private static $extensions = [
        'Activable',
        'Sortable'
    ];

    public function fieldLabels($includerelation = true){
        $labels = parent::fieldLabels($includerelation);
        $labels['Title'] = 'Titel';
        $labels['Description'] = 'Beschreibung';
        $labels['Products'] =  'Produkte';
        $labels['Image'] =  'Bild';

        return $labels;
    }


    public function onBeforeWrite(){
        parent::onBeforeWrite();
        $this->URLSegment = URLSegmentFilter::create()->filter($this->Title);
        $changedFields = $this->getChangedFields();
        if ($this->isChanged('Title') && ($changedFields['Title']['before'] != $changedFields['Title']['after']) ){
                if ($changedFields['Title']['before']){
                    $oldFolderPath = 'Uploads/Webshop/'.URLSegmentFilter::create()->filter($changedFields['Title']['before']);
                }
                else{
                    $oldFolderPath = 'Uploads/Webshop/tmp';
                }
                $newFolder = Folder::find_or_make($oldFolderPath);
                $newFolder->Name = URLSegmentFilter::create()->filter($changedFields['Title']['after']);
                $newFolder->write();
            
        }
    }

  

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('URLSegment');
        $fields->fieldByName('Root.Main.Image')->setFolderName($this->getFolderName());
        if ($this->ID > 0 ){
            $config = new GridFieldConfig_RecordEditor();
            $config->addComponent(new GridFieldShowHideAction())->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldDuplicateAction());
            $fields->fieldByName('Root.Products.Products')->setConfig($config);
        }
        

        return $fields;
    }

    public function getFolderName(){
        if($this->URLSegment){
            return 'Uploads/Webshop/'.$this->URLSegment;
        }
        else{
            return 'Uploads/Webshop/tmp';
        }
    }

    public function Link(){
        return 'shop/kategorie/'.$this->URLSegment;
    }

    public function activeProducts(){
        return $this->Products()->filter('isVisible',1)->sort('Sort');
    }

    public function getSiteConfig(){
        return SiteConfig::current_site_config();
    }

}


