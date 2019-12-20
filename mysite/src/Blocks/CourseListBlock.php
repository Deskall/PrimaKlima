<?php

use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\Control\Director;
use SilverStripe\Forms\TextField;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\ArrayList;

class CourseListBlock extends BaseElement implements Searchable
{
    private static $icon = 'font-icon-block-content';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $help_text = "Kurse List";

    private static $table_name = 'CourseInfoBlock';

    private static $singular_name = 'Kurse List Block';

    private static $plural_name = 'Kurse List Blöcke';

    private static $description = 'Kurse List';

    private static $db = array(
        'GroupID' => 'Varchar(255)'
    );

    public function getCMSFields(){
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', TextField::create('GroupID', 'Beyond GruppID'), 'TitleAndDisplayed');
      
        return $fields;
    }

    public function getGroupData(){
        if ($this->GroupID){
            $Api = new beyond_jsonKurse();
            $data = $Api->getKursGruppen($this->GroupID);
            if (is_array($data) && isset($data[0])){
                return new ArrayData($data[0]);
            }
        }
        return null;
    }

    public function getMainGroup(){
        if ($this->GroupID){
            $Api = new beyond_jsonKurse();
            $data = $Api->getKursStruktur($this->GroupID);

            if (is_array($data) && isset($data[0])){
              
                $MainGroupID = $data[0]->HauptGruppenID;
                $MainGroup = $Api->getKursGruppen($MainGroupID);
                if (is_array($MainGroup) && isset($MainGroup[0])){
                    return new ArrayData($MainGroup[0]);
                }
            }
        }
        return null;
    }

    public function getLessons(){
        $Api = new beyond_jsonKurse();
        $KursStruktur = $this->getKursStruktur(); 

       
       
        $list = array();
        foreach ($KursStruktur as $key => $group) {
            $data = $Api->getKurse(null,null,null,null,$group->GruppenID);
            if (is_array($data)){
                foreach ($data as $row)
                $list[] = new ArrayData($row);
            }
        }
      
            
            
        return new ArrayList($list);
      
    }

    public function getKursStruktur(){
       if ($this->GroupID){
            $Api = new beyond_jsonKurse();
            $data = $Api->getKursStruktur($this->GroupID);
            $list = array();
            if (is_array($data)){
                foreach ($data as $row){
                     $list[] = new ArrayData($row);
                }
            }
            return new ArrayList($list);
        }
       return null;
    }

    public function NiceDate($string){
        return date('d-m-Y',strtotime($string));
    }

   

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Kurse List');
    }

    /************* SEARCHABLE FUNCTIONS ******************/


        /**
         * Filter array
         * eg. array('Disabled' => 0);
         * @return array
         */
        public static function getSearchFilter() {
            return array();
        }

        /**
         * FilterAny array (optional)
         * eg. array('Disabled' => 0, 'Override' => 1);
         * @return array
         */
        public static function getSearchFilterAny() {
            return array();
        }


        /**
         * Fields that compose the Title
         * eg. array('Title', 'Subtitle');
         * @return array
         */
        public function getTitleFields() {
            return array('Title');
        }

        /**
         * Fields that compose the Content
         * eg. array('Teaser', 'Content');
         * @return array
         */
        public function getContentFields() {
            return array('Title');
        }
    /************ END SEARCHABLE ***************************/
}
