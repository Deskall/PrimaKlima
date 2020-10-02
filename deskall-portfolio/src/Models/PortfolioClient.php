<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Assets\Image;

class PortfolioClient extends DataObject {

    private static $singular_name = 'Kunde';
    private static $plural_name = 'Kunden';

    private static $db = [
        'Title' => 'Varchar(255)',
        'URLSegment' => 'Varchar(255)',
        'ClientActive' => 'Boolean(true)',
        'Address'   => 'HTMLText',
        'Website' => 'Varchar(255)',
        'RefID' => 'Int'
    ];

    private static $has_one = [
        'Logo' => Image::class,
        'Header' => Image::class
    ];

    private static $has_many = [
        'Testimonials' => Testimonial::class
    ];

    private static $many_many = [
        'GalleryImages'  => Image::class,
        'PortfolioCategories' => PortfolioCategory::class
    ];

    private static $many_many_extraFields = [
        'GalleryImages' => ['SortOrder' => 'Int']
    ];

    private static $extensions = [
        Activable::class,
        Sortable::class
    ];


    public function getCMSFields() {
        $fields = parent::getCMSFields();

        $fields->removeByName('URLSegment');
        $fields->removeByName('PortfolioCategories');
        $fields->removeByName('GalleryImages');
        $fields->removeByName('Testimonials');


        $fields->addFieldToTab('Root.Main',TextField::create('Title','Name'));       
        $fields->addFieldToTab('Root.Main',CheckboxField::create('ClientActive','Aktiver Kunde'));

        $fields->addFieldToTab('Root.Main',TextareaField::create('Address','Adresse / Ortschaft'));    
        $fields->addFieldToTab('Root.Main',TextField::create('Website','Website'));     


        if( $this->ID ){
            $fields->addFieldToTab('Root.Main', GridField::create(
                      'Testimonials',
                      'Kundenstimmen',
                      $this->Testimonials(),
                      GridFieldConfig_RecorEditor::create()
                      ->addComponent(new GridFieldOrderableRows('Sort'))
                      ->addComponent(new GridFieldShowHideAction())
                  )
            );
        }

        $categoriesField = CheckboxSetField::create('PortfolioCategories', 'Arbeiten', PortfolioCategory::get()->map("ID", "Title"));
        $fields->addFieldToTab('Root.Main', $categoriesField);

        $uploadImage = $fields->fieldByName('Root.Main.Logo');
        $uploadImage->setFolderName('Uploads/portfolio/'.$this->URLSegment);

        $headerImage = $fields->fieldByName('Root.Main.Header');
        $headerImage->setFolderName('Uploads/portfolio/'.$this->URLSegment);


        $galleryField = $fields->fieldByName('Root.Main.GalleryImages');
        $galleryField->setFolderName('Uploads/portfolio/'.$this->URLSegment);


        return $fields;
    }




    public function onBeforeWrite(){
        parent::onBeforeWrite();
        //TO DO : generate unique URL Segment
        
    }
}

