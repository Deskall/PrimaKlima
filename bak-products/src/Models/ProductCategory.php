<?php

namespace Bak\Products\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Control\Director;
use SilverStripe\View\Parsers\URLSegmentFilter;
use Bak\Products\Models\Product;
use SilverStripe\Core\Convert;
use Bak\Products\ProductOverviewPage;

class ProductCategory extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(250)',
        'MetaTitle' => 'Varchar(250)',
        'Description' => 'HTMLText',
        'MetaDescription' => 'Text',
        'URLSegment' => 'Varchar(250)',
        'NameSingular' => 'Varchar(250)',
    );

    private static $has_one = array(
    'ProductCategoryImage' => Image::class,
    );

    private static $extensions = ['Sortable'];

    private static $belongs_many_many = array(
    "Products" => Product::class,
    );

    private static $singular_name = 'Kategorie';
    private static $plural_name = 'Kategorien';
    private static $table_name = 'BAK_ProductCategory';


    private static $default_sort = 'SortOrder ASC';

    private static $summary_fields = array (
      'Title' => array('title' => 'Titel')
    );

    private static $searchable_fields = array (
      'Title' => array('title' => 'Kategorie')
    );

   public function getCMSFields() {

    $fields = parent::getCMSFields();
    $uploadField = $fields->FieldByName('Root.Main.ProductCategoryImage');
    $uploadField->getValidator()->allowedExtensions = array('jpg', 'gif', 'png');
    $uploadField->setFolderName("Uploads/kategoriebilder/"); 

    return $fields;

  }

  public function onBeforeWrite(){
    
        $this->URLSegment = URLSegmentFilter::create()->filter($this->Title);
   
      
     
      parent::onBeforeWrite();
  }

  public function Link() {
    print_r($this->Title);
    $productPage = ProductOverviewPage::get()->first();
    print_r($productPage->Title);
    if ($productPage){
      $URLSegment = $productPage->Link()._t('BAK.CATEGORYSEGMENT','/kategorie/').$this->URLSegment;
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

  public function printMetaDescription( $Locale ){
    switch($Locale){
      case "de_DE":
      $description = ( $this->MetaDescription ) ? $this->MetaDescription : strip_tags($this->Description);
      break;
      case "en_US":
      $description = ( $this->MetaDescription__en_US ) ? $this->MetaDescription__en_US : strip_tags($this->Description__en_US);
      break;
      case "es_ES":
      $description = ( $this->MetaDescription__es_ES ) ? $this->MetaDescription__es_ES : strip_tags($this->Description__es_ES);
      break;
      default:
      $description = ( $this->MetaDescription ) ? $this->MetaDescription : strip_tags($this->Description);
      break;
    }

    return $description;
  }


  public function printMetaTitle( $Locale ){
     switch($Locale){
      case "de_DE":
      $title = ( $this->MetaTitle ) ? $this->MetaTitle : $this->Name;
      break;
      case "en_US":
       $title = ( $this->MetaTitle__en_US ) ? $this->MetaTitle__en_US : $this->Name__en_US;
      break;
      case "es_ES":
       $title = ( $this->MetaTitle__es_ES ) ? $this->MetaTitle__es_ES : $this->Name__es_ES;
      break;
      default:
       $title = ( $this->MetaTitle ) ? $this->MetaTitle : $this->Name;
      break;
    }
    return $title;
  }

  public function getMetaTags($locale) {
      $tags = '<meta name="generator" content="SilverStripe - http://silverstripe.org"><meta http-equiv="Content-type" content="text/html; charset=utf-8">';
      $tags .= '<meta name="description" content="'.$this->printMetaDescription( $locale ).'">';
      $tags .= '<link rel="alternate" type="text/html" title="'.Convert::raw2xml($this->Title).'" hreflang="de" href="'.Director::AbsoluteURL($this->Link('de_DE')).'" />' . "\n";
      $tags .= '<link rel="alternate" type="text/html" title="'.Convert::raw2xml($this->Title__en_US).'" hreflang="en" href="'.Director::AbsoluteURL($this->Link('en_US')).'" />' . "\n";
      $tags .= '<link rel="alternate" type="text/html" title="'.Convert::raw2xml($this->Title__es_ES).'" hreflang="es" href="'.Director::AbsoluteURL($this->Link('es_ES')).'" />' . "\n";
    

      return $tags;
      
  }
}