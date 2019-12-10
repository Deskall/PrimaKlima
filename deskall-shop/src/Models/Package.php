<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropDownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldTitleHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldAddNewInlineButton;
use SilverStripe\i18n\i18n;

class Package extends DataObject {

    private static $db = array(
        'Title__de_DE' => 'Varchar(255)',
        'SortOrder' => 'Int',
        'Description__de_DE' => 'HTMLText',
        'NumOfAds' => 'Int',
        'NumOfAdsTitle__de_DE' => 'Varchar(255)',
        'Price' => 'Currency',
        'SalePrice' => 'Currency',
        'RunTime' => 'Int',
        'RunTimeTitle__de_DE' => 'Varchar(255)',
        'RunTimeCurrency' => 'Varchar(255)',
        'isFlatrate' => 'Boolean'
    );

    private static $many_many = array(
        'Features' => 'PackageConfigItem',
    );

    private static $has_many = array(
        'PackegeOptions' => 'PackageOption',
    );


    private static $summary_fields = array(
        'Title__de_DE' => 'Titel',
    );

    private static $singular_name = 'Paket';
    private static $plural_name = 'Pakete';



    public function getCMSFields() {
        $fields = new FieldList();
        $fields->push(new TabSet('Root'));

        $fields->addFieldToTab('Root.Global', TextField::create('Title__de_DE', _t('Package.Title', 'Titel')) );
        $fields->addFieldToTab('Root.Global', NumericField::create('Price', _t('Package.Price', 'Preis')) );
        $fields->addFieldToTab('Root.Global', NumericField::create('SalePrice', _t('Package.SalePrice', 'Aktionspreis')) );

        $fields->addFieldToTab('Root.Global', CheckboxField::create('isFlatrate', _t('Package.isFlatrate', 'Flatrate')) );


        $fields->addFieldToTab('Root.Global', NumericField::create('NumOfAds', _t('Package.NumOfAds', 'Anzahl Stellenanzeigen')) );

        $fields->addFieldToTab('Root.Global', NumericField::create('RunTime', _t('Package.RunTime', 'Laufzeit')) );
        $fields->addFieldToTab('Root.Global', DropdownField::create('RunTimeCurrency',_t('PACKAGE.RunTimeCurrency', 'Laufzeit Einheit'), array(
            'week' => 'Wochen',
            'month' => 'Monate',
        )));


        $fields->addFieldToTab('Root.Global', ListboxField::create('Features', _t('Package.Features', 'Features'), PackageConfigItem::get()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('Package.Choose', 'Bitte Wählen')) );

        $OptionField = new GridField(
            'PackegeOptions',
            _t('PACKAGE.PackegeOptions', 'Optionen'),
            $this->PackegeOptions(),
            GridFieldConfig::create()
                ->addComponent(new GridFieldButtonRow('before'))
                ->addComponent(new GridFieldTitleHeader())
                ->addComponent(new GridFieldEditableColumns())
                ->addComponent(new GridFieldDeleteAction())
                ->addComponent(new GridFieldAddNewInlineButton())
                ->addComponent(new GridFieldOrderableRows('SortOrder'))
        );

        $OptionField->getConfig()->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
            'Title__de_DE' => array(
                'title' => _t('PACKAGE.Title', 'Titel'),
                'callback' => function ($record, $column, $holiDayGridfield){
                    return TextField::create('Title__de_DE', _t('PACKAGE.Title', 'Titel'));
                }
            ),
            'RunTime' => array(
                'title' => _t('PACKAGE.RunTime', 'Laufzeit') ,
                'callback' => function ($record, $column, $holiDayGridfield){
                    return NumericField::create('RunTime',_t('PACKAGE.RunTime', 'Laufzeit') );
                }
            ),
            'RunTimeCurrency' => array(
                'title' => _t('PACKAGE.RunTimeCurrency', 'Laufzeit Einheit') ,
                'callback' => function ($record, $column, $holiDayGridfield){
                    return DropdownField::create('RunTimeCurrency',_t('PACKAGE.RunTimeCurrency', 'Laufzeit Einheit'), array(
                        'week' => 'Wochen',
                        'month' => 'Monate',
                    ));
                }
            ),
            'Price' => array(
                'title' => _t('PACKAGE.Price', 'Preis') ,
                'callback' => function ($record, $column, $holiDayGridfield){
                    return NumericField::create('Price',_t('PACKAGE.Price', 'Preis') );
                }
            ),

        ));

        $fields->addFieldToTab('Root.Global', $OptionField );


        $fields->addFieldToTab('Root.Deutsch', HTMLEditorField::create('Description__de_DE', _t('Package.Beschreibung', 'Beschreibung'))->setRows(5) );
        $fields->addFieldToTab('Root.Deutsch', TextField::create('NumOfAdsTitle__de_DE', _t('Package.NumOfAds', 'Anzahl Stellenanzeigen')) );
        $fields->addFieldToTab('Root.Deutsch', TextField::create('RunTimeTitle__de_DE', _t('Package.RunTime', 'Laufzeit Anzeige')) );



        return $fields;
    }


    public function getLocaledField( $fieldName ){
        return $this->{ $fieldName.'__'.i18n::get_locale() };
    }


    public function GetFinalPrice(){
        if( $this->SalePrice > 0 ){
            return $this->SalePrice;
        }else{
            return $this->Price;
        }
    }

}


