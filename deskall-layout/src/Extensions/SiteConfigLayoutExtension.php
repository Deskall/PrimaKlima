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
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;

class SiteConfigLayoutExtension extends DataExtension 
{
  protected $user_defined_file = '/themes/standard/css/src/deskall/theme/user_defined.less';

  private static $db = [
   
    'HeaderBackground' => 'Varchar(7)',
    'GlobalFontSize' => 'Varchar(25)',
    'H1FontSize' => 'Varchar(25)',
    'H1MobileFontSize' => 'Varchar(25)',
    'H2FontSize' => 'Varchar(25)',
    'H3FontSize' => 'Varchar(25)',
    'LeadFontSize' => 'Varchar(25)',

    'HeaderBackground' => 'Varchar(255)',
    'HeaderFontColor' => 'Varchar(7)',
    'HeaderFontSize' => 'Varchar(255)',
    'HeaderMenuItemSize' => 'Varchar(255)',
    'HeaderHoverFontColor' => 'Varchar(7)',
    'HeaderHeight' => 'Varchar(255)',
    'HeaderCollapsedHeight' => 'Varchar(255)',
    'HeaderOpacity' => 'Varchar(255)',
    'HeaderFormat' => 'Varchar(255)',
    'StickyHeader' => 'Boolean(0)',

    'FooterBackground' => 'Varchar(255)',

  ];

  private static $constants_less = [
    'GrayBackground' => '@global-muted',
    'PrimaryBackground' => '@global-primary',
    'SecondaryBackground' => '@global-secondary',
    'WhiteBackground' => '@white',
    'BlackBackground' => '@black',
    'BodyBackground' => '@global',
    'ActiveColor' => '@global-emphasis',
    'GlobalFontSize' => '@global-font-size',
    'H1FontSize' => [
      '@h1-size',
      '@heading-primary-font-size'
    ],
    'H1MobileFontSize' => '@h1-mobile-size',
    'H2FontSize' => '@h2-size',
    'H3FontSize' => '@h3-size',
    'LeadFontSize' => '@text-lead-font-size',
    
    'HeaderFontColor' => '@navbar-nav-item-color',
    'HeaderHoverFontColor' => [
      '@navbar-nav-item-hover-color',
      '@navbar-nav-item-active-color',
      '@nav-active-border-color'],
    'HeaderHeight' => '@header-menu-height',
    'HeaderFontSize' => '@main-nav-font-size',
    'HeaderMenuItemSize' => '@navbar-nav-item-height',
    'HeaderCollapsedHeight' => '@header-menu-collapsed-height'
  ];

  private static $has_many = [
    'FooterBlocks' => FooterBlock::class,
    'MenuBlocks' => MenuBlock::class,
    'Colors' => Color::class
  ];

  private static $backgrounds = [
        'uk-section-default' => 'keine Hintergrundfarbe',
        'uk-section-primary' => 'primäre Farbe',
        'uk-section-secondary' => 'sekundäre Farbe',
        'uk-section-muted' => 'grau',
        'dk-background-white uk-section-default' => 'weiss',
        'dk-background-black uk-section-default' => 'schwarz'
  ];

  private static $default_colors = [
    'BodyBackground' => ['Code' => 'BodyBackground', 'FontTitle' => 'Body Hintergrundfarbe','Color' => 'e4e4e4','FontColor' => '575756','isReadonly' => 1, 'canChangeTitle' => 0],
    'PrimaryBackground' => ['Code' => 'PrimaryBackground', 'FontTitle' => 'Hauptfarbe','Color' => '10206B','FontColor' => 'ffffff','isReadonly' => 1, 'canChangeTitle' => 1],
    'SecondaryBackground' => ['Code' => 'SecondaryBackground', 'FontTitle' => 'Sekondäre Farbe','Color' => 'DC002E','FontColor' => 'ffffff','isReadonly' => 1, 'canChangeTitle' => 1],
    'WhiteBackground' => ['Code' => 'WhiteBackground', 'FontTitle' => 'Weiss','Color' => 'ffffff','FontColor' => '666666','isReadonly' => 1, 'canChangeTitle' => 1],
    'BlackBackground' => ['Code' => 'BlackBackground', 'FontTitle' => 'Schwarzfarbe','Color' => '000000','FontColor' => 'ffffff','isReadonly' => 1, 'canChangeTitle' => 1],
    'GrayBackground' => ['Code' => 'GrayBackground', 'FontTitle' => 'Graufarbe','Color' => 'cccccc','FontColor' => '575756','isReadonly' => 1, 'canChangeTitle' => 1],
    'ActiveColor' => ['Code' => 'ActiveColor', 'FontTitle' => 'Aktiv farbe','Color' => '10206B','FontColor' => 'FFFFFF','isReadonly' => 1, 'canChangeTitle' => 1]
  ];

  public function populateDefaults(){
    if ($this->owner->ID > 0){
      foreach($this->owner->stat('default_colors') as $code => $array){
        if ($this->owner->Colors()->filter('Code',$code)->count() == 0){
          $c = new Color($array);
          $this->owner->Colors()->add($c);
        }
      }
    }
  }

  public function updateCMSFields(FieldList $fields) {
    Requirements::javascript('deskall-layout/javascript/jscolor.min.js');
    Requirements::javascript('deskall-layout/javascript/layout.js');
    Requirements::css('deskall-layout/css/layout.css');

    //GLOBAL
    //COLORS
    $fields->addFieldToTab("Root.Layout.Global",new HiddenField('ID'));
    $config = GridFieldConfig::create()
                ->addComponent(new GridFieldButtonRow('before'))
                ->addComponent(new GridFieldTitleHeader())
                ->addComponent(new GridFieldEditableColumns())
                ->addComponent(new GridFieldDeleteAction())
                ->addComponent(new GridFieldAddNewInlineButton())
                ->addComponent(new GridFieldOrderableRows('Sort'))
               ;
    $config->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields([
        'FontTitle'  => [
            'title' => 'Titel und Vorschau',
            'callback' => function($record, $column, $grid) {
              $field = TextField::create($column);

              if ($record->canChangeTitle == 0){
                 $field->setReadonly(true);
              }
              return $field;
            }
        ],
        'Color'  => [
            'title' => 'Farbe',
            'callback' => function($record, $column, $grid) {
              return TextField::create($column)->addExtraClass('jscolor');
            }
        ],
       'FontColor'  => [
            'title' => 'Schriftfarbe',
            'callback' => function($record, $column, $grid) {
              return TextField::create($column)->addExtraClass('jscolor');
            }
        ],
    ]);
                
    $colorsField = new GridField('Colors',_t(__CLASS__.'.Colors','Farben'),$this->owner->Colors(),$config);
    $fields->addFieldsToTab("Root.Layout.Global",[
      HeaderField::create('ColorTitle',_t(__CLASS__.'.ColorsTitle','Farben'),2),
      $colorsField]);




    $fields->addFieldsToTab("Root.Layout.Global", 
      [
        HeaderField::create('FontsTitle',_t(__CLASS__.'.FontsTitle','Schriften'),2),
        TextField::create('GlobalFontSize',_t(__CLASS__.'.GlobalFontSize','Standard Schriftgrösse')),
        TextField::create('H1FontSize',_t(__CLASS__.'.H1FontSize','H1 Schriftgrösse')),
        TextField::create('H1MobileFontSize',_t(__CLASS__.'.H1MobileFontSize','H1 Mobile Schriftgrösse')),
        TextField::create('H2FontSize',_t(__CLASS__.'.H2FontSize','H2 Schriftgrösse')),
        TextField::create('H3FontSize',_t(__CLASS__.'.H3FontSize','H3 Schriftgrösse')),
        TextField::create('LeadFontSize',_t(__CLASS__.'.LeadFontSize','LeadText Schriftgrösse'))
      ]
    );


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
        TextField::create('HeaderOpacity',_t(__CLASS__.'.HeaderOpacity','Opazität')),
        TextField::create('HeaderFontColor',_t(__CLASS__.'.HeaderFontColor','Schriftfarbe'))->addExtraClass('jscolor'),
        TextField::create('HeaderHoverFontColor',_t(__CLASS__.'.HeaderHoverFontColor','Aktive und Hover Schriftfarbe'))->addExtraClass('jscolor')
      ),
      FieldGroup::create(
        TextField::create('HeaderHeight',_t(__CLASS__.'.HeaderHeight','Höhe')),
        TextField::create('HeaderCollapsedHeight',_t(__CLASS__.'.HeaderCollapsedHeight','Mobile Höhe')),
        TextField::create('HeaderMenuItemSize',_t(__CLASS__.'.HeaderItemHeight','Menu Item Höhe')),
        TextField::create('HeaderFontSize',_t(__CLASS__.'.HeaderFontSize','Navigation Schriftgrösse'))
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
    $this->owner->populateDefaults();
    $this->owner->HeaderBackground = "#".$this->owner->HeaderBackground;
    $this->owner->HeaderFontColor = "#".$this->owner->HeaderFontColor;
    $this->owner->HeaderHoverFontColor = "#".$this->owner->HeaderHoverFontColor;

  }


  public function onAfterWrite(){
    
    $this->owner->WriteUserDefinedConstants();
    parent::onAfterWrite();
  }

  public function WriteUserDefinedConstants(){
    $fullpath = $_SERVER['DOCUMENT_ROOT'].$this->user_defined_file;
    file_put_contents($fullpath, '// CREATED FROM SILVERSTRIPE LAYOUT CONFIG --- DO NOT DELETE OR MODIFY');
    foreach($this->owner->Colors() as $c){
      if (isset($this->owner->stat('constants_less')[$c->Code])){
        $code = $this->owner->stat('constants_less')[$c->Code];
        file_put_contents($fullpath, "\n".$code.'-background:#'.$c->Color.';',FILE_APPEND);
        file_put_contents($fullpath, "\n".$code.'-color:#'.$c->FontColor.';',FILE_APPEND);
      }
    }
    foreach ($this->owner->stat('constants_less') as $key => $value){
      if ($this->owner->{$key}){
        if (is_array($value)){
          foreach ($value as $item) {
            file_put_contents($fullpath, "\n".$item.':'.$this->owner->{$key}.';',FILE_APPEND);
          }
        }
        else{
          file_put_contents($fullpath, "\n".$value.':'.$this->owner->{$key}.';',FILE_APPEND);
        }
        
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