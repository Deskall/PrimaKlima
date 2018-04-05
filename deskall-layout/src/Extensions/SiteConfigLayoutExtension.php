<?php 

use SilverStripe\Forms\FieldList;
use SilverStripe\Control\Director;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\Tabset;
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
  protected $user_defined_file = '/themes/standard/css/src/deskall/theme/user_defined.less';

  private static $db = [
    'PrimaryBackground' => 'Varchar(7)',
    'SecondaryBackground' => 'Varchar(7)',
    'MutedBackground' => 'Varchar(7)',
    'BodyBackground' => 'Varchar(7)',
    'WhiteBackground' => 'Varchar(7)',
    'BlackBackground' => 'Varchar(7)',
    'GrayBackground' => 'Varchar(7)',
    'HeaderBackground' => 'Varchar(7)',
    'GlobalFontSize' => 'Varchar(25)',
    'H1FontSize' => 'Varchar(25)',
    'H1MobileFontSize' => 'Varchar(25)',
    'H2FontSize' => 'Varchar(25)',
    'H3FontSize' => 'Varchar(25)',
    'LeadFontSize' => 'Varchar(25)',
    'GlobalFontColor' => 'Varchar(7)',

    'HeaderBackground' => 'Varchar(255)',
    'HeaderHeight' => 'Varchar(255)',
    'HeaderCollapsedHeight' => 'Varchar(255)',
    'HeaderOpacity' => 'Varchar(255)',
    'HeaderFormat' => 'Varchar(255)',
    'StickyHeader' => 'Boolean(0)',

    'FooterBackground' => 'Varchar(255)',

  ];

  private static $constants_less = [
    'MutedBackground' => '@global-muted-background',
    'PrimaryBackground' => '@global-primary-background',
    'SecondaryBackground' => '@global-secondary-background',
    'WhiteBackground' => '@white',
    'BlackBackground' => '@black',
    'BodyBackground' => '@global-background',
    'GlobalFontSize' => '@global-font-size',
    'H1FontSize' => '@h1-size',
    'H1MobileFontSize' => '@h1-mobile-size',
    'H2FontSize' => '@h2-size',
    'H3FontSize' => '@h3-size',
    'LeadFontSize' => '@text-lead-font-size',
    'GlobalFontColor' => '@global-color',
    'HeaderHeight' => '@header-menu-height',
    'HeaderCollapsedHeight' => '@header-menu-collapsed-height'
  ];

  private static $has_many = [
    'FooterBlocks' => FooterBlock::class,
    'MenuBlocks' => MenuBlock::class
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
    Requirements::javascript('deskall-layout/javascript/jscolor.min.js');
    Requirements::javascript('deskall-layout/javascript/layout.js');
    Requirements::css('deskall-layout/css/layout.css');

    //GLOBAL
    $fields->addFieldToTab("Root.Layout.Global",new HiddenField('ID'));

    $fields->addFieldToTab("Root.Layout.Global",CompositeField::create(
      TextField::create('BodyBackground',_t(__CLASS__.'.BodyBackground','Body Hintergrundfarbe'))->addExtraClass('jscolor'),
      TextField::create('PrimaryBackground',_t(__CLASS__.'.PrimaryBackground','Primäre Farbe'))->addExtraClass('jscolor'),
      TextField::create('SecondaryBackground',_t(__CLASS__.'.SecondaryBackground','Sekondäre Farbe'))->addExtraClass('jscolor'),
      TextField::create('MutedBackground',_t(__CLASS__.'.MutedBackground','gedämpfte Farbe'))->addExtraClass('jscolor'),
      TextField::create('WhiteBackground',_t(__CLASS__.'.WhiteBackground','Weiss Farbe'))->addExtraClass('jscolor'),
      TextField::create('BlackBackground',_t(__CLASS__.'.BlackBackground','Schwarz Farbe'))->addExtraClass('jscolor'),
      TextField::create('GrayBackground',_t(__CLASS__.'.GrayBackground','Grau Farbe'))->addExtraClass('jscolor')
    )->setName('ColorFields')->setTitle(_t(__CLASS__.'.Colors','Farben')));


    $fields->addFieldToTab("Root.Layout.Global",CompositeField::create(
      TextField::create('GlobalFontSize',_t(__CLASS__.'.GlobalFontSize','Standard Schriftgrösse')),
      TextField::create('H1FontSize',_t(__CLASS__.'.H1FontSize','H1 Schriftgrösse')),
      TextField::create('H1MobileFontSize',_t(__CLASS__.'.H1MobileFontSize','H1 Mobile Schriftgrösse')),
      TextField::create('H2FontSize',_t(__CLASS__.'.H2FontSize','H2 Schriftgrösse')),
      TextField::create('H3FontSize',_t(__CLASS__.'.H3FontSize','H3 Schriftgrösse')),
      TextField::create('LeadFontSize',_t(__CLASS__.'.LeadFontSize','LeadText Schriftgrösse')),
      TextField::create('GlobalFontColor',_t(__CLASS__.'.GlobalFontColor','Schriftfarbe'))->addExtraClass('jscolor')
    )->setName('FontFields')->setTitle(_t(__CLASS__.'.Fonts','Schriften')));


    //Header
    $MenusField = new GridField(
        'MenuBlocks',
        'MenuBlocks',
        $this->owner->MenuBlocks(),
        GridFieldConfig_RecordEditor::create()->addComponents(new GridFieldOrderableRows('Sort'))
        ->addComponent(new GridFieldShowHideAction())
    );
    $fields->addFieldToTab("Root.Layout.Header.Content", $MenusField);

    $fields->addFieldToTab("Root.Layout.Header.Layout", CompositeField::create(
      FieldGroup::create(
        TextField::create('HeaderBackground',_t(__CLASS__.'.HeaderBackground','Hintergrundfarbe'))->addExtraClass('jscolor'),
        TextField::create('HeaderOpacity',_t(__CLASS__.'.HeaderOpacity','Opazität'))),
      FieldGroup::create(
        TextField::create('HeaderHeight',_t(__CLASS__.'.HeaderHeight','Höhe')),
        TextField::create('HeaderCollapsedHeight',_t(__CLASS__.'.HeaderCollapsedHeight','Mobile Höhe'))
      ),
      CheckboxField::create('StickyHeader','Sticky Header')
    )->setTitle(_t(__CLASS__.'.HeaderLayout','Header Layout'))->setName('HeaderBackgroundFields'));

    




    //FOOTER
    $FooterLinksField = new GridField(
        'FooterBlocks',
        'FooterBlocks',
        $this->owner->FooterBlocks(),
        GridFieldConfig_RecordEditor::create()->addComponents(new GridFieldOrderableRows('Sort'))
        ->addComponent(new GridFieldShowHideAction())
    );
    $fields->addFieldToTab("Root.Layout.Footer", DropdownField::create('FooterBackground',_t(__CLASS__.'.Background','Hintergrundfarbe'),$this->owner->getTranslatedSourceFor(__CLASS__,'backgrounds'))->setEmptyString(_t(__CLASS__.'.BackgroundHelp','Wählen Sie aus eine Hintergrundfarbe')));
    $fields->addFieldToTab("Root.Layout.Footer", $FooterLinksField);
    
    return $fields;
  }


  public function activeFooterBlocks(){
    return $this->owner->FooterBlocks()->filter('isVisible',1);
  }

  public function activeMenuBlocks(){
    return $this->owner->MenuBlocks()->filter('isVisible',1);
  }

  public function onBeforeWrite(){
    parent::onBeforeWrite();
    $this->owner->PrimaryBackground = "#".$this->owner->PrimaryBackground;
    $this->owner->SecondaryBackground = "#".$this->owner->SecondaryBackground;
    $this->owner->MutedBackground = "#".$this->owner->MutedBackground;
    $this->owner->WhiteBackground = "#".$this->owner->WhiteBackground;
    $this->owner->BlackBackground = "#".$this->owner->BlackBackground;
    $this->owner->BodyBackground = "#".$this->owner->BodyBackground;
    $this->owner->GlobalFontColor = "#".$this->owner->GlobalFontColor;
    $this->owner->HeaderBackground = "#".$this->owner->HeaderBackground;

  }


  public function onAfterWrite(){
    $this->owner->WriteUserDefinedConstants();
    parent::onAfterWrite();
  }

  public function WriteUserDefinedConstants(){
    $fullpath = $_SERVER['DOCUMENT_ROOT'].$this->user_defined_file;
    file_put_contents($fullpath, '// CREATED FROM SILVERSTRIPE LAYOUT CONFIG --- DO NOT DELETE OR MODIFY');
    foreach ($this->owner->stat('constants_less') as $key => $value){
      if ($this->owner->{$key}){
        file_put_contents($fullpath, "\n".$value.':'.$this->owner->{$key}.';',FILE_APPEND);
      }
    }
    if ($this->owner->HeaderBackground){
      if ($this->owner->HeaderOpacity){
        file_put_contents($fullpath, "\n".'@dk-background-header: fade('.$this->owner->HeaderBackground.','.$this->owner->HeaderOpacity.');',FILE_APPEND);
      }
    }
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