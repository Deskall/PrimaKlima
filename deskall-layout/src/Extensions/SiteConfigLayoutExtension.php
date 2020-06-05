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
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Assets\Image;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use SilverStripe\View\ThemeResourceLoader;
use SilverStripe\View\SSViewer;

class SiteConfigLayoutExtension extends DataExtension 
{
  protected $user_defined_file = '/themes/standard/css/src/deskall/theme/user_defined.less';
  protected $background_colors = '/themes/standard/css/src/deskall/theme/colors.less';
  protected $path_to_themes = '/deskall-layout/config/theme.yml';

  private static $db = [
    'Theme' => 'Varchar',
    'HeaderBackground' => 'Varchar(7)',
    'GlobalFontSize' => 'Varchar(25)',
    'H1FontSize' => 'Varchar(25)',
    'H1FontColor' => 'Varchar(7)',
    'H1MobileFontSize' => 'Varchar(25)',
    'H2FontSize' => 'Varchar(25)',
    'H3FontSize' => 'Varchar(25)',
    'LeadFontSize' => 'Varchar(25)',

   // 'HeaderLayout' => 'Varchar(255)',
    'HeaderBackground' => 'Varchar(255)',
    'HeaderFontColor' => 'Varchar(7)',
    'HeaderFontSize' => 'Varchar(255)',
    'HeaderFontMobileSize' => 'Varchar(255)',
    'HeaderMainMenuItemSize' => 'Varchar(255)',
    'HeaderSubMenuItemSize' => 'Varchar(255)',
    'HeaderHoverFontColor' => 'Varchar(7)',
    'HeaderHeight' => 'Varchar(255)',
    'HeaderCollapsedHeight' => 'Varchar(255)',
    'HeaderOpacity' => 'Varchar(255)',
    'HeaderFormat' => 'Varchar(255)',
    'ExtraHeaderClass' => 'Varchar(255)',
    'StickyHeader' => 'Boolean(0)',
    'BackContent' => 'Boolean(0)',
    'HeaderLogoHeight' => 'Varchar(255)',
    'HeaderMobileLogoHeight' => 'Varchar(255)',
    'DropdownSubMenuWidth' => 'Varchar(255)',
    'DropdownSubMenuBackground' => 'Varchar(255)',
    'DropdownSubMenuColor' => 'Varchar(255)',
    'DropdownSubMenuHoverBackground' => 'Varchar(255)',
    'DropdownSubMenuHoverColor' => 'Varchar(255)',
    'DropdownSubMenuPadding' => 'Varchar(255)',



    'FooterBackground' => 'Varchar(255)',
    'FooterLogoWidth' => 'Varchar(255)',
    'FooterFontSize' => 'Varchar(255)',
    'FooterTitleFontSize' => 'Varchar(255)',
    'FooterFontColor' => 'Varchar(7)',
    'FooterTitleFontColor' => 'Varchar(7)',
    'FooterLinkFontColor' => 'Varchar(7)',
    'FooterLinkHoverFontColor' => 'Varchar(7)',
    'ExtraFooterClass' => 'Varchar(255)',

    'MobileNaviBackground' => 'Varchar(255)',
    'MobileNaviFontColor' => 'Varchar(7)',
    'MobileNaviHoverFontColor' => 'Varchar(7)',
    'ToggleMenuButtonColor' => 'Varchar(7)',

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
    'H1FontColor' => '@h1-font-color',
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
    'HeaderFontSize' => '@dk-main-nav-font-size',
    'HeaderMobileFontSize' => '@dk-main-nav-font-size-mobile',
    'HeaderMainMenuItemSize' => '@navbar-main-nav-item-height',
    'HeaderSubMenuItemSize' => '@navbar-sub-nav-item-height',
    'HeaderCollapsedHeight' => '@header-menu-collapsed-height',
    'HeaderLogoHeight' => '@header-logo-height',
    'HeaderMobileLogoHeight' => '@header-mobile-logo-height',
    'DropdownSubMenuWidth' => '@dk-navbar-dropdown-width',
    'DropdownSubMenuBackground' => '@main-subnavi-background',
    'DropdownSubMenuColor' => '@main-subnavi-color',
    'DropdownSubMenuHoverBackground' => '@main-subnavi-hover-background',
    'DropdownSubMenuHoverColor' => '@main-subnavi-hover-color',
    'DropdownSubMenuPadding' => '@main-subnavi-padding',
   
    'FooterLogoWidth' => '@footer-logo-width',
    'FooterBackground' => '@footer-background-color',
    'FooterFontColor' => '@footer-font-color',
    'FooterTitleFontColor' => '@footer-title-font-color',
    'FooterLinkFontColor' => '@footer-link-font-color',
    'FooterLinkHoverFontColor' => '@footer-link-hover-font-color',
    'FooterFontSize' => '@footer-font-size',
    'FooterTitleFontSize' => '@footer-title-font-size',

    'MobileNaviBackground' => '@mobile-navigation-background-color',
    'MobileNaviFontColor' => '@mobile-navigation-color',
    'MobileNaviHoverFontColor' => '@mobile-navigation-active-color',
    'ToggleMenuButtonColor' =>'@toggle-mobile-menu-button-color'


  ];

  private static $has_many = [
    'FooterBlocks' => FooterBlock::class,
    'MenuBlocks' => MenuBlock::class,
    'MobileMenuBlocks' => MobileMenuBlock::class,
    'Colors' => Color::class,
    'Slides' => HeaderSlide::class
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

  // private static $header_layouts = [
  //   'top' => [
  //           'value' => 'top',
  //           'title' => 'Oben',
  //           'icon' => '/deskall-page-blocks/images/icon-menu-top.svg'
  //   ],
  //   'left' => [
  //           'value' => 'left',
  //           'title' => 'Links',
  //           'icon' => '/deskall-page-blocks/images/icon-menu-left.svg'
  //   ]
  // ];

  public function populateDefaultsColors(){
    if ($this->owner->ID > 0){
      foreach($this->owner->stat('default_colors') as $code => $array){
        if ($this->owner->Colors()->filter('Code',$code)->count() == 0){
          $c = new Color($array);
          $this->owner->Colors()->add($c);
        }
      }
    }
  }

  public function getCurrentThemeDir(){
    return '/themes/'.$this->owner->Theme;
  }

  public function getAbsoluteCurrentThemeDir(){
    return Director::AbsoluteURL($this->owner->getCurrentThemeDir());
  }

  public function getUserDefinedFile(){

    return $this->owner->getCurrentThemeDir().'/css/src/deskall/theme/user_defined.less';
  }

  public function getBackgroundColorsFile(){
    return $this->owner->getCurrentThemeDir().'/css/src/deskall/theme/colors.less';
  }

  public function getLayoutFields() {
    Requirements::javascript('deskall-layout/javascript/jscolor.min.js');
    Requirements::javascript('deskall-layout/javascript/layout.js');
    Requirements::css('deskall-layout/css/layout.css');
    $fields = new FieldList(new Tabset('Root',_t('FORMS.MAINTAB','Haupt')));
    $themesPath = Director::baseFolder().'/themes';
    $dirs = glob($themesPath . '/*' , GLOB_ONLYDIR);
    $themes = [];
    foreach ($dirs as $key => $dir) {
      $themes[basename($dir)] = basename($dir);
    }
    //GLOBAL
    $fields->addFieldToTab("Root.Global",DropdownField::create('Theme','Theme',$themes)->setValue('standard')->setEmptyString('Bitte wählen'));
    
    //COLORS
    $fields->addFieldToTab("Root.Global",new HiddenField('ID'));
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
            'title' => _t(__CLASS__.'.FontTitle','Titel und Vorschau'),
            'callback' => function($record, $column, $grid) {
              $field = TextField::create($column);
              return $field;
            }
        ],
        'Color'  => [
            'title' => _t(__CLASS__.'.ColorLabel','Farbe'),
            'callback' => function($record, $column, $grid) {
              return TextField::create($column)->addExtraClass('jscolor');
            }
        ],
       'FontColor'  => [
            'title' => _t(__CLASS__.'.FontColorLabel','Schriftfarbe'),
            'callback' => function($record, $column, $grid) {
              return TextField::create($column)->addExtraClass('jscolor');
            }
        ],
        'LinkColor'  => [
            'title' => _t(__CLASS__.'.LinkColorLabel','Link Farbe'),
            'callback' => function($record, $column, $grid) {
              return TextField::create($column)->addExtraClass('jscolor');
            }
        ],
        'LinkHoverColor'  => [
            'title' => _t(__CLASS__.'.LinkHoverColor','Link hover Farbe'),
            'callback' => function($record, $column, $grid) {
              return TextField::create($column)->addExtraClass('jscolor');
            }
        ],
    ]);
                
    $colorsField = new GridField('Colors',_t(__CLASS__.'.Colors','Farben'),$this->owner->Colors(),$config);
    $slideconfig = GridFieldConfig_RecordEditor::create();
    $slideconfig->addComponent(new GridFieldOrderableRows('Sort'));
    if (singleton('Slide')->hasExtension('Activable')){
         $slideconfig->addComponent(new GridFieldShowHideAction());
    }
    $slideconfig->addComponent(new GridFieldDuplicateAction());
    $fields->addFieldsToTab("Root.Global",[
      new GridField('Slides',_t(__CLASS__.'.Slides','Slides'),$this->owner->Slides(),$slideconfig),
      HeaderField::create('ColorTitle',_t(__CLASS__.'.ColorsTitle','Farben'),2),
      $colorsField]);



   
    $fields->addFieldsToTab("Root.Global", 
      [
        HeaderField::create('FontsTitle',_t(__CLASS__.'.FontsTitle','Schriften'),2),
        TextField::create('GlobalFontSize',_t(__CLASS__.'.GlobalFontSize','Standard Schriftgrösse')),
        TextField::create('H1FontSize',_t(__CLASS__.'.H1FontSize','H1 Schriftgrösse')),
         TextField::create('H1FontColor',_t(__CLASS__.'.H1FontColor','H* Titel Farbe'))->addExtraClass('jscolor'),
        TextField::create('H1MobileFontSize',_t(__CLASS__.'.H1MobileFontSize','H1 Mobile Schriftgrösse')),
        TextField::create('H2FontSize',_t(__CLASS__.'.H2FontSize','H2 Schriftgrösse')),
        TextField::create('H3FontSize',_t(__CLASS__.'.H3FontSize','H3 Schriftgrösse')),
        TextField::create('LeadFontSize',_t(__CLASS__.'.LeadFontSize','LeadText Schriftgrösse'))
      ]
    );
    $fields->FieldByName('Root.Global')->setTitle(_t(__CLASS__.'.GlobalTabTitle','Global'));



    //Header
    $MenusField = new GridField(
        'MenuBlocks',
        _t(__CLASS__.'.MenuBlocksLabel','Menu Blöcke'),
        $this->owner->MenuBlocks()->filter('ClassName','MenuBlock'),
        GridFieldConfig_RecordEditor::create()->addComponents(new GridFieldOrderableRows('Sort'))
        ->addComponent(new GridFieldShowHideAction())
    );  
    //TO DO : rebuild it with multi class option
    // $MenusField->getConfig()->removeComponentsByType(GridFieldAddNewButton::class)
    //     ->addComponent(new DeskallGridFieldAddNewMultiClass());
    // $MenusField->getConfig()->getComponentByType(DeskallGridFieldAddNewMultiClass::class)->setClasses(['MenuBlock' => 'Menu']);
    $fields->addFieldToTab("Root.Header.Content", $MenusField);

    $fields->addFieldToTab("Root.Header.Layout", CompositeField::create(
      //HTMLOptionsetField::create('HeaderLayout',_t(__CLASS__.'.HeaderLayout','Navigation Format'),$this->owner->stat('header_layouts')),
      //DropdownField::create('HeaderLayout','Navigation Format',['top' => 'Oben', 'left' => 'Links']),
      FieldGroup::create(
        TextField::create('HeaderBackground',_t(__CLASS__.'.HeaderBackground','Hintergrundfarbe'))->addExtraClass('jscolor'),
        TextField::create('HeaderOpacity',_t(__CLASS__.'.HeaderOpacity','Opazität')),
        TextField::create('HeaderFontColor',_t(__CLASS__.'.HeaderFontColor','Schriftfarbe'))->addExtraClass('jscolor'),
        TextField::create('HeaderHoverFontColor',_t(__CLASS__.'.HeaderHoverFontColor','Aktive und Hover Schriftfarbe'))->addExtraClass('jscolor')
      ),
      FieldGroup::create(
        TextField::create('HeaderHeight',_t(__CLASS__.'.HeaderHeight','Höhe')),
        TextField::create('HeaderCollapsedHeight',_t(__CLASS__.'.HeaderCollapsedHeight','Mobile Header Höhe')),
        TextField::create('HeaderMainMenuItemSize',_t(__CLASS__.'.HeaderMainMenuItemHeight','Haupt Menu Item Höhe')),
        TextField::create('HeaderSubMenuItemSize',_t(__CLASS__.'.HeaderSubMenuItemHeight','Sekondäre Menu Item Höhe')),
        TextField::create('HeaderFontSize',_t(__CLASS__.'.HeaderFontSize','Navigation Schriftgrösse')),
        TextField::create('HeaderLogoHeight',_t(__CLASS__.'.HeaderLogHeight','Header Logo Höhe')),
        TextField::create('HeaderMobileLogoHeight',_t(__CLASS__.'.HeaderMobileLogHeight','Mobile Header Logo Höhe'))
      ),
      TextField::create('ExtraHeaderClass',_t(__CLASS__.'.ExtraHeaderClass','Custom CSS für header')),
      FieldGroup::create(
        TextField::create('DropdownSubMenuWidth',_t(__CLASS__.'.DropdownSubMenuWidth','Breite der Dropdown-Navigation')),
        TextField::create('DropdownSubMenuPadding',_t(__CLASS__.'.DropdownSubMenuPadding','Padding der Dropdown-Navigation')),
        TextField::create('DropdownSubMenuBackground',_t(__CLASS__.'.DropdownBackground','Unten Navigation Hintergrundfarbe'))->addExtraClass('jscolor'),
        TextField::create('DropdownSubMenuColor',_t(__CLASS__.'.DropdownColor','Unten Navigation Schriftfarbe'))->addExtraClass('jscolor'),
        TextField::create('DropdownSubMenuHoverBackground',_t(__CLASS__.'.DropdownBackground','Unten Navigation Hintergrundfarbe (hover)'))->addExtraClass('jscolor'),
        TextField::create('DropdownSubMenuHoverColor',_t(__CLASS__.'.DropdownColor','Unten Navigation Schriftfarbe (hover)'))->addExtraClass('jscolor')
      ),
      CheckboxField::create('BackContent',_t(__CLASS__.'.BackContent','Header über Inhalt')),
      CheckboxField::create('StickyHeader',_t(__CLASS__.'.StickyHeader','Sticky Header'))
    )->setTitle(_t(__CLASS__.'.HeaderLayout','Header Layout'))->setName('HeaderBackgroundFields'));

    $fields->FieldByName('Root.Header.Content')->setTitle(_t(__CLASS__.'.LayoutHeaderContentTab','Inhalt der Header'));
    $fields->FieldByName('Root.Header.Layout')->setTitle(_t(__CLASS__.'.LayoutHeaderLayoutTab','Layout der Header'));

    
    //MOBILE NAVI
    $MobileMenusField = new GridField(
        'MobileMenuBlocks',
        _t(__CLASS__.'.MenuBlocksLabel','Menu Blöcke'),
        $this->owner->MobileMenuBlocks(),
        GridFieldConfig_RecordEditor::create()->addComponents(new GridFieldOrderableRows('Sort'))
        ->addComponent(new GridFieldShowHideAction())
    );
    $fields->addFieldToTab("Root.MobileNavigation.Content", $MobileMenusField);

    $fields->addFieldToTab("Root.MobileNavigation.Layout", CompositeField::create(
      FieldGroup::create(
        TextField::create('MobileNaviBackground',_t(__CLASS__.'.BackgroundColor','Hintergrundfarbe'))->addExtraClass('jscolor'),
        TextField::create('MobileNaviFontColor',_t(__CLASS__.'.MobileNaviColor','Schriftfarbe'))->addExtraClass('jscolor'),
        TextField::create('MobileNaviHoverFontColor',_t(__CLASS__.'.HeaderHoverFontColor','Aktive und Hover Schriftfarbe'))->addExtraClass('jscolor'),
        TextField::create('ToggleMenuButtonColor',_t(__CLASS__.'.ToggleMenuButtonColor','Mobile-Navi Umschaltknopf Schriftfarbe'))->addExtraClass('jscolor')
      )
    )->setTitle(_t(__CLASS__.'.MobileNaviLayout','MobileNavigation Layout'))->setName('MobileNaviFields'));

    $fields->FieldByName('Root.MobileNavigation.Content')->setTitle(_t(__CLASS__.'.LayoutMobileContentTab','Inhalt der mobile Navigation'));
    $fields->FieldByName('Root.MobileNavigation.Layout')->setTitle(_t(__CLASS__.'.LayoutMobileLayoutTab','Layout der mobile Navigation'));



    //FOOTER
    $FooterLinksField = new GridField(
        'FooterBlocks',
       _t(__CLASS__.'.FooterBlocksLabel','Footer Blöcke'),
        $this->owner->FooterBlocks(),
        GridFieldConfig_RecordEditor::create()->addComponents(new GridFieldOrderableRows('Sort'))
        ->addComponent(new GridFieldShowHideAction())
    );
    $fields->addFieldToTab("Root.Footer.Content", $FooterLinksField);

    $fields->addFieldToTab("Root.Footer.Layout", CompositeField::create(
      FieldGroup::create(
        TextField::create('FooterBackground',_t(__CLASS__.'.FooterBackground','Hintergrundfarbe'))->addExtraClass('jscolor'),
        TextField::create('FooterFontColor',_t(__CLASS__.'.FooterFontColor','Schriftfarbe'))->addExtraClass('jscolor'),
        TextField::create('FooterTitleFontColor',_t(__CLASS__.'.FooterTitleFontColor','Titel Schriftfarbe'))->addExtraClass('jscolor'),
        TextField::create('FooterLinkFontColor',_t(__CLASS__.'.FooterLinkFontColor','Link Schriftfarbe'))->addExtraClass('jscolor'),
        TextField::create('FooterLinkHoverFontColor',_t(__CLASS__.'.FooterLinkHoverFontColor',' Link Hover Schriftfarbe'))->addExtraClass('jscolor')
      ),
      FieldGroup::create(
        TextField::create('FooterLogoWidth',_t(__CLASS__.'.Footerlogowidtht','Logo Breite')),
        TextField::create('FooterTitleFontSize',_t(__CLASS__.'.FooterTitleFontSize','Footer Titel Schriftgrösse')),
        TextField::create('FooterFontSize',_t(__CLASS__.'.FooterFontSize','Footer Schriftgrösse'))
      ),
      TextField::create('ExtraFooterClass',_t(__CLASS__.'.ExtraFooterClass','Custom CSS für footer'))
     
    )->setTitle(_t(__CLASS__.'.FooterLayout','Footer Layout'))->setName('FooterLayoutFields'));
    $fields->FieldByName('Root.Footer.Content')->setTitle(_t(__CLASS__.'.FooterContentTab','Inhalt der Footer'));
    $fields->FieldByName('Root.Footer.Layout')->setTitle(_t(__CLASS__.'.FooterLayoutTab','Layout der Footer'));

  

    $fields->FieldByName('Root.Global')->setTitle(_t(__CLASS__.'.LayoutGlobalTab','Allgemein'));
    $fields->FieldByName('Root.Header')->setTitle(_t(__CLASS__.'.LayoutHeaderTab','Header'));
    $fields->FieldByName('Root.MobileNavigation')->setTitle(_t(__CLASS__.'.MobilNavigationTab','mobile Navigation'));
    $fields->FieldByName('Root.Footer')->setTitle(_t(__CLASS__.'.FooterTab','Footer'));

    $this->owner->extend('updateLayoutFields', $fields);
    
    return $fields;
  }


  public function activeFooterBlocks(){
    return $this->owner->FooterBlocks()->filter('isVisible',1);
  }

  public function activeMenuBlocks(){
    return $this->owner->MenuBlocks()->filter(['isVisible' => 1, 'isMobile' => 0]);
  }

  public function activeMobileMenuBlocks(){
    return $this->owner->MobileMenuBlocks()->filter(['isVisible' => 1, 'isMobile' => 1]);
  }

  public function onBeforeWrite(){
    
    $this->owner->populateDefaultsColors();
    $this->owner->HeaderBackground = "#".ltrim($this->owner->HeaderBackground,"#");
    $this->owner->HeaderFontColor = "#".ltrim($this->owner->HeaderFontColor,"#");
    $this->owner->HeaderHoverFontColor = "#".ltrim($this->owner->HeaderHoverFontColor,"#");
    $this->owner->FooterFontColor = "#".ltrim($this->owner->FooterFontColor,"#");
    $this->owner->FooterTitleFontColor = "#".ltrim($this->owner->FooterTitleFontColor,"#");
    $this->owner->FooterLinkFontColor = "#".ltrim($this->owner->FooterLinkFontColor,"#");
    $this->owner->FooterLinkHoverFontColor = "#".ltrim($this->owner->FooterLinkHoverFontColor,"#");
    $this->owner->FooterBackground = "#".ltrim($this->owner->FooterBackground,"#");
    $this->owner->H1FontColor = "#".ltrim($this->owner->H1FontColor,"#");
    $this->owner->MobileNaviBackground = "#".ltrim($this->owner->MobileNaviBackground,"#");
    $this->owner->MobileNaviFontColor = "#".ltrim($this->owner->MobileNaviFontColor,"#");
    $this->owner->MobileNaviHoverFontColor = "#".ltrim($this->owner->MobileNaviHoverFontColor,"#");
    $this->owner->ToggleMenuButtonColor = "#".ltrim($this->owner->ToggleMenuButtonColor,"#");
    $this->owner->DropdownSubMenuHoverBackground = "#".ltrim($this->owner->DropdownSubMenuHoverBackground,"#");
    $this->owner->DropdownSubMenuBackground = "#".ltrim($this->owner->DropdownSubMenuBackground,"#");
    $this->owner->DropdownSubMenuHoverColor = "#".ltrim($this->owner->DropdownSubMenuHoverColor,"#");
    $this->owner->DropdownSubMenuColor = "#".ltrim($this->owner->DropdownSubMenuColor,"#");


    parent::onBeforeWrite();
  }


  public function onAfterWrite(){
    if ($this->owner->isChanged()){
      $this->owner->WriteUserDefinedConstants();
      $this->owner->WriteBackgroundClasses();
      $this->owner->RegenerateCss();
    }
    parent::onAfterWrite();
  }

  public function WriteUserDefinedConstants(){
    $fullpath = Director::baseFolder().$this->owner->getUserDefinedFile();
    if ($this->owner->hasExtension('SilverStripe\Subsites\Extensions\SiteConfigSubsites')){
      if ($this->owner->SubsiteID > 0){
         $fullpath = Director::baseFolder().'/themes/'.$this->owner->Subsite()->Theme.'/css/src/deskall/theme/user_defined.less';
      }
    }
    file_put_contents($fullpath, '// CREATED FROM SILVERSTRIPE LAYOUT CONFIG --- DO NOT DELETE OR MODIFY');
    foreach($this->owner->Colors() as $c){
      if (isset($this->owner->stat('constants_less')[$c->Code])){
        $code = $this->owner->stat('constants_less')[$c->Code];
        file_put_contents($fullpath, "\n".$code.'-background:#'.$c->Color.';',FILE_APPEND);
        file_put_contents($fullpath, "\n".$code.'-color:#'.$c->FontColor.';',FILE_APPEND);
        if ($c->Code == "BodyBackground"){
          if ($c->LinkColor){
            file_put_contents($fullpath, "\n".'@global-link-color:#'.$c->LinkColor.';',FILE_APPEND);
          }
          if ($c->LinkHoverColor){
            file_put_contents($fullpath, "\n".'@global-link-hover-color:#'.$c->LinkHoverColor.';',FILE_APPEND);
          }
        }
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

  public function WriteBackgroundClasses(){
    $fullpath = Director::baseFolder().$this->owner->getBackgroundColorsFile();
     if ($this->owner->hasExtension('SilverStripe\Subsites\Extensions\SiteConfigSubsites')){
      if ($this->owner->SubsiteID > 0){
         $fullpath = Director::baseFolder().'/themes/'.$this->owner->Subsite()->Theme.'/css/src/deskall/theme/colors.less';
      }
    }
    file_put_contents($fullpath, '// CREATED FROM SILVERSTRIPE LAYOUT CONFIG --- DO NOT DELETE OR MODIFY');
    foreach($this->owner->Colors() as $c){
      /** global background element and font color **/
      file_put_contents($fullpath, "\n".".".$c->Code.'{background-color:#'.$c->Color.';color:#'.$c->FontColor.';h1,h2,h3,h4,h5,h6{color:#'.$c->FontColor.';}.dk-text-content a, .calltoaction-container *{color:#'.$c->LinkColor.';&:after{background-color:#'.$c->LinkColor.';}&:active,&:hover{color:#'.$c->LinkHoverColor.';*{color:#'.$c->LinkHoverColor.';}&:after{background-color:#'.$c->LinkHoverColor.';}}}*:not(input,select,textarea){color:#'.$c->FontColor.';}}',FILE_APPEND);
      /** CSS Class for Call To Action Link **/
      file_put_contents($fullpath, "\n".".uk-button.button-".$c->Code.'{background-color:#'.$c->Color.';color:#'.$c->FontColor.'!important;*{color:#'.$c->FontColor.'!important;}&:hover,&:focus,&:active{color:#'.$c->LinkHoverColor.'!important;*{color:#'.$c->LinkHoverColor.'!important;}}&:hover{background-color:darken(#'.$c->Color.', 5%);}&:active{background-color:darken(#'.$c->Color.', 10%);}}',FILE_APPEND);
      /** CSS Class for Call To Form Button **/
      file_put_contents($fullpath, "\n".".userform .button-".$c->Code.' .uk-button{background-color:#'.$c->Color.';color:#'.$c->FontColor.';*{color:#'.$c->FontColor.';}}',FILE_APPEND);
      /*** Css class for Slideshow controls **/
      file_put_contents($fullpath,
        "\n".'.'.$c->Code.' .uk-dotnav > * > *{background-color:transparent;border-color:#'.$c->FontColor.';}' 
        ."\n".'.'.$c->Code.' .uk-dotnav > .uk-active > *{background-color:#'.$c->FontColor.';}'
        ."\n".'.'.$c->Code.' .uk-dotnav > * > :hover, .'.$c->Code.' .uk-dotnav > * > :focus {background-color:#'.$c->FontColor.';}',FILE_APPEND);
      file_put_contents($fullpath, "\n".".uk-active .menu-title-".$c->Code.'{border-color:#'.$c->Color.';}',FILE_APPEND);
      /*** Css class for Background Overlays **/
      file_put_contents($fullpath,"\n".'.'.$c->Code.'.dk-overlay:after{background-color:fade(#'.$c->Color.',50%);}'
        ."\n".'.'.$c->Code.'.dk-overlay .uk-panel a:not(.dk-lightbox):not(.uk-button):not(.uk-slidenav):not(.uk-dotnav):hover:after{background-color:#'.$c->LinkHoverColor.';}'
        ."\n".'.'.$c->Code.'.dk-overlay *{color:#'.$c->FontColor.';}',FILE_APPEND);
       /*** Css class for Short Text Overlays **/
      file_put_contents($fullpath,"\n".'.'.$c->Code.' .dk-text-content .short-text .button-container{background-image: linear-gradient(to bottom, transparent, #'.$c->Color.');}',FILE_APPEND);
       /*** Css class for Form Elements **/
      file_put_contents($fullpath,"\n".'.'.$c->Code.'{.uk-input,.uk-textarea,.uk-select {background-color: rgba(255,255,255,0.6);}}',FILE_APPEND);
      file_put_contents($fullpath,"\n".'.'.$c->Code.' .uk-form-label {color: #'.$c->FontColor.';}',FILE_APPEND);
      file_put_contents($fullpath,"\n".'.'.$c->Code.' input[type="checkbox"],'.$c->Code.' input[type="radio"]{ &:focus,&:checked,&:indeterminate{background-color: #'.$c->LinkColor.';color: #'.$c->LinkHoverColor.';}}',FILE_APPEND);
    }

    //Provide extension for project specific stuff
    $this->owner->extend('updateWriteBackgroundClasses', $fullpath);
  }

  public function RegenerateCss(){
    $files = ['body.min.css','head.min.css','editortocompile.css'];
    foreach ($files as $key => $value) {
      $url = $this->owner->getAbsoluteCurrentThemeDir().'/css/'.$value;
      if ($this->owner->hasExtension('SilverStripe\Subsites\Extensions\SiteConfigSubsites')){
          if ($this->owner->SubsiteID > 0){
              $url = Director::AbsoluteURL('themes/'.$this->owner->Subsite()->Theme.'/css/'.$value);
          }
        }
      $req = curl_init($url);
      $postdata = [];
      curl_setopt($req, CURLOPT_POST, true);
      curl_setopt($req, CURLOPT_POSTFIELDS, $postdata);
      curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
      curl_exec($req);
      ob_start();
            print_r($url);
            $result = ob_get_clean();
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result,FILE_APPEND);

    }
   
  }

  public function getBackgroundColors(){
        $colors = $this->owner->Colors();
        $source = [];
        $source['no-bg'] = [
                'Title' => _t(__CLASS__.'.noColor','Keine Farbe'),
                'HTML' => '<div class="option-html background">
            <p>'._t(__CLASS__.'.noColor','Keine Farbe').'</p>
          </div>'
            ];
        foreach($colors as $c){
            $html = $c->getHTMLOption();
            $source[$c->Code] = [
                'Title' => $c->Title,
                'HTML' => $html
            ];
        }
        return $source;
    }


  //Transform 120px into 120
  public function IntVal($param){
    return intval(str_replace('px','',$param));
  }

  public function RandomSlides(){
    return $this->owner->Slides()->filter('isVisible',1)->sort('RAND()');
  }

  public function activeSlides(){
    return $this->owner->Slides()->filter('isVisible',1);
  }

/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}