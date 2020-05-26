<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\OptionsetField;

class ProductVariant extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(255)',
        'Price' => 'Currency',
        'Stock' => 'Varchar(255)',
        'Default' => 'Boolean(0)'
    );


    private static $summary_fields = array(
        'Title' => 'Titel',
        'Price' => 'Preis',
        'Stock' => 'Lagerbestand',
        'Default' => 'Standard?'
    );

    private static $has_one = array(
        'Product' =>  Product::class
    );

    private static $singular_name = 'Produkt Variant';
    private static $plural_name = 'Produkt Varianten';

    private static $extensions = [
        'Activable',
        'Sortable'
    ];

    public function fieldLabels($includerelation = true){
        $labels = parent::fieldLabels($includerelation);
        $labels['Title'] = _t('Product.Title', 'Titel');
        $labels['Price'] = _t('Product.Price', 'Preis');
        $labels['Product'] =  _t('Product.Product', 'Produkt');
        $labels['Stock'] =  _t('Product.Stock', 'Lagerbestand');
        $labels['Default'] =  _t('Product.Default', 'standard?');
        return $labels;
    }


    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('ProductID');
        $fields->removeByName('Stock');
        $fields->addFieldToTab('Root.Main',OptionsetField::create('Stock',$this->fieldLabels()['Stock'],['onStock' => _t('Product.onStock','Am Lager'), 'soldOff' => _t('Product.SoldOff','Ausverkauft')]));

        return $fields;
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        $changedFields = $this->getChangedFields();
        if ($this->isChanged('Default')){
            if ($changedFields['Default']['After'] == 1){
               $pvs = $this->Product()->Variants()->filter('Default',1)->exclude('ID',$this->ID);
                foreach ($pvs as $pv) {
                    $pv->Default = false;
                    $pv->write();
                }
            }
        }
    }

}


