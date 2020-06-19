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

class Product extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(255)',
        'Description' => 'HTMLText',
        'NumOfAds' => 'Int',
        'NumOfAdsTitle' => 'Varchar(255)',
        'Price' => 'Currency',
        'SalePrice' => 'Currency'
    );


    private static $summary_fields = array(
        'Title' => 'Titel',
    );

    private static $singular_name = 'Produkt';
    private static $plural_name = 'Produkte';

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

        $fields->addFieldToTab('Root.Global', NumericField::create('NumOfAds', _t('Package.NumOfAds', 'Anzahl Kontaktanzeigen')) );


        $fields->addFieldToTab('Root.Global', HTMLEditorField::create('Description', _t('Package.Beschreibung', 'Beschreibung'))->setRows(5) );
        $fields->addFieldToTab('Root.Global', TextField::create('NumOfAdsTitle', _t('Package.NumOfAds', 'Anzahl Kontaktanzeigen')) );



        return $fields;
    }

    public function currentPrice(){
        if( $this->SalePrice > 0 ){
            return $this->SalePrice;
        }else{
            return $this->Price;
        }
    }


    public function OrderLink(){
        return ShopPage::get()->first()->Link();
    }

}


