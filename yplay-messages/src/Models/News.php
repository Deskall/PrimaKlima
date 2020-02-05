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
        'Lead' => 'Text'
        
    );

    private static $defaults = array(
      'Title' => 'Neuer Eintrag'
    );

    private static $extensions = [
      'Sortable',
      'Activable',
      'Subsitable',
      'Linkable'
    ];

    private static $many_many = [
        'PostalCodes'=> PostalCode::class
    ];

    private static $summary_fields = array (
      'Title' => array('title' => 'Titel'),
      'LastEdited' => 'Zuletzt geändert'
    );

    
    function getCMSValidator(){
     return new RequiredFields(['Title','Lead']);
    }


    public function getCMSFields() {
      $fields = parent::getCMSFields();
      $fields->removeByName('PostalCodes');
      $fields->addFieldToTab('Root.Main', TextField::create('Title', 'Titel')); 
      $fields->addFieldToTab('Root.Main', TextareaField::create('Lead', 'Vorschau Text')); 

      $postalcodes = DataObject::get("PostalCode")->sort(array('Code'=>'ASC'));
      $source = (SubsiteState::singleton()->getSubsiteId() > 0) ? $postalcodes->filter('SubsiteID',SubsiteState::singleton()->getSubsiteId())->map("ID", "Code") : $postalcodes->map("ID", "Code");
      $postalcodefield = ListboxField::create('PostalCodes', 'Betroffene Gemeinden', $source );
      $postalcodefield->setAttribute('data-placeholder','Alle');
      $fields->addFieldToTab('Root.Main', $postalcodefield, 'Title');

      return $fields;
  }



  public function onBeforeWrite(){

      if ($this->SubsiteID > 0 && $this->PostalCodes()->count() == 0){
        foreach (Subsite::currentSubsite()->PostalCodes() as $code) {
          $this->PostalCodes()->add($code);
        }
      }

     

      parent::onBeforeWrite();
  }


  /**
     * Link to this DO
     * @return string
     */
    public function Link() {
        return $this->LinkableLink()->getLinkURL();
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
        if (Permission::check('ADMIN')){
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