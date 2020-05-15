<?php

namespace Bak\Products\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Core\Convert;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\LiteralField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Control\Director;
use Bak\Products\Models\ProductUsage;
use Bak\Products\ProductOverviewPage;

class ProductUseArea extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(250)',
        'URLSegment' => 'Varchar(250)',
    );

    private static $has_many = array(
    'Usages' => ProductUsage::class,
    );

    private static $extensions = ['Sortable'];


    private static $singular_name = 'Anwendungsbereich';
    private static $plural_name = 'Anwendungsbereiche';
    private static $table_name = 'BAK_ProductUseArea';


   public function getCMSFields() {

    $fields = parent::getCMSFields();
    $fields->removeByName('Usages');
    if ($this->ID){
      $gridfieldConfig = GridFieldConfig_RelationEditor::create();
      $gridfieldConfig->addComponent(new GridFieldOrderableRows('Sort'));
      $UsagesField = new GridField(
              'Usages',
              'Anwendungen',
              $this->Usages(),
               $gridfieldConfig
          );
      $fields->addFieldToTab('Root.Anwendungen', $UsagesField);
    }
    else{
        $fields->addFieldsToTab('Root.Anwendungen', array(
            LiteralField::create('BlockInfo', '<div class="field text"><label class="left" >Anwendungen:</label><div class="middleColumn">Anwendungen können erst nach dem Speichern erstellt werden</div></div>')
        ));

    }
    $fields->removeByName('URLSegment');
 
    return $fields;

  }

  public function onBeforeWrite(){
      $this->URLSegment = URLSegmentFilter::create()->filter($this->Title);
      parent::onBeforeWrite();
  }

   public function Link() {
    $productPage = ProductOverviewPage::get()->first();
    if ($productPage){
      return $productPage->Link()._t('BAK.USEAREASEGMENT','anwendungsbereich/').$this->URLSegment;
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


}