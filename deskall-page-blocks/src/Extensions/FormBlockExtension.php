<?php
use DNADesign\ElementalUserForms\Model\ElementForm;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\UserForms\Control\UserDefinedFormController;
use SilverStripe\UserForms\UserForm;
use SilverStripe\Control\Controller;
use DNADesign\ElementalUserForms\Control\ElementFormController;
use SilverStripe\Forms\RequiredFields;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\Forms\TextField;
use SilverStripe\UserForms\Model\Recipient\EmailRecipient;

class FormBlockExtension extends DataExtension 
{

    private static $controller_template = 'ElementHolder';

    private static $description = 'Formular';

   
    
   private static $db = [
    'ButtonBackground' => 'Varchar(255)',
    'HTML' => 'HTMLText'
   ];

   private static $defaults = [
    'ShowLabels' => 1,
    'Layout' => 'standard'
  ];

   private static $has_one = [
    'RedirectPage' => SiteTree::class
   ];

   public function updateFieldLabels(&$labels){
      $labels['ButtonBackground'] = _t('Form.ButtonBackground','Button Hintergrundfarbe');
   }


    private static $block_layouts = [
        'standard' =>  [
            'value' => 'standard',
            'title' => 'Standard Formular Layout',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-left-align.svg'
        ],
        'vertical' => [
            'value' => 'vertical',
            'title' => 'Vertical Formular',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-right-align.svg'
        ]
    ];


   private static $controller_class = DeskallFormController::class;

   public function updateCMSFields(FieldList $fields){
    $fields->removeByName('Layout');
    $fields->removeByName('TextLayout');
    $fields->removeByName('RedirectPageID');
    $fields->removeByName('FormOptions');
     $fields->addFieldToTab('Root.Main',TreeDropdownField::create('RedirectPageID',_t('Form.RedirectPage', 'erfolgreiche Einreichungsseite'), SiteTree::class));
      $fields->addFieldToTab('Root.LayoutTab',TextField::create('SubmitButtonText',_t('Form.SubmitButtonText','Button Text')));
     $fields->addFieldToTab('Root.LayoutTab',HTMLDropdownField::create('ButtonBackground',_t('Form.ButtonBackground','Button Hintergrundfarbe'),SiteConfig::current_site_config()->getBackgroundColors())->addExtraClass('colors'));

     $fields->fieldByName('Root.FormFields')->setTitle(_t('Form.FormFields','Felder'));
     $fields->fieldByName('Root.Submissions')->setTitle(_t('Form.Submissions','Anfragen'));
     $fields->fieldByName('Root.Recipients')->setTitle(_t('Form.Recipients','Empfänger'));
     if ($this->owner->ID == 0){ 
      $fields->removeByName('FormFields');
      $fields->removeByName('Submissions');
      $fields->removeByName('Recipients');
     }

   
   }

  public function getCMSValidator()
      {
          return new RequiredFields([
              'RedirectPageID'
          ]);
      }

  public function getType()
  {
    return _t(__CLASS__ . '.BlockType', 'Formular');
  }

  public function onAfterDuplicate($origin){
    $recipients = EmailRecipient::get()->filter('FormID',$origin->ID);
    foreach($recipients as $recipient){
      $newR = $recipient->duplicate(false);
      $newR->FormID = $this->owner->ID;
      $newR->write();
    }
  }

  public function onBeforeDelete(){
    parent::onBeforeDelete();
    $recipients = EmailRecipient::get()->filter('FormID',$this->owner->ID);
    foreach($recipients as $recipient){
      $recipient->delete();
    }
  }


  /**
     * @return UserForm
     */
    public function CustomForm()
    {
        $controller = UserDefinedFormController::create($this->owner);
        $current = Controller::curr();
        $controller->setRequest($current->getRequest());
        $form = $controller->Form();

        if ($current && $current->getAction() == 'finished') {
            return $controller->renderWith(UserDefinedFormController::class .'_ReceivedFormSubmission');
        }
        
        if ($this->owner->isChildren()){
          $form->setFormAction(
              Controller::join_links(
                  $current->Link(),
                  'children',
                  $this->owner->ID,
                  $this->owner->Parent()->getOwnerPage()->ID,
                  'Form'
              )
          );
        }
        else{
           $form->setFormAction(
            Controller::join_links(
                $current->Link(),
                'element',
                $this->owner->ID,
                'Form'
            )
          );

        }
       
       
        return $form;
    }

    public function Link($action = null)
    {
        $current = Controller::curr();
        if ($action === 'finished') {
            if ($this->owner->isChildren()){
              return Controller::join_links(
                  str_replace('element','children',$current->Link()),
                  $this->owner->Parent()->getOwnerPage()->ID,
                  'finished'
              );
            }
            else{
              return Controller::join_links(
                  $current->Link(),
                  'finished'
              );
            }
            
        }

        return parent::Link($action);
    }


}
