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
        ob_start();
            print_r($changed);
            $result = ob_get_clean();
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result,FILE_APPEND);
        foreach ($changed as $key => $value) {
            //save only header
            if (!in_array($key,$exclude)){
                $header = $this->Parent()->Headers()->byId($key);
                if ($header){
                    //If new create
                    if (empty($value['before'])){
                        $cell = new TableCell();
                        $cell->RowID = $this->ID;
                        $cell->HeaderID = $key;
                        $cell->Sort = $header->Sort;
                        $cell->Value = $value['after'];
                    }
                    //else update
                    else{
                        $cell = $this->Cells()->filter(['HeaderID' => $key,'RowID' => $this->ID])->first();
                        if ($cell){
                            $cell->Value = $value['after'];
                        }
                    }
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
