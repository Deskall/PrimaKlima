<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\Image;

class ProductCategory extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(255)',
        'Description' => 'HTMLText',
        'URLSegment' => 'Varchar(255)'
    );


    private static $cascade_duplicates = ['Products'];

    private static $cascade_delete = ['Products'];

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


    public function onBeforeWrite(){
        parent::onBeforeWrite();
        $this->URLSegment = URLSegmentFilter::create()->filter($this->Title);
        if ($this->isChanged('Title') && ($changedFields['Title']['before'] != $changedFields['Title']['after']) ){
                $oldFolderPath = 'Uploads/Webshop/'.URLSegmentFilter::create()->filter($changedFields['Title']['before']);
                $newFolder = Folder::find_or_make($oldFolderPath);
                $newFolder->Name = $changedFields['Title']['after'];
                $newFolder->Title = $changedFields['Title']['after'];
                $newFolder->write();
            
        }
        if ($this->Image()->exists()){
            $folder = Folder::find_or_make($this->getFolderName());
            $this->Image()->ParentID = $folder->ID;
            $this->Image()->write();
            $this->Image()->publishSingle();
        }
    }

    public function onAfterWrite()
    {
        if ($this->isChanged('ImageID')){
            $changedFields = $this->getChangedFields();
            $oldPicture = Image::get()->byId($changedFields['ImageID']['before']);
            if ($oldPicture){
                $oldPicture->File->deleteFile();
                DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($oldPicture->ID));
                $oldPicture->delete();
            }
        }
        
        parent::onAfterWrite();
       
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->fieldByName('Root.Main.Image')->setFolderName($this->getFolderName());


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

}


