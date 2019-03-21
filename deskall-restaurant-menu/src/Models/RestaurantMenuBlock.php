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

class RestaurantMenuBlock extends BaseElement
{
    private static $icon = 'font-icon-book-open';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $table_name = 'RestaurantMenuBlock';

    private static $singular_name = 'Menu Block';

    private static $plural_name = 'Menu Blocks';

    private static $description = 'Bestimmte Menu mit Speisen';

    private static $db = ['HTML' => 'HTMLText'];

    private static $has_one = [
        'Menu' => MenuCarte::class
    ];

    public function getType(){
        return $this->description;
    }

    

}
