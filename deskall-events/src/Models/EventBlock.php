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

class EventBlock extends BaseElement
{
    private static $icon = 'font-icon-book-open';
    
    private static $controller_template = 'EventBlockHolder';

    private static $controller_class = BlockController::class;

    private static $table_name = 'EventBlock';

    private static $singular_name = 'Seminare Übersicht block';

    private static $plural_name = 'Seminare Übersicht blocks';

    private static $description = 'List den Seminare mit Datum';

    private static $db = [
        'Conditions' => 'HTMLText'
    ];

    public function getType(){
        return $this->description;
    }

    public function activeEvents(){
        return Event::get()->filter('isVisible',1);
    }

}
