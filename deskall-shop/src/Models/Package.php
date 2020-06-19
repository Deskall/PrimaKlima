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
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\i18n\i18n;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;

class Package extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(255)',
        'Description' => 'HTMLText',
        'NumOfAds' => 'Int',
        'NumOfAdsTitle' => 'Varchar(255)',
        'Price' => 'Currency',
        'SalePrice' => 'Currency',
        'RunTime' => 'Int',
        'RunTimeTitle' => 'Varchar(255)',
        'RunTimeCurrency' => 'Varchar(255)',
        'isFlatrate' => 'Boolean'
    );

    private static $many_many = array(
        'Features' => PackageConfigItem::class,
    );

    private static $has_one = ['Page' => ShopPage::class];

    private static $has_many = array(
        'PackegeOptions' => 'PackageOption',
    );

    private static $cascade_duplicates = ['Features'];


    private static $summary_fields = array(
        'Title' => 'Titel',
    );

    private static $singular_name = 'Paket';
    private static $plural_name = 'Pakete';

    private static $extensions = [
        'Activable',
        'Sortable'
    ];



    public function getCMSFields() {
        $fields = new FieldList();
        $fields->push(new TabSet('Root'));

        $fields->addFieldToTab('Root.Global', TextField::create('Title', _t('Package.Title', 'Titel')) );
        $fields->addFieldToTab('Root.Global', NumericField::create('Price', _t('Package.Price', 'Preis')) );
        $fields->addFieldToTab('Root.Global', NumericField::create('SalePrice', _t('Package.SalePrice', 'Aktionspreis')) );

        $fields->addFieldToTab('Root.Global', CheckboxField::create('isFlatrate', _t('Package.isFlatrate', 'Flatrate')) );


        $fields->addFieldToTab('Root.Global', NumericField::create('NumOfAds', _t('Package.NumOfAds', 'Anzahl Stellenanzeigen')) );

        $fields->addFieldToTab('Root.Global', NumericField::create('RunTime', _t('Package.RunTime', 'Laufzeit')) );
        $fields->addFieldToTab('Root.Global', DropdownField::create('RunTimeCurrency',_t('PACKAGE.RunTimeCurrency', 'Laufzeit Einheit'), array(
            'week' => 'Wochen',
            'month' => 'Monate',
        )));


        $fields->addFieldToTab('Root.Global', ListboxField::create('Features', _t('Package.Features', 'Features'), PackageConfigItem::get()->map('ID','Title')->toArray())->setAttribute('data-placeholder', _t('Package.Choose', 'Bitte Wählen')) );

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


        $fields->addFieldToTab('Root.Global', HTMLEditorField::create('Description', _t('Package.Beschreibung', 'Beschreibung'))->setRows(5) );
        $fields->addFieldToTab('Root.Global', TextField::create('NumOfAdsTitle', _t('Package.NumOfAds', 'Anzahl Stellenanzeigen')) );
        $fields->addFieldToTab('Root.Global', TextField::create('RunTimeTitle', _t('Package.RunTime', 'Laufzeit Anzeige')) );



        return $fields;
    }

    public function currentPrice(){
        if( $this->SalePrice > 0 ){
            return $this->SalePrice;
        }else{
            return $this->Price;
        }
    }

    public function getParameters(){
        $parameters = [];
        $features = PackageConfigItem::get()->filter('isVisible',1);
        foreach ($features as $f) {
            $parameters[$f->ID] = ['title' => $f->Title, 'included' => $this->Features()->byId($f->ID)];
        }
        return new ArrayList($parameters);
    }

    public function OrderLink(){
        return $this->Page()->Link();
    }

}


