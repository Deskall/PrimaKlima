<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\ListboxField;


class MatchingToolPackage extends Package {

    private static $db = array(
        'Title' => 'Varchar(255)',
        'Description' => 'HTMLText',
        'Credits' => 'Int',
        'CreditsTitle' => 'Varchar(255)',
        'Price' => 'Currency',
        'SalePrice' => 'Currency'
    );

   
    private static $singular_name = 'Matching Tool Paket';
    private static $plural_name = 'Matching Tool Pakete';
   

    public function getCMSFields() {
        $fields = new FieldList();
        $fields->push(new TabSet('Root'));

        $fields->addFieldToTab('Root.Global', TextField::create('Title', _t('Package.Title', 'Titel')) );
        $fields->addFieldToTab('Root.Global', NumericField::create('Price', _t('Package.Price', 'Preis')) );
        $fields->addFieldToTab('Root.Global', NumericField::create('SalePrice', _t('Package.SalePrice', 'Aktionspreis')) );

        $fields->addFieldToTab('Root.Global', NumericField::create('Credits', _t('Package.Credits', 'Anzahl Kredite')) );
        $fields->addFieldToTab('Root.Global', TextField::create('CreditsTitle', _t('Package.CreditsTitle', 'Kredite Label')) );

        $fields->addFieldToTab('Root.Global', ListboxField::create('Features', _t('Package.Features', 'Features'), PackageConfigItem::get()->map('ID','Title')->toArray())->setAttribute('data-placeholder', _t('Package.Choose', 'Bitte Wählen')) );

        $fields->addFieldToTab('Root.Global', HTMLEditorField::create('Description', _t('Package.Beschreibung', 'Beschreibung'))->setRows(5) );
      

        return $fields;
    }


}


