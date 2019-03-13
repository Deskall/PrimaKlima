<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\ORM\GroupedList;

class RestaurantCarteBlock extends BaseElement
{
    private static $icon = 'font-icon-block-file-list';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $table_name = 'RestaurantCarteBlock';

    private static $singular_name = 'Speisenkarte Block';

    private static $plural_name = 'Speisenkarte Block';

    private static $description = 'Speisenkarte per Sorten';

    public function getType(){
        return $this->description;
    }

    public function Categories(){
        return DishCategory::get()->filter('isVisible',1)->sort('Sort');
    }

}
