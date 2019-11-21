<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Folder;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\DB;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class UserAdmin extends ModelAdmin{
	private static $menu_icon;
	private static $url_segment;
	
	private static $managed_models = [
		'Cook' => [
			'title' => 'Köche'
		],
		'CookJob' => [
			'title' => 'Küche Beruf'
		],
		'CookType' => [
			'title' => 'Küche Art'
		],
		'Mission' => [
			'title' => 'Aufträge'
		],
		'Customer' => [
			'title' => 'Kunden'
		],
		'CookConfig' => [
			'title' => 'Einstellungen'
		],
		'CustomEmail' => [
			'title' => 'Custom E-Mails'
		],
		'AutoEmail' => [
			'title' => 'Automatizierte E-Mails'
		]
	];

	public function getList(){
		$list = parent::getList();

		 if($this->modelClass == 'Cook'){
		 	$list = $list->exclude('Member.NeedsValidation',1);
		 	
			// $cooks = CustomUser::get();
		 //  	foreach ($cooks as $cook) {
		 //  		$newCook = new Cook();
		 //  		$newCook->update($cook->toMap());
		 //  		$newCook->ClassName = 'Cook';
		 //  		if ($cook->Gender == "Sir"){
		 //  			$newCook->Gender = "Herr";
		 //  		}
		 //  		if ($cook->Gender == "Miss"){
		 //  			$newCook->Gender = "Frau";
		 //  		}
		 //  		$newCook->MemberID = $cook->ID;
		 //  		$hasOne = ['Picture','CV','Licence','HACCPCertificat','Ausweis','A1Form','TaxResidenceCertificat'];
		  		
		 //  		$newCook->{"Picture"."ID"} = $cook->PictureID;
		 //  		$newCook->{"CV"."ID"} = $cook->CVID;
		 //  		$newCook->{"Licence"."ID"} = $cook->LicenceID;
		 //  		$newCook->{"HACCPCertificat"."ID"} = $cook->HACCPCertificatID;
		 //  		$newCook->{"Ausweis"."ID"} = $cook->AusweisID;
		 //  		$newCook->{"A1Form"."ID"} = $cook->A1FormID;
		 //  		$newCook->{"TaxResidenceCertificat"."ID"} = $cook->TaxResidenceCertificatID;
		  		
		 //  		$newCook->Files()->addMany($cook->Files());
		 //  		$newCook->Jobs()->addMany($cook->Jobs());
		 //  		$newCook->Categories()->addMany($cook->Categories());

		 //  		$newCook->isApproved = 1;
		 //  		$newCook->write();
		 //  	}
		  }

		  if($this->modelClass == 'Customer'){

		   	
		  }
		
		return $list;
	}


	public function getEditForm($id = null, $fields = null) {
	    $form = parent::getEditForm($id, $fields);

	    if($this->modelClass == 'Cook' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
	        if($gridField instanceof GridField) {
	           $gridField->getConfig()->addComponent(new GridFieldApproveAction());
	        }
	       
	        // foreach (CustomUser::get() as $cook) {
	        // 	foreach($cook->Files() as $file){
	        // 		$file->File->deleteFile();
	        //         DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($file->ID));
	        //         $file->delete();
	        //     }
	        //     $cook->Files()->removeAll();
	        // 	$cook->write();
	        // }

	        //Import Cook
	        	// $file = File::get()->byId(343);
	        	// $rootpath = $_SERVER['DOCUMENT_ROOT']."/files/";
	        	// if(($handle = fopen($file->getAbsoluteURL(), "r")) !== FALSE) {
	        	// 	$delimiter = self::getFileDelimiter($file->getAbsoluteURL());
	        	// 	$headers = fgetcsv($handle, 0, $delimiter);
	        	// 	while (($line = fgetcsv($handle,0,$delimiter)) !== FALSE) {
	        	// 		$cook = CustomUser::get()->filter('oldID',$line[75])->first();
	        	// 		if ($cook){
	        	// 			$folder = Folder::find_or_make($cook->generateFolderName());
	        	// 			if ($line[30] != ""){
	        	// 				//search file
	        	// 				if (file_exists($rootpath.$line[30])){
	        	// 					$file = new File();
	        	// 					$file->ParentID = $folder->ID;
	        	// 					$file->setFromLocalFile($rootpath.$line[30],$cook->generateFolderName()."/".basename($rootpath.$line[30]));
	        	// 					$file->write();
	        	// 					$file->publishSingle();
	        	// 					$cook->Files()->add($file);
	        	// 				}
	        	// 			}
	        	// 			if ($line[31] != ""){
	        	// 				//search file
	        	// 				if (file_exists($rootpath.$line[31])){
	        	// 					$file = new File();
	        	// 					$file->ParentID = $folder->ID;
	        	// 					$file->setFromLocalFile($rootpath.$line[31],$cook->generateFolderName()."/".basename($rootpath.$line[31]));
	        	// 					$file->write();
	        	// 					$file->publishSingle();
	        	// 					$cook->Files()->add($file);
	        	// 				}
	        	// 			}
	        	// 			if ($line[32] != ""){
	        	// 				//search file
	        	// 				if (file_exists($rootpath.$line[32])){
	        	// 					$file = new File();
	        	// 					$file->ParentID = $folder->ID;
	        	// 					$file->setFromLocalFile($rootpath.$line[32],$cook->generateFolderName()."/".basename($rootpath.$line[32]));
	        	// 					$file->write();
	        	// 					$file->publishSingle();
	        	// 					$cook->Files()->add($file);
	        	// 				}
	        	// 			}
	        	// 			if ($line[33] != ""){
	        	// 				//search file
	        	// 				if (file_exists($rootpath.$line[33])){
	        	// 					$file = new File();
	        	// 					$file->ParentID = $folder->ID;
	        	// 					$file->setFromLocalFile($rootpath.$line[33],$cook->generateFolderName()."/".basename($rootpath.$line[33]));
	        	// 					$file->write();
	        	// 					$file->publishSingle();
	        	// 					$cook->Files()->add($file);
	        	// 				}
	        	// 			}
	        	// 			if ($line[34] != ""){
	        	// 				//search file
	        	// 				if (file_exists($rootpath.$line[34])){
	        	// 					$file = new File();
	        	// 					$file->ParentID = $folder->ID;
	        	// 					$file->setFromLocalFile($rootpath.$line[34],$cook->generateFolderName()."/".basename($rootpath.$line[34]));
	        	// 					$file->write();
	        	// 					$file->publishSingle();
	        	// 					$cook->Files()->add($file);
	        	// 				}
	        	// 			}
	        	// 			$cook->write();
	        	// 		}
	        	// 	}
	        	// }
	        	// fclose($handle);
	    }
	    if($this->modelClass == 'Mission' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
	        if($gridField instanceof GridField) {
	           $gridField->getConfig()->addComponent(new GridFieldStatusAction())->addComponent(new GridFieldShowHideAction());
	        }
	    }

	    return $form;
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