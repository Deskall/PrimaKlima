<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Folder;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Subsites\State\SubsiteState;
use SilverStripe\Subsites\Model\Subsite;
use SilverStripe\ORM\FieldType\DBText;

class News extends DataObject implements Searchable
{ 
    private static $singular_name = 'Meldung';
    private static $plural_name = 'Meldungen';

    private static $db = array(
        'Title' => 'Varchar(250)',
        'Lead' => 'Text',
        'Content' => 'HTMLText',
        'URLSegment' => 'Varchar(250)',
        'PublishDate' => 'Datetime',
        'ArchiveDate' => 'Datetime',
        'Status' => 'Varchar(250)',
        'BildFormat' => 'Varchar(255)'
    );

    private static $defaults = array(
      'Title' => 'Neuer Eintrag',
      'URLSegment' => 'neuer-eintrag',
      'Status' => 'ToBePublished',
    );

    private static $indexes = array(
      'URLSegment' => true
    );

    private static $has_one = array(
      'Image' => Image::class  
    );

    private static $extensions = [
      'Sortable',
      'Activable',
      'Subsitable'
    ];

    private static $many_many = [
        'PostalCodes'=> PostalCode::class
    ];

    private static $summary_fields = array (
      'Title' => array('title' => 'Titel'),
      'LastEdited' => 'Zuletzt geändert',
      'showStatus' => 'Status'
    );

    public function showCategories() {
      $categories = $this->Categories();
      $str = '';
      foreach ($categories as $category )
        $str = $str.$category->Title.',';

      return $str;
    }

    public function showStatus() {
      $status = $this->Status;
      $str = '';
      switch($status){
        case "ToBePublished":
          $str.= ($this->PublishDate !== null) ? "Würde veröffentlicht am ".$this->PublishDate : "Entwurf";
          break;
        case "Published":
          $str.= ($this->ArchiveDate !== null) ? "Veröffentlicht bis ".$this->ArchiveDate : "Veröffentlicht seit ".$this->PublishDate;
          break;
        case "Archived":
          $str.= "Archiviert";
          break;

      }

      return DBText::create()->setValue($str);
    }

    function getCMSValidator(){
     return new News_Validator();
    }


    public function getCMSFields() {
      Requirements::javascript('yplay-messages/js/news.js');
      $fields = parent::getCMSFields(); 
      $fields->removeByName('URLSegment');
      $fields->removeByName('Categories');
       $fields->removeByName('SortOrder');
      $fields->removeByName('NewsBlocks');
      $fields->removeByName('Blocks');
      $fields->removeByName('PublishDate');
      $fields->removeByName('ArchiveDate');

      $fields->removeByName('PostalCodes');



      $fields->addFieldToTab('Root.Main', OptionsetField::create('Status', 'Status', array('ToBePublished' => 'Entwurf', 'Published' => 'Veröffentlicht', 'Archived' => 'Archiviert')),'Title');
      $publishDate = TextField::create('PublishDate','Datum der Veröffentlichung')->addExtraClass('inline-field');
      $archiveDate = TextField::create('ArchiveDate','Bis')->addExtraClass('inline-field');

      $groupDate = FieldGroup::create($publishDate, $archiveDate)->setTitle('Veröffentlichung')->addExtraClass('handlepublish')->setDescription('Format: tt.mm.jjjj HH:ii');
      $fields->addFieldToTab('Root.Main', $groupDate, 'Title');


      $fields->addFieldToTab('Root.DetailSeite', HeaderField::create('DetailHeader', 'Erfassen Sie hier Inhalte, wenn die Meldung eine eigene Seite erhalten soll.', 2)); 


      $fields->addFieldToTab('Root.Main', DropdownField::create('Template','Von Meldungsvorlage einfügen', NewsTemplate::get()->filter('SubsiteID',array(0,SubsiteState::singleton()->getSubsiteId()))->map('ID','Title'))->setEmptyString('Typ auswählen'));

      $fields->addFieldToTab('Root.Main', TextField::create('Title', 'Titel')); 
      $fields->addFieldToTab('Root.Main', TextareaField::create('Lead', 'Vorschau Text')); 






      $uploadImage = null;
      $uploadImage = UploadField::create('Image', 'Bild');
      $uploadImage->getValidator()->allowedExtensions = array('jpg', 'gif', 'png');
      $uploadImage->setFolderName("Uploads/meldungen/".$this->URLSegment);
      $fields->addFieldToTab('Root.DetailSeite', $uploadImage );



      $fields->insertAfter(DropdownField::create('BildFormat','Bild Format', 
        array(
          'normal' => 'Bild links, auf 350x250 px zugeschnitten',
          'links'=>'Bild links, originale Seitenverhältnisse',
          'padded'=>'Bild links, mit Weissraum und Rahmen (für Logos geeignet)',
          'big' =>'Bild auf Inhaltsbreite skalieren' )), 'Image'); 


      $fields->addFieldToTab('Root.DetailSeite', HTMLEditorField::create('Content', 'Kurzer Einstieg')); 
      $fields->fieldByName('Root.DetailSeite.Content')->setTitle('Einstiegstext')->setRows(10);



      $postalcodes = DataObject::get("PostalCode")->sort(array('Code'=>'ASC'));
      $source = (SubsiteState::singleton()->getSubsiteId() > 0) ? $postalcodes->filter('SubsiteID',SubsiteState::singleton()->getSubsiteId())->map("ID", "Code") : $postalcodes->map("ID", "Code");
      $postalcodefield = ListboxField::create('PostalCodes', 'Betroffene Gemeinden', $source );
      $postalcodefield->setMultiple(true);
      $postalcodefield->setEmptyString('Alle');
      $fields->addFieldToTab('Root.Main', $postalcodefield, 'Status');



      return $fields;
  }



  public function onBeforeWrite(){

    if ($this->isChanged('Status') && $this->Status == "Published" ){
        $this->PublishDate = date('d.m.Y H:i:s');
    }

      $oldFolderName =  "Uploads/meldungen/".$this->URLSegment;

      if($this->isChanged('Title')){
        $newFolderName = "Uploads/meldungen/".singleton('SiteTree')->generateURLSegment($this->Title);

        if ( strcmp($oldFolderName, $newFolderName) != 0)   {
            $imageFolder = Folder::find($oldFolderName);

            if($imageFolder){
              $imageFolder->setName(basename($newFolderName));
              $imageFolder->write();
            }
        }
      }

      if ($this->SubsiteID > 0 && $this->PostalCodes()->count() == 0){
        foreach (Subsite::currentSubsite()->PostalCodes() as $code) {
          $this->PostalCodes()->add($code);
        }
      }

      $this->URLSegment = $this->generateURL();

      parent::onBeforeWrite();
  }


public function generateURL(){
  $publishDate = new Datetime();
  $publishDate->setTimestamp(strtotime($this->PublishDate));
  $URL = 'details/'.$publishDate->format('Y').'/'.$publishDate->format('m').'-'.$publishDate->format('d').'-'.singleton('SiteTree')->generateURLSegment($this->Title);
  return $URL;
}

  public function hasLink(){
    return $this->Image()->ID || $this->Content;
  }



  /**
     * Link to this DO
     * @return string
     */
    public function Link() {
        return 'meldungen/'.$this->generateURL();
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


    public function canCreate($member = null, $context = []){
        if (Permission::check('CMS_ACCESS_NewsAdmin')){
            return true;
        }
        return false;
    }

    public function canView($member = null){
        return $this->canCreate($member);
    }

    public function canEdit($member = null){
        $member = Member::currentUser();
        if ($this->ID == 0 || $this->SubsiteID == $member->SubsiteID || Permission::check('ADMIN')){
            return true;
        }
        return false;
    }


    public function canDelete($member = null)
    {
        return Permission::check('ADMIN') || $this->canEdit($member);
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
       if ($data['PublishDate']){
        $PublishDate = new \Datetime();
        $PublishDate->setTimestamp(strtotime($data['PublishDate']));
      } else {
        $PublishDate = null;
      }
        if ($data['ArchiveDate']){
           $ArchiveDate = new \Datetime();
           $ArchiveDate->setTimestamp(strtotime($data['ArchiveDate']));
        }
        else {
          $ArchiveDate = null;
        }
    if ( $PublishDate && $PublishDate->format('Y-m-d H:i:s') < date('Y-m-d H:i:s')){
        $this->validationError("PublishDate", "Das Datum der Veröffentlichung kann nicht in der Vergangenheit sein.", 'error');
        $valid = false;
      }
      if ( $ArchiveDate && $PublishDate && $PublishDate > $ArchiveDate){
        $this->validationError("ArchiveDate", "Das Datum der Archivierung muss nach dem Datum der Veröffentlichung sein.", 'error');
        $valid = false;
      }
    }
     $valid = parent::php($data);
     return $valid;
  }
}
