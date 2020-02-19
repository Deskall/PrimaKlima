<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Folder;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\DB;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\Forms\GridField\GridFieldPrintButton;

class TVOfferAdmin extends ModelAdmin{

	private static $menu_icon_class = "font-icon-monitor";
	private static $url_segment = "tv-offer";
	private static $menu_title = "TV Angebote";
	
	private static $managed_models = [
		'TVOffer' => [
			'title' => 'TV Angebote'
		]
	];

	

	public function getEditForm($id = null, $fields = null) {
	    $form = parent::getEditForm($id, $fields);
	   

	    return $form;
	}

	public function getList(){
		$list = parent::getList();
		
		return $list;
	}

	public static function getFileDelimiter($file, $checkLines = 2){
	    $file = new SplFileObject($file);
	    $delimiters = array(
	        ',',
	        '\t',
	        ';',
	        '|',
	        ':'
	    );
	    $results = array();
	    $i = 0;
	    while($file->valid() && $i <= $checkLines){
	        $line = $file->fgets();
	        foreach ($delimiters as $delimiter){
	            $regExp = '/['.$delimiter.']/';
	            $fields = preg_split($regExp, $line);
	            if(count($fields) > 1){
	                if(!empty($results[$delimiter])){
	                    $results[$delimiter]++;
	                } else {
	                    $results[$delimiter] = 1;
	                }   
	            }
	        }
	        $i++;
	    }
	    $results = array_keys($results, max($results));
	    return $results[0];
	}

}