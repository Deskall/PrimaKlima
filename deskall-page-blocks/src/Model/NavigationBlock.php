<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\LabelField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Core\Config\Config;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\GridField\GridFieldConfig;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\Tab;
use Sheadawson\Linkable\Forms\LinkField;

class NavigationBlock extends BaseElement
{
    private static $icon = 'font-icon-block-menu';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;


    private static $has_many = [
        'Items' => NavigationItem::class
    ];

    private static $cascade_delete = [
        'Items',
    ];

    private static $cascade_duplicates = ['Items'];


    private static $owns = [
        'Items'
    ];



    private static $table_name = 'NavigationBlock';

    private static $singular_name = 'Navigationblock';

    private static $plural_name = 'Navigation blocks';

    private static $description = 'Inline Seite Navigation mit Scroll';



    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

            $fields->removeByName('Layout');
            $fields->removeByName('Items');
            $fields->removeByName('TitleAndDisplayed');


            if ($this->ID > 0){

                $config = 
                GridFieldConfig::create()
                ->addComponent(new GridFieldButtonRow('before'))
                ->addComponent(new GridFieldToolbarHeader())
                ->addComponent(new GridFieldTitleHeader())
                ->addComponent(new GridFieldEditableColumns())
                ->addComponent(new GridFieldDeleteAction())
                ->addComponent(new GridFieldAddNewInlineButton())
                ->addComponent(new GridFieldOrderableRows('Sort'));

                $config->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
                    'Title'  => array(
                        'title' => 'Menu Titel',
                        'callback' => function($record, $column, $grid) {
                            return TextField::create($column)->setAttribute('Placeholder','wird den Blocktitel benutzen falls leer.');
                        }
                    ),
                    'ItemType'  => array(
                        'title' => 'Menu Typ',
                        'callback' => function($record, $column, $grid) {
                            return DropdownField::create($column,'Menu Typ',['block' => 'Scroll zu Element','target' => 'Aktion', 'link' => 'Link']);
                        }
                    ),
                    'TargetID' => array(
                        'title' => 'Seite Block',
                        'callback' => function($record, $column, $grid) {
                            switch($record->ItemType){
                                case "block":
                                    return DropdownField::create($column,'Seite Block',$this->Parent()->Elements()->exclude(['ID' => $this->ID, 'ClassName' => 'HiddenActionBlock'])->map('ID','Title'));
                                break;
                                case "target":
                                    return DropdownField::create($column,'Seite Block',$this->Parent()->Elements()->filter('ClassName','HiddenActionBlock')->exclude('ID',$this->ID)->map('ID','Title'));
                                break;
                                case "link":
                                    return LinkField::create($column, _t(__CLASS__.'.CTA', 'Link'));
                                break;
                                default:
                                    return DropdownField::create($column,'Seite Block',['' => 'Menu Typ auswählen']);
                                break;
                            }
                            
                        }
                    )
                ));
               
                $itemsField = new GridField('Items',_t(__CLASS__.'.Items','Menu Items'),$this->Items(),$config);
              
                
                $fields->addFieldToTab('Root.Main',$itemsField);
            } 
            else {
                $fields->addFieldToTab("Root.Main",LabelField::create('LabelField',_t(__CLASS__.'.AfterCreation','Sie können Menu Items nach dem Erstellen dem Block hinzufügen')));
        
                $fields->removeByName('Items');
            }
     
       return $fields;
    }


    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Navigation Block');
    }

    public function getSourceIcons(){
        //To do : filter relevant icons
        return HTMLDropdownField::getSourceIcones();
    }

 

}
