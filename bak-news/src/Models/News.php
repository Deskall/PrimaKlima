<?php

use SilverStripe\ORM\DataObject;

class News extends DataObject {
    static $singular_name = 'Neuigkeit';
    static $plural_name = 'Neuigkeiten';

    private static $db = array(
        'Title' => 'Varchar(250)',
        'Lead' => 'Text',
        'Content' => 'HTMLText',
        'URLSegment' => 'Varchar(250)',
        'PublishDate' => 'Datetime',
        'ArchiveDate' => 'Datetime',
        'Status' => 'Varchar(250)'
    );

    static $defaults = array(
      'Title' => 'Neuer Eintrag',
      'URLSegment' => 'neuer-eintrag',
      'Title__en_US' => 'New entry',
      'URLSegment__en_us' => 'new-entry',
      'Title__es_ES' => 'Nueva entrada',
      'URLSegment__es_ES' => 'nueva-entrada',
      'Status' => 'ToBePublished'
    );

    static $indexes = array(
      'URLSegment' => true
    );

    static $has_one = array(
      'Image' => Image::class
    );
   
    static $many_many = array(
      'Categories' => NewsCategory::class
    );

    static $summary_fields = array (
      'Title' => array('title' => 'Titel'),
      'showCategories' => 'Kategorien'
    );

    protected function showCategories() {
      $categories = $this->Categories();
      $str = '';
      foreach ($categories as $category )
        $str = $str.$category->Title.',';

      return $str;
    }

    function getCMSValidator(){
     return new News_Validator();
    }

    public function getCMSFields() {

      $fields = FieldList::create();
      $fields->add($this->getTranslatableTabSet());
      $categories = DataObject::get("NewsCategory")->sort(array('Categories.Title'=>'ASC'));
      $categoriesField = CheckboxSetField::create('Categories', 'Kategorien', $source = $categories->map("ID", "Title"));
      $fields->addFieldToTab('Root.Global', $categoriesField );
      $fields->addFieldToTab('Root.Global', OptionSetField::create('Status', 'Status', array('ToBePublished' => 'Entwurf', 'Published' => 'Veröffentlicht', 'Archived' => 'Archiviert')));
      $publishDate = DateField::create('PublishDate','Datum der Veröffentlichung')->setConfig('showcalendar',true)->addExtraClass('inline-field');
      $archiveDate = DateField::create('ArchiveDate','Bis')->setConfig('showcalendar',true)->addExtraClass('inline-field');
      $groupDate = FieldGroup::create($publishDate, $archiveDate)->setTitle('Veröffentlichung')->addExtraClass('handlepublish');
      $fields->addFieldToTab('Root.Global', $groupDate);

      $uploadImage = null;
      $uploadImage = UploadField::create('Image', 'Newsbild');
      $uploadImage->getValidator()->allowedExtensions = array('jpg', 'gif', 'png');
      $uploadImage->setFolderName("Uploads/news-detail/".$this->URLSegment);
      $fields->addFieldToTab('Root.Global', $uploadImage);

      $fields->removeByName('URLSegment');
      $fields->removeByName('URLSegment__en_US');
      $fields->removeByName('URLSegment__es_ES');
      $fields->removeByName('Status__es_ES');
      $fields->removeByName('Status__en_US');

      if($this->ID > 0){

        $gridfieldConfig = singleton('Block')->has_extension('Sortable')
          ? GridFieldConfig_BlockEditor::create('SortOrder')
          : GridFieldConfig_BlockEditor::create();

        $gridfieldConfig->removeComponent($gridfieldConfig->getComponentByType('GridFieldShowHideUserFriendlyDataObject'));
        $gridfieldConfig->removeComponent($gridfieldConfig->getComponentByType('GridFieldDeleteRestoreUserFriendlyDataObject'));
        $gridfieldConfig->addComponent(new GridFieldDeleteAction());

        $gridField_DE = GridField::create('Blocks_DE', _t('PageBlocks.BLOCK', 'Deutschblock', 'GridField Title'), $this->Blocks_DE(), $gridfieldConfig );
        $gridField_DE->setModelClass('Block');

        $fields->addFieldsToTab('Root.deDE', array(
          $gridField_DE
        ));

        $gridField_EN = GridField::create('Blocks_EN', _t('PageBlocks.BLOCK', 'Englishblock', 'GridField Title'), $this->Blocks_EN(), $gridfieldConfig );
        $gridField_EN->setModelClass('Block');
        $fields->addFieldsToTab('Root.enUS', array(
          $gridField_EN
        ));

        $gridField_ES = GridField::create('Blocks_ES', _t('PageBlocks.BLOCK', 'Spanishblock', 'GridField Title'), $this->Blocks_ES(), $gridfieldConfig );
        $gridField_ES->setModelClass('Block');
        $fields->addFieldsToTab('Root.esES', array(
          $gridField_ES
        ));
      }
      else{
        $fields->addFieldsToTab('Root.deDE', array(
            LiteralField::create('BlockInfo', '<div class="field text"><label class="left" >Blöcke:</label><div class="middleColumn">Blöcke können erst nach dem Speichern erstellt werden</div></div>')
        ));
         $fields->addFieldsToTab('Root.enUS', array(
            LiteralField::create('BlockInfo', '<div class="field text"><label class="left" >Blöcke:</label><div class="middleColumn">Blöcke können erst nach dem Speichern erstellt werden</div></div>')
        ));
        $fields->addFieldsToTab('Root.esES', array(
            LiteralField::create('BlockInfo', '<div class="field text"><label class="left" >Blöcke:</label><div class="middleColumn">Blöcke können erst nach dem Speichern erstellt werden</div></div>')
        ));
      }
      return $fields;
  }



  public function onBeforeWrite(){

      $oldFolderName =  "Uploads/news-detail/".$this->URLSegment;

      if($this->isChanged('Title')){
        $newFolderName = "Uploads/news-detail/".singleton('SiteTree')->generateURLSegment($this->Title); 

        if ( strcmp($oldFolderName, $newFolderName) != 0)   {
            $imageFolder = Folder::find($oldFolderName);

            if($imageFolder){
              $imageFolder->setName(basename($newFolderName));
              $imageFolder->write();
            }
        }
      }

      $this->URLSegment = singleton('SiteTree')->generateURLSegment($this->Title); 
      $this->URLSegment__en_US = singleton('SiteTree')->generateURLSegment($this->Title__en_US);
      $this->URLSegment__es_ES = singleton('SiteTree')->generateURLSegment($this->Title__es_ES);

      parent::onBeforeWrite();
  }



  public function hasCategory($ID){

    $query = new SQLQuery();

    $query->setFrom('News_Categories')->setSelect('COUNT(*)')->addWhere('NewsID = '.$this->ID)->addWhere('NewsCategoryID = '.$ID);

   $count = $query->execute()->value();

   return ($count > 0) ? true : false;

  }

  /**
     * Link to this DO
     * @return string
     */
    public function Link($Locale) {
      switch ($Locale){
        case "de_DE":
        $URLSegment = '/neuigkeiten/detail/'.$this->URLSegment;
        break;
        case "en_US":
        $URLSegment = '/news/detail/'.$this->URLSegment__en_US;
        break;
        case "es_ES":
         $URLSegment = '/noticias/detalle/'.$this->URLSegment__es_ES;
        break;
        default:
        $URLSegment = '/neuigkeiten/detail/'.$this->URLSegment;
        break;
      }
      return $URLSegment;
    }

    /**
       * Aboslute Link to this DO
       * @return string
       */
      public function AbsoluteLink($Locale = null) {
        return Director::absoluteURL($this->Link($Locale));
      }

    /**
     * Fields that compose the Title
     * eg. array('Title', 'Subtitle');
     * @return array
     */
    public function getTitleFields() {
        return array('Title');
    }

    /**
     * Fields that compose the Content
     * eg. array('Teaser', 'Content');
     * @return array
     */
    public function getContentFields() {
        return array('Lead');
    }
}

/** News Controller
 * handle publishing and archiving
 * @author deskall
 */
class News_Controller extends Page_Controller {

  public function onBeforeInit() {
    $date = date('Y-m-d H:i:s');
    $toPublishNews =  News::get()->filter(array('Status' => 'ToBePublished', 'PublishDate:LessThan' => $date));
    foreach ($toPublishNews as $new){
        $new->Status = "Published";
        $new->write();
    }
    $toArchiveNews =  News::get()->filter(array('Status' => 'Published','ArchiveDate:LessThan' => $date));
    foreach ($toArchiveNews as $new){
        $new->Status = "Archived";
        $new->write();
    }
  }
}

/**
 * News Validator
 *
 * @author deskall
 */
class News_Validator extends RequiredFields {
  protected $customRequired = array('Title');

  /**
   * Constructor
   */
  public function __construct() {
    $required = func_get_args();
    if(isset($required[0]) && is_array($required[0])) {
      $required = $required[0];
    }
    $required = array_merge($required, $this->customRequired);
    parent::__construct($required);
  }

  /**
   * Check if the submitted member data is valid (server-side)
   *
   * Check if a news publish and archive dates are consistent
   *
   * @param array $data Submitted data
   * @return bool Returns TRUE if the submitted data is valid, otherwise
   *              FALSE.
   * @author deskall
   */
  function php($data) {
    if ($data['Status'] == "ToBePublished"){
      $PublishDate = new \Datetime();
      $PublishDate->setTimestamp(strtotime($data['PublishDate']));
      $ArchiveDate = new \Datetime();
      $ArchiveDate->setTimestamp(strtotime($data['ArchiveDate']));

      if ($PublishDate->format('Y-m-d') < date('Y-m-d H:i:s')){
        $this->validationError("PublishDate", "Das Datum der Veröffentlichung kann nicht in der Vergangenheit sein.", 'error');
        $valid = false;
      }
      if ($PublishDate > $ArchiveDate){
        $this->validationError("ArchiveDate", "Das ArchivesDatum muss nach dem Datum der Veröffentlichung sein.", 'error');
        $valid = false;
      }
    }
     $valid = parent::php($data);
     return $valid;
  }
}