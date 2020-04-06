<?php

use SilverStripe\ORM\DataObject;

class TableRow extends DataObject
{


    private static $has_one = [
        'Parent' => TableBlock::class
    ];

    private static $has_many = ['Cells' => TableCell::class];

    private static $owns = ['Cells'];

    private static $cascade_duplicates = ['Cells'];

    private static $extensions = [
        'Activable',
        'Sortable'
    ];

    public function onAfterWrite(){
        parent::onAfterWrite();
        $this->saveCells();
    }

    public function saveCells(){
        $exclude = ['SecurityID','ParentID'];
        $changed = $this->getChangedFields();
        foreach ($changed as $title => $value) {
            //save only header
            if (!in_array($title,$exclude)){
                $header = $this->Parent()->Headers()->filter('Title',$title);
                if ($header){
                    $cell = TableCell::get()->filter(['HeaderID' => $header->ID,'RowID' => $this->ID])->first();
                    //If new create
                    if (!$cell){
                        $cell = new TableCell();
                        $cell->RowID = $this->ID;
                        $cell->HeaderID = $header->ID;
                        $cell->Sort = $header->Sort;
                    }
                    $cell->Value = $value['after'];
                    $cell->write();
                }
                
            }
        }
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
       
           

        return $fields;
    }


}
