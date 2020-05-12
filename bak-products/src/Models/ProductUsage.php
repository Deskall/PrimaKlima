<?php

namespace Bak\Products\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Control\Director;
use SilverStripe\Core\Convert;
use Bak\Products\Models\Product;
use Bak\Products\Models\ProductUseArea;
use Bak\Products\ProductOverviewPage;

class ProductUsage extends DataObject {
    private static $db = array(
        'Title' => 'Varchar(250)',
        'MetaTitle' => 'Varchar(250)',
        'Description' => 'Text',
        'MetaDescription' => 'Text',
        'URLSegment' => 'Varchar(250)'
    );

    private static $has_one = array(
      'UseArea' => ProductUseArea::class,
      'Image' => Image::class
    );

    private static $belongs_many_many = array(
      "Products" => Product::class,
    );

    private static $singular_name = 'Anwendung';
    private static $plural_name = 'Anwendungen';
    private static $table_name = 'BAK_ProductUsage';

    private static $extensions = ['Sortable'];
  


   public function getCMSFields() {

    $fields = parent::getCMSFields();
  
    $uploadField = $fields->FieldByName('Root.Main.Image');
    $uploadField->getValidator()->allowedExtensions = array('jpg', 'gif', 'png');
    $uploadField->setFolderName("Uploads/anwendungsbilder/"); 

    return $fields;

  }



   public function onBeforeWrite(){
    parent::onBeforeWrite();
    $this->URLSegment = URLSegmentFilter::create()->filter($this->UseArea()->Title).'/'.URLSegmentFilter::create()->filter($this->Title);
  }



  public function Link() {
    $productPage = ProductOverviewPage::get()->first();
    if ($productPage){
      $URLSegment = $productPage->Link()._t('BAK.USAGESEGMENT','/anwendung/').$this->URLSegment;
    }
    return null;
  }

    /**
       * Aboslute Link to this DO
       * @return string
       */
      public function AbsoluteLink() {
        return Director::absoluteURL($this->Link());
      }

  public function printMetaDescription( ){
    $description = ( $this->MetaDescription ) ? $this->MetaDescription : strip_tags($this->Description);
    return $description;
  }


  public function printMetaTitle(){
    $title = ( $this->MetaTitle ) ? $this->MetaTitle : $this->Name;
    return $title;
  }

  public function getMetaTags() {
        $tags = '<meta name="generator" content="SilverStripe - http://silverstripe.org"><meta http-equiv="Content-type" content="text/html; charset=utf-8">';
        $tags .= '<meta name="description" content="'.$this->printMetaDescription().'">';
        $tags .= '<link rel="alternate" type="text/html" title="'.Convert::raw2xml($this->Title).'" hreflang="de" href="'.Director::AbsoluteURL($this->Link()).'" />' . "\n";
        $tags .= '<link rel="alternate" type="text/html" title="'.Convert::raw2xml($this->Title__en_US).'" hreflang="en" href="'.Director::AbsoluteURL($this->Link('en_US')).'" />' . "\n";
        $tags .= '<link rel="alternate" type="text/html" title="'.Convert::raw2xml($this->Title__es_ES).'" hreflang="es" href="'.Director::AbsoluteURL($this->Link('es_ES')).'" />' . "\n";
      

        return $tags;
        
    }



}