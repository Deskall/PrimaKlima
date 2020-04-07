<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\ArrayList;
use g4b0\SearchableDataObjects\Searchable;

class MapBlock extends BaseElement implements Searchable
{
    private static $icon = 'font-icon-globe-1';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText',
        'Adresse' => 'Varchar(255)',
        'Height' => 'Varchar(255)',
        'Styles' => 'Text',
        'disableDefaultUI' => 'Boolean(0)',
        'mapTypeControl' => 'Boolean(1)',
        'mapTypeControlOptions' => 'Text',
        'ZoomControl' => 'Boolean(1)',
        'ZoomControlOptions' => 'Text',
        'streetViewControl' => 'Boolean(1)',
        'streetViewControlOptions' => 'Text',
        'scaleControl' => 'Boolean(1)',
        'fullscreenControl' => 'Boolean(1)',
        'InfoWindowHTML' => 'HTMLText'

    ];

    private static $block_heights = [
        'uk-height-small' => 'klein',
        'uk-height-medium' => 'medium',
        'uk-height-large' => 'gross'
    ];

    private static $defaults = [
        'Height' => 'uk-height-medium'
    ];

    private static $extensions = [
        'CollapsableTextExtension'
    ];


   
    private static $table_name = 'MapBlock';

    private static $singular_name = 'Google Map block';

    private static $plural_name = 'Google Map blocks';

    private static $description = 'Google Map mit Adresse hinzufügen';



    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Layout');
        // $fields->removeByName('GlobalLayout');
        $fields->removeByName('Height');
        $fields->removeByName('disableDefaultUI');
        $fields->removeByName('mapTypeControl');
        $fields->removeByName('mapTypeControlOptions');
        $fields->removeByName('ZoomControl');
        $fields->removeByName('ZoomControlOptions');
        $fields->removeByName('streetViewControl');
        $fields->removeByName('streetViewControlOptions');
        $fields->removeByName('scaleControl');
        $fields->removeByName('fullscreenControl');
        $fields->removeByName('Styles');
            
            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Content'))
                ->setRows(5);

            $fields
                ->fieldByName('Root.Main.InfoWindowHTML')
                ->setTitle(_t(__CLASS__ . '.InfoWindowHTMLLabel', 'Inhalt der Infowindow'))
                ->setRows(5);
                
            $fields->addFieldToTab('Root.Main',TextField::create('Adresse',_t(__CLASS__.'.Adresse','Adresse')),'HTML');

            $fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
                OptionsetField::create('Height',_t(__CLASS__.'.Height','Height'), $this->getTranslatedSourceFor(__CLASS__,'block_heights'))
                )->setTitle(_t(__CLASS__.'.BlockLayout','Layout'))->setName('BlockLayout')
            );
            $fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
                CheckboxField::create('disableDefaultUI',_t(__CLASS__.'.disableControls','Kontrol deaktivieren')),
                CheckboxField::create('mapTypeControl',_t(__CLASS__.'.mapControls','Map Kontrol'))->displayIf('disableDefaultUI')->isNotChecked()->end(),
                TextareaField::create('mapTypeControlOptions',_t(__CLASS__.'.mapControlOptions','Map Kontrol Optionen'))->displayIf('mapTypeControl')->isChecked()->andIf('disableDefaultUI')->isNotChecked()->end(),
                CheckboxField::create('ZoomControl',_t(__CLASS__.'.zoomControls','Zoom Kontrol'))->displayIf('disableDefaultUI')->isNotChecked()->end(),
                TextareaField::create('ZoomControlOptions',_t(__CLASS__.'.zoomControlOptions','Zoom Kontrol Optionen'))->displayIf('ZoomControl')->isChecked()->andIf('disableDefaultUI')->isNotChecked()->end(),
                CheckboxField::create('streetViewControl',_t(__CLASS__.'.streetViewControls','StreetView Kontrol'))->displayIf('disableDefaultUI')->isNotChecked()->end(),
                TextareaField::create('streetViewControlOptions',_t(__CLASS__.'.streetViewControlOptions','StreetView Kontrol Optionen'))->displayIf('streetViewControl')->isChecked()->andIf('disableDefaultUI')->isNotChecked()->end(),
                CheckboxField::create('scaleControl',_t(__CLASS__.'.scaleControls','Scale Kontrol'))->displayIf('disableDefaultUI')->isNotChecked()->end(),
                CheckboxField::create('fullscreenControl',_t(__CLASS__.'.fullscreenControls','Fullscreen Kontrol'))->displayIf('disableDefaultUI')->isNotChecked()->end(),
                LiteralField::create('Styles generieren','<a href="https://mapstyle.withgoogle.com/" target="_blank">'._t(__CLASS__.'.LinkToStyle','Styles generieren').'</a>'),
                TextareaField::create('Styles',_t(__CLASS__.'.Styles','Google Map Styles'))
            )->setTitle(_t(__CLASS__.'.Settings','Einstellungen'))->setName('Settings'));
               

        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Map');
    }

    public function NiceStyles(){
        return preg_replace( "/\r|\n/", "", $this->Styles );
    }

    public function getMapOptions(){
        $options = [];
        $options['zoom'] = 15;
        $options['disableDefaultUI'] = ($this->disableDefaultUI) ? true : false;
        if(!$this->disableDefaultUI){
            $options['mapTypeControl'] = ($this->mapTypeControl) ? true : false;
            if ($this->mapTypeControlOptions){
                $options['mapTypeControlOptions'] = json_decode(preg_replace( "/\r|\n/", "", $this->mapTypeControlOptions ));
            }
            
            $options['zoomControl'] = ($this->ZoomControl) ? true : false;
            if ($this->ZoomControlOptions){
                $options['zoomControlOptions'] = json_decode(preg_replace( "/\r|\n/", "", $this->zoomControlOptions ));
            }
            
            $options['streetViewControl'] = ($this->streetViewControl) ? true : false;
            if ($this->streetViewControlOptions){
                $options['streetViewControlOptions'] = json_decode(preg_replace( "/\r|\n/", "", $this->streetViewControlOptions ));
            }

            $options['scaleControl'] = ($this->scaleControl) ? true : false;
            $options['fullscreenControl'] = ($this->fullscreenControl) ? true : false;
        }

        if($this->Styles){
            $options['styles'] = json_decode($this->NiceStyles());
        }
        return json_encode($options);
    }


    /************* SEARCHABLE FUNCTIONS ******************/


        /**
         * Filter array
         * eg. array('Disabled' => 0);
         * @return array
         */
        public static function getSearchFilter() {
            return array();
        }

        /**
         * FilterAny array (optional)
         * eg. array('Disabled' => 0, 'Override' => 1);
         * @return array
         */
        public static function getSearchFilterAny() {
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
            return array('HTML','Adresse');
        }
    /************ END SEARCHABLE ***************************/

}
