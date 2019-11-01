<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\SiteConfig\SiteConfig;

class ProductBlock extends TextBlock
{
    private static $icon = 'font-icon-tags';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $help_text = "Produkte Block";

    private static $db = [
        'Type' => 'Varchar'
    ];

    private static $defaults = ['Type' => 'products'];

    private static $has_one = ['Category' => ProductCategory::Class];

    private static $many_many = ['Products' => Product::class];

    private static $table_name = 'ProductBlock';

    private static $singular_name = 'Produkt Block';

    private static $plural_name = 'Produkt Blöcke';

    private static $description = 'Zeigt Produktdetails nach Kategorie oder custom Wahl an';


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Type');
        $fields->addFieldToTab('Root.Main',DropdownField::create('Type','Typ',['products' => 'Produkte','packages' => 'Pakete','options' => 'Optionen'])->setEmptyString('Bitte Typ auswählen'));
       

        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Zeigt Produktdetails nach Kategorie an');
    }


    public function filteredItems(){
        switch($this->Type){
            case "products":
                if ($this->Category()->exists()){
                    return $this->Category()->filteredProducts();
                }
                return $this->Products()->filterByCallback(function($item, $list) {
                    return ($item->shouldDisplay());
                });
            break;
            case "packages":
                //TO DO if needed custom packages
                // if ($this->CustomPackages()->exists()){
                //     return $this->CustomPackages()->filterByCallback(function($item, $list) {
                //         return ($item->shouldDisplay());
                //     });
                // }
                return Packages::get()->filter('isVisible',1)->filterByCallback(function($item, $list) {
                    return ($item->shouldDisplay());
                });
            break;
            case "optionen":
               // 
            break;
        }
        
    }
}
