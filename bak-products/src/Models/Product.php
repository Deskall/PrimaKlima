<?php

namespace Bak\Products\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Control\Director;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Folder;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use Bak\Products\Models\ProductCategory;
use Bak\Products\Models\ProductUseArea;
use SilverStripe\Core\Convert;
use Bak\Products\Models\ProductVideoObject;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\FieldType\DBHTMLText;
use Embed\Adapters\Adapter;
use Embed\Embed;
use Bak\Products\ProductOverviewPage;

class Product extends DataObject {

    private static $singular_name = 'Produkt';
    private static $plural_name = 'Produkte';
    private static $table_name = 'BAK_Product';

    private static $db = array(
        'Name' => 'Text',
        'HeaderText' => 'Text',
        'Lead' => 'Text',
        'Description' => 'Text',
        'Features' => 'HTMLText',
        'Table' => 'HTMLText',
        'URLSegment' => 'Varchar(250)',
        'ShowDetail' => 'Boolean(true)',
        'Number' => 'Varchar(250)',
        'Videos' => 'Text',
        'VideosHTML' => 'HTMLText',
        'MetaDescription' => 'Text',
        'MetaTitle' => 'Varchar(255)',
        'RefID' => 'Int'
    );


    private static $defaults = array(
      'Name' => 'Neuer Eintrag',
      'URLSegment' => 'neuer-eintrag',
      'ShowDetail' => 'Boolean(true)',      
    );

    private static $indexes = array(
      'URLSegment' => true
    );

    private static $extensions = ['Sortable'];

    private static $has_one = array(
      'MainImage' => Image::class,
      'HeaderImage' =>  Image::class
    );

    private static $many_many = array(
      'Images' => Image::class,
      'Downloads' => File::class,
      'Downloads__en_US' => File::class,
      'Downloads__es_ES' => File::class,
      'Downloads__fr_FR' => File::class,
      'Categories' => ProductCategory::class,
      'Usages' => ProductUsage::class
    );

    private static $many_many_extraFields = array(
      'Downloads' => array('SortOrder' => 'Int'),
      'Downloads__en_US' => array('SortOrder' => 'Int'),
      'Downloads__es_ES' => array('SortOrder' => 'Int'),
      'Downloads__fr_FR' => array('SortOrder' => 'Int'),
      'Images' => array('SortOrder' => 'Int'),
    );


    private static $searchable_fields = array (
      'Name' => array('title' => 'Produkt'),
      'Categories.Title' => array('title' => 'Kategorie'),
      'Usages.Title' => array('title' => 'Kategorie')
    );

    private static $summary_fields = array (
      'Name' => array('title' => 'Produkt'),
      'showCategories' => 'Kategorien',
      'showUsages' => 'Anwendungen'
    );

    public function canView($member = null) {
        return true;
    }

    protected function showCategories() {

      $categories = $this->Categories();
      $str = '';
      foreach ($categories as $category )
        $str = $str.$category->Title.',';

      return $str;
    }

    protected function showUsages() {

      $usages = $this->Usages();
      $str = '';
      foreach ($usages as $usage )
        $str = $str.$usage->Title.',';

      return $str;
    }

    public function fieldLabels($includerelation=true){
      $labels = parent::fieldLabels($includerelation);
      $labels['Lead'] = 'Titel';
      $labels['Description'] = 'Lead';

      return $labels;
    }


    public function getCMSFields() {

      $fields = parent::getCMSFields();
      $fields->removeByName('Categories');
      $fields->removeByName('Usages');
      $fields->removeByName('VideosHTML');
      $fields->removeByName('Downloads');
      $fields->removeByName('Downloads__en_US');
      $fields->removeByName('Downloads__es_ES');
      $fields->removeByName('Downloads__fr_FR');
      $fields->removeByName('Images');
      $categoriesField = CheckboxSetField::create('Categories', 'Kategorien', $source = ProductCategory::get()->map("ID", "Title"));
      $fields->insertAfter('Name', $categoriesField );
      $usagesField = CheckboxSetField::create('Usages', 'Anwendungen', $source = ProductUsage::get()->map("ID", "Title"));
      $fields->insertAfter('Categories', $usagesField );
      $fields->dataFieldByName('MainImage')->setFolderName($this->getFolderName());
      $fields->dataFieldByName('HeaderImage')->setFolderName($this->getFolderName());
      $fields->push(SortableUploadField::create('Images',_t(__CLASS__.'.Images','Bilder'))->setIsMultiUpload(true)->setFolderName($this->getFolderName()));
      $fields->push(SortableUploadField::create('Downloads',_t(__CLASS__.'.Files','Dateien (DE)'))->setIsMultiUpload(true)->setFolderName($this->getFolderName()));
      $fields->push(SortableUploadField::create('Downloads__en_US',_t(__CLASS__.'.FilesEN','Dateien (EN)'))->setIsMultiUpload(true)->setFolderName($this->getFolderName()));
      $fields->push(SortableUploadField::create('Downloads__es_ES',_t(__CLASS__.'.FilesES','Dateien (SP)'))->setIsMultiUpload(true)->setFolderName($this->getFolderName()));
      $fields->push(SortableUploadField::create('Downloads__fr_FR',_t(__CLASS__.'.FilesFR','Dateien (FR)'))->setIsMultiUpload(true)->setFolderName($this->getFolderName()));
      
      return $fields;

  }

  public function onBeforeWrite(){


      if ($this->isChanged('Videos')){
          $this->updateEmbedHTML();
      }

      $changedFields = $this->getChangedFields();
      //Update Folder Name
      if ($this->isChanged('URLSegment') && ($changedFields['URLSegment']['before'] != $changedFields['URLSegment']['after'])){
          $oldFolderPath = "Uploads/produkte/".$changedFields['URLSegment']['before'];
          $newFolder = Folder::find_or_make($oldFolderPath);
          $newFolder->Name = $changedFields['URLSegment']['after'];
          $newFolder->Title = $changedFields['URLSegment']['after'];
          $newFolder->write();
      }

      $this->URLSegment =  URLSegmentFilter::create()->filter($this->Name);
      
      parent::onBeforeWrite();
  }

  public function getFolderName(){
    if ($this->URLSegment){
      return "Uploads/produkte/".$this->URLSegment;
    }
    return "Uploads/produkte/tmp";
  }

  public function hasCategory($ID){
    $count = ManyManyList::create(Product::class,'BAK_Product_Categories','BAK_ProductID','BAK_ProductCategoryID')->filter(['BAK_ProductID' => $this->ID,'BAK_ProductCategoryID' => $ID] )->count();
    return ($count > 0) ? true : false;
  }

  //Videos
  /**
   * @return $this
   */
  public function Embed()
  {
      $this->setFromURL($this->SourceURL);

      return $this;
  }


  public function updateEmbedHTML()
  {
    $content = null;
    if ($this->Videos){
      $content = '<div class="uk-grid-small uk-child-width-1-2@m" data-uk-grid>';
      foreach (preg_split('/\r\n|[\r\n]/', $this->Videos) as $url){
       $html = $this->setFromURL($url);
       if ($html){
        $html = str_replace("<iframe ","<iframe data-uk-responsive ",$html);
        $content .= '<div>'.$html.'</div>';
       }
      }
      $content .= '</div>';
    }
    
    $this->VideosHTML = $content;
  }

  /**
   * @param $url
   */
  public function setFromURL($url)
  {
      if ($url) {
          // array('image' => array('minImageWidth' => $this->Width, 'minImageHeight' => $this->Height)));
          $info = Embed::create($url);
          $embed = $this->setFromEmbed($info);
          return $embed;
      }
  }

  /**
   * @param Adapter $info
   */
  public function setFromEmbed(Adapter $info)
  {
      $this->Title = $info->getTitle();
      $this->SourceURL = $info->getUrl();
      $this->Width = $info->getWidth();
      $this->Height = $info->getHeight();
      $this->ThumbURL = $info->getImage();
      $this->Description = $info->getDescription() ? $info->getDescription() : $info->getTitle();
      $this->Type = $info->getType();
      $embed = $info->getCode();
      return $embed;
  }

    
  /**
     * Link to this DO
     * @return string
     */
    public function Link() {
     
      $productPage = ProductOverviewPage::get()->first();
      if ($productPage){
        return $productPage->Link().'detail/'.$this->URLSegment;
      }
      
      return null;
    }

    /**
       * Aboslute Link to this DO
       * @return string
       */
      public function AbsoluteLink($Locale = null) {
        return Director::absoluteURL($this->Link());
      }


    /**
     * Filter array
     * eg. array('Disabled' => 0);
     * @return array
     */
    public static function getSearchFilter() {
        return array();
    }

    /**
     * Fields that compose the Title
     * eg. array('Title', 'Subtitle');
     * @return array
     */
    public function getTitleFields() {
        return array('Name');
    }

    /**
     * Fields that compose the Content
     * eg. array('Teaser', 'Content');
     * @return array
     */
    public function getContentFields() {
        return array('Lead');
    }


  public function ProductMetaTags() {
      $tags = '<meta http-equiv="Content-type" content="text/html; charset=utf-8">';
      $tags .= '<meta name="description" content="'.$this->getProductMetaDescription().'">';
      $tags .= $this->renderWith('FluentProduct_MetaTags');

      return $tags;
      
  }



  public function getProductMetaDescription( ){
    $description = ( $this->MetaDescription ) ? $this->MetaDescription : $this->Description;
    return $description;
  }


  public function getProductMetaTitle( ){
    $title = ( $this->MetaTitle ) ? $this->MetaTitle : $this->Categories()->First()->NameSingular.' '.$this->Name;
    return $title;
  }

  public function getAllProducts( ){

    $products = Product::get()->sort(array('Sort' => 'DESC'));
    $str = "";
    foreach( $products as $product ){
      if( $this->ID == $product->ID ){
       $str .= '<label><input name="products[]" type="checkbox" checked="checked" value="'.$product->Name.'">'.$product->Name.'</label>';
      }else{
        $str .= '<label><input name="products[]" type="checkbox" value="'.$product->Name.'">'.$product->Name.'</label>';
      }
    }
    $output = new DBHTMLText();
    $output->setValue($str);
    return $output;
  }

  public function StructuredData(){
      $html = '<script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Product",
      "name": "'.$this->Name.', '.str_replace("\n"," ",strip_tags($this->Lead)).'",
      "image": "'.Director::AbsoluteURL($this->MainImage()->getURL()).'",
      "description": "'.$this->getProductMetaDescription().'",
      "brand": {
        "@type": "Thing",
        "name": "BAK AG"
      },
      "sku": "'.$this->ID.'"
    }
    </script>';

    return DBField::create_field('HTMLText',$html);

  }
}