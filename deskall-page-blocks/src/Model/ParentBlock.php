<?php

use DNADesign\ElementalList\Model\ElementList;


use DNADesign\Elemental\Models\ElementalArea;

use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\FieldType\DBField;

class ParentBlock extends ElementList
{
   
    

    private static $table_name = 'ParentBlock';

    private static $title = 'Group';

    private static $description = 'Orderable list of blocks';
    
    private static $singular_name = 'Parent Block';

    private static $plural_name = 'Parent Blocks';

    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Parent Block');
    }
}
