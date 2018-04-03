<?php 

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\DataExtension;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Assets\Image;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;

class SiteConfigLayoutExtension extends DataExtension 
{

  private static $db = [
    'FooterBackground' => 'Varchar(255)'
  ];

  private static $has_many = [
    'FooterBlocks' => FooterBlock::class
  ];

      private static $backgrounds = [
        'uk-section-default' => 'keine Hintergrundfarbe',
        'uk-section-primary dk-text-hover-primary' => 'primäre Farbe',
        'uk-section-secondary dk-text-hover-secondary' => 'sekundäre Farbe',
        'uk-section-muted dk-text-hover-muted' => 'grau',
        'dk-background-white uk-section-default dk-text-hover-white' => 'weiss',
        'dk-background-black uk-section-default dk-text-hover-black' => 'schwarz'
    ];

  public function updateCMSFields(FieldList $fields) {
     
    $FooterLinksField = new GridField(
        'FooterBlocks',
        'FooterBlocks',
        $this->owner->Blocks(),
        GridFieldConfig_RecordEditor::create()->addComponents(new GridFieldOrderableRows('Sort'))
        ->addComponent(new GridFieldShowHideAction())
    );
    $fields->addFieldToTab("Root.Footer", DropdownField::create('FooterBackground',_t(__CLASS__.'.Background','Hintergrundfarbe'),$this->owner->getTranslatedSourceFor(__CLASS__,'backgrounds'))->setEmptyString(_t(__CLASS__.'.BackgroundHelp','Wählen Sie aus eine Hintergrundfarbe')));
    $fields->addFieldToTab("Root.Footer", $FooterLinksField);
  }

  public function activeFooterBlocks(){
    return $this->owner->Blocks()->filter('isVisible',1);
  }

/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->owner->stat('backgrounds') as $key => $value) {
          $entities[__CLASS__.".backgrounds_{$key}"] = $value;
        }
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}