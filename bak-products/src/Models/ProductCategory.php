<?php

namespace Bak\Products\Models;

use Sortable;
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

    private static $extensions = [Sortable::class];

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

    public function canView($member = null) {
        return true;
    }

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
    $productPage = ProductOverviewPage::get()->first();
    if ($productPage){
      return $productPage->Link()._t('BAK.CATEGORYSEGMENT','kategorie/').$this->URLSegment;
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

  public function printMetaDescription(){
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
      $tags .= $this->renderWith('FluentProduct_MetaTags');
    

      return $tags;
      
  }
}