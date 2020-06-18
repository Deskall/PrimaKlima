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
        'ProductType' => 'Varchar'
    ];

    private static $defaults = ['Type' => 'products'];

    private static $has_one = ['Category' => ProductCategory::Class];

    private static $many_many = ['Products' => Product::class, 'Options' => ProductOption::class];

    private static $table_name = 'ProductBlock';

    private static $singular_name = 'Produkt Block';

    private static $plural_name = 'Produkt Blöcke';

    private static $description = 'Zeigt Produktdetails nach Kategorie oder custom Wahl an';


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('ProductType');
        $fields->insertBefore('TitleAndDisplayed',DropdownField::create('ProductType','Typ',['products' => 'Produkte','packages' => 'Pakete','options' => 'Optionen'])->setEmptyString('Bitte Typ auswählen'));
       
        $fields->FieldByName('Root.Main.CategoryID')->displayIf('Type')->isEqualTo('products')->orIf('Type')->isEqualTo('options')->end();

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
        switch($this->ProductType){
            case "products":
                if ($this->Category()->exists()){
                    return $this->Category()->filteredProducts();
                }
                return $this->Products()->filter('isVisible',1)->filterByCallback(function($item, $list) {
                    return ($item->shouldDisplay() && $item->isAvailable());
                });
            break;
            case "packages":
                //TO DO if needed custom packages
                // if ($this->CustomPackages()->exists()){
                //     return $this->CustomPackages()->filterByCallback(function($item, $list) {
                //         return ($item->shouldDisplay());
                //     });
                // }
                return Package::get()->filter('isVisible',1)->filterByCallback(function($item, $list) {
                    return ($item->shouldDisplay() && $item->isAvailable());
                });
            break;
            case "options":
                if ($this->Category()->exists()){
                    return $this->Category()->filteredOptions();
                }
                return $this->Options()->filter('isVisible',1)->filterByCallback(function($item, $list) {
                    return ($item->shouldDisplay() && $item->isAvailable());
                });
            break;
        }
    }

    /************* SEARCHABLE FUNCTIONS ******************/

        /**
         * Fields that compose the Content
         * eg. array('Teaser', 'Content');
         * @return array
         */
        public function getContentFields() {
            return array('HTML','PackageContent');
        }

        public function getPackageContent(){
            $html = '';
            $packages = $this->filteredItems();
            if ($packages){
                $html .= '<ul>';
                foreach ($packages as $item) {
                    $html .= '<li>';
                    $html .= $item->Title.' '.$item->Subtitle;
                    if ($item->Items()->exists()){
                        foreach ($item->Items() as $i) {
                            $html .= ' '.$i->Title.' '.$i->Content;
                        }
                    }
                    $html .= ' | ';
                    $html .= '</li>';
                }
                $html .='</ul>';
            }
            return $html;
        }
    /************ END SEARCHABLE ***************************/
}
