<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use UncleCheese\DisplayLogic\Forms\Wrapper;

class MenuCarteElement extends DataObject{

    private static $singular_name = 'Karte Item';

    private static $plural_name = 'Karte Items';

    private static $db = [
        'Type' => 'Varchar',
        'Title' => 'Varchar',
        'Content' => 'HTMLText',
        'ShowOnWeb' => 'Boolean(0)'
    ];

    private static $has_one = [
        'Karte' => MenuCarte::class,
        'Menu' => Menu::class,
        'Dish' => Dish::class,
        'Parent' => MenuCarteElement::class
    ];

    private static $has_many = [
        'Children' => MenuCarteElement::class
    ];


   
    private static $extensions = [
        'Activable',
        'Sortable'
    ];

    private static $summary_fields = ['NiceType','Title'];


    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Title'] = _t(__CLASS__.'.Title','Titel');
        $labels['Type'] = _t(__CLASS__.'.Type','Typ');
        $labels['NiceType'] = _t(__CLASS__.'.Type','Typ');
        $labels['Content'] = _t(__CLASS__.'.Content','Inhalt');
        $labels['Karte'] = _t(__CLASS__.'.Karte','Karte');
        $labels['Menu'] = _t(__CLASS__.'.Menu','Menü');
        $labels['Dish'] = _t(__CLASS__.'.Dish','Speise');
        $labels['ShowOnWeb'] = _t(__CLASS__.'.ShowOnWeb','Auf Web anzeigen?');
        return $labels;
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        if (!$this->Title){
            switch($this->Type){
                case "menu":
                $this->Title = ($this->Menu()->exists()) ? $this->Menu()->Title : null;
                break;
                case "dish":
                $this->Title = ($this->Dish()->exists()) ? $this->Dish()->Title : null;
                break;
                case "element":
                default:
                $this->Title = ($this->ID > 0) ? "Menu-".$this->ID : null;
                break;
            }
        }
    }

    public function NiceType(){
        $types = ['menu' => 'Menü','dish' => 'Speise','group' => 'Grupp','element' => 'Inhalt', 'divider' => 'Linie','pagebreak' => 'Seitenumbruch'];
        return $types[$this->Type];
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('Type');
        $fields->removeByName('Children');
        $fields->removeByName('ParentID');
        $fields->removeByName('KarteID');

        $fields->insertBefore('Title',DropdownField::create('Type',$this->fieldLabels()['Type'],['menu' => 'Menü','dish' => 'Speise','group' => 'grupp','element' => 'Inhalt', 'divider' => 'Linie','pagebreak' => 'Seitenumbruch'])->setEmptyString('Bitte wählen'));

        $fields->FieldByName('Root.Main.DishID')->displayIf('Type')->isEqualTo('dish');
        $fields->FieldByName('Root.Main.MenuID')->displayIf('Type')->isEqualTo('menu');
        $fields->FieldByName('Root.Main.Content')->displayIf('Type')->isEqualTo('element');
        $fields->FieldByName('Root.Main.Title')->hideIf('Type')->isEqualTo('divider')->orIf('Type')->isEqualTo('pagebreak');

        if ($this->ID > 0){
            $gridfield = GridField::create('Children','Items',$this->Children(),GridFieldConfig_RecordEditor::create()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction()));
            $fields->addFieldToTab('Root.Main',Wrapper::create($gridfield)->displayIf('Type')->isEqualTo('group')->end());
        }
        
        return $fields;
    }



}
