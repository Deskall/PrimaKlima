<?php
use SilverStripe\Control\Director;
use SilverStripe\Forms\TextField;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\ArrayList;




class GroupPage extends Page {
	//private static $allowed_parents = array('group');

    private static $db = array(
    	'GroupID' => 'Varchar(255)'
    );

    public function getCMSFields(){
    	$fields = parent::getCMSFields();
    	$fields->addFieldToTab('Root.Main', TextField::create('GroupID', 'Beyond GruppID'), 'Title');
      
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
            ob_start();
            print_r($group->GruppenID);
                        print_r($data);
                        $result = ob_get_clean();
                        file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result,FILE_APPEND);
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
}