<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\Security\Security;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\FieldType\DBHTMLText;

class EmployerAdvertisement extends DataObject{

	private static $db = array(
		'Title' => 'Varchar(255)',
		'StartDate' => 'Date',
		'EndDate' => 'Date',
		'JobOfTheWeekdEndDate' => 'Date',
		'isActive' => 'Boolean',
		'ContentIntro' => 'Text',
		'ContentTitle' => 'Text',
		'ContentMain' => 'HTMLText',
		'State' => 'Varchar(255)',
		'isPaid' => 'Boolean',
	);


	private static $has_one = array(
		'Employer' => 'Employer',
		'Picture'  => Image::class,
		'Package'  => 'Package',
	);

	private static $many_many = array(
		'Attachements' => 'File',
	);
	private static $many_many_extraFields = array(
		'Attachements' => array('SortOrder' => 'Int')
	);

	private static $defaults = array(
		'ContentIntro' => 'Zur Untersützung unseres Teams suchen wir einen/eine',
		'State' => 'draft'
	);

	private static $default_sort = "Created DESC";


	private static $summary_fields = array(
		'Title' => 'Inserat',
		'NiceDuration' => 'Schaltungsdauer',
		'NiceState' => 'Status',
	);


	public function NiceState(){
		$o = new DBHTMLText();
		
		if( $this->State =='live' ){
			$o->setValue('<span data-live>Freigeschaltet</span>');
		}else{
			$o->setValue('<span>Entwurf</span>');
		}
		return $o;
	}


	public function NiceDuration(){

		if( $this->StartDate ){
			$str = 'Vom '.date('d.m.Y', strtotime($this->StartDate));
		}else{
			$str = '';
		}

		if( $this->EndDate ){
			$str .= ' bis zum '.date('d.m.Y', strtotime($this->EndDate));
		}
		return $str;
	}



	private static $singular_name = 'Inserat';

	private static $plural_name = 'Inserate';



	public function getCMSFields() {
		$fields = new FieldList();
		$fields->push(new TabSet('Root'));

		$fields->addFieldToTab('Root.Angaben', TextField::create('Title', _t('INSERAT.AdTitle', 'Arbeitstitel (Für den internen Gebrauch)') ) );	

		$fields->addFieldToTab('Root.Angaben', DateField::create('StartDate', _t('INSERAT.StartDate', 'Schaltung von') )->setConfig('dateformat', 'dd.MM.YYYY')->setConfig('showcalendar', true) );	
		$fields->addFieldToTab('Root.Angaben', DateField::create('EndDate', _t('INSERAT.EndDate', 'bis') )->setConfig('dateformat', 'dd.MM.YYYY')->setConfig('showcalendar', true) );	

		$fields->addFieldToTab('Root.Angaben', CheckboxField::create('isPaid', _t('INSERAT.isPaid', 'Ist bezahlt') ) );	
		$fields->addFieldToTab('Root.Angaben', CheckboxField::create('isActive', _t('INSERAT.isActive', 'Ist aktiv') ) );	

		$fields->addFieldToTab('Root.Angaben', DropdownField::create('State', _t('INSERAT.State', 'Status') , array(
			'draft' => _t('INSERAT.Draft', 'Entwurf'),
			'live' => _t('INSERAT.Live', 'Freigeschaltet'),
		)));


		$fields->addFieldToTab('Root.Inserateinhalt', UploadField::create('Picture', _t('INSERAT.Picture', 'Bild'))->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif') ));
		$fields->addFieldToTab('Root.Inserateinhalt', TextareaField::create('ContentIntro', _t('INSERAT.ContentIntro', 'Einleitung') ) );
		$fields->addFieldToTab('Root.Inserateinhalt', TextareaField::create('ContentTitle', _t('INSERAT.ContentTitle', 'Position') )->setRows(2) );		
		$fields->addFieldToTab('Root.Inserateinhalt', HTMLEditorField::create('ContentMain', _t('INSERAT.ContentMain', 'Inhalt') ) );		

		$fields->addFieldToTab('Root.Anhänge', SortableUploadField::create('Attachements', _t('INSERAT.Attachements', 'Anhänge') ) );	

		return $fields;
	}


// 	public function getFrontEndFields( $params = NULL ) {
// 		$fields = new FieldList();

// 		$fields->push(new TabSet('Root'));
// 		Requirements::javascript('framework/thirdparty/jquery/jquery.js');
// 		Requirements::javascript('framework/thirdparty/jquery-entwine/dist/jquery.entwine-dist.js');
// 		Requirements::javascript('betterbuttons/javascript/gridfield_betterbuttons.js');
// 		Requirements::javascript("themes/koecheportal/js/tinymce/tinymce.min.js");
// 		Requirements::javascript('themes/koecheportal/js/moment.js');
// 		Requirements::javascript('themes/koecheportal/js/dialog.js');

// 		Requirements::javascript('themes/koecheportal/js/advertisement-dialog.js');
//         Requirements::css("themes/koecheportal/css/dialog.css");

// 		$AdString = '<h3>'.$this->Title.'</h3>';
// 		$AdString .= '<p class="ad-info">Schaltung vom '.date('d.m.Y', strtotime($this->StartDate)).' bis zum '.date('d.m.Y', strtotime($this->EndDate)).'</p>';


// 		if( $this->ContentIntro ){
// 			$AdString .= '<p>'.$this->ContentIntro.'</p>';
// 		}

// 		if( $this->ContentTitle ){
// 			$AdString .= '<h1>'.$this->ContentTitle.'</h1>';
// 		}

// 		if( $this->PictureID ){
// 			$AdString .= '<img src="'.$this->Picture()->URL.'" class="preview-img" />';
// 		}

// 		if( $this->ContentMain ){
// 			$AdString .= $this->ContentMain;
// 		}

//         if( $this->State == 'live' ){
// 			$fields->addFieldToTab('Root.Ansicht', LiteralField::create('Prev',  '<div class="ad-preview" data-live>'.$AdString.'</div>')  );	

//         }else{


// 			$fields->addFieldToTab('Root.Angaben', TextField::create('Title', _t('INSERAT.AdTitle', 'Arbeitstitel (Für den internen Gebrauch)') ) );	

// 			if( $this->EmployerID > 0 ){
// 				$member = $this->Employer();
// 			}else{
// 				$member = Security::getCurrentUser();
// 			}


// 			if( strtotime($member->FlatrateEndDate) >= time()  ){
// 				$fields->addFieldToTab('Root.Angaben', DateField::create('StartDate', _t('INSERAT.StartDate', 'Schaltung von') )->setConfig('dateformat', 'dd.MM.YYYY')->setConfig('showcalendar', true) );
// 				$fields->addFieldToTab('Root.Angaben', DateField::create('EndDate', _t('INSERAT.EndDate', 'bis') )->setConfig('dateformat', 'dd.MM.YYYY')->setConfig('showcalendar', true)->setValue( $member->FlatrateEndDate) );   
			
// //				$fields->addFieldToTab('Root.Angaben', DropdownField::create('State', _t('INSERAT.State', 'Status') , array(
// //					'draft' => _t('INSERAT.Draf', 'Entwurf'),
// //					'live' => _t('INSERAT.Draf', 'Freigeschaltet'),
// //				)));   	

// 				$fields->addFieldToTab('Root.Angaben', HiddenField::create('State'));
// 				$fields->addFieldToTab('Root.Angaben', LiteralField::create('ReadOnlyState', '
// <div id="Form_ItemEditForm_EndDate_Holder" class="field date text">
// 	<label class="left" for="Form_ItemEditForm_EndDate">Status</label>
// 	<div class="middleColumn">
// 		<span>'.$this->NiceState().'</span>
// 	</div>
// </div>
// <button data-publish-advertisement class="btn-publish-advertisement">Inserat jetzt Freischalten</button>
// <p class="go-live-comment">'._t('INSERAT.GoLive', 'Achtung: nach der Freischaltung sind keine Änderungen mehr möglich.').'</p>'));





			

// 			}else{

// 				if( sizeof( $member->Credits() ) > 0  ){
// 					$fields->addFieldToTab('Root.Angaben', $df = DateField::create('StartDate', _t('INSERAT.StartDate', 'Schaltung von') )->setConfig('dateformat', 'dd.MM.YYYY')->setConfig('showcalendar', true)->setAttribute('data-duration', $member->Credits()->First()->RunTime )->setAttribute('data-duration-currency', $member->Credits()->First()->RunTimeCurrency ) );				
					

// 					if(  $this->EndDate ){
// 						$df->setAttribute('data-end-date', date('d.m.Y', strtotime($this->EndDate) ) );
// 					}

// //					$fields->addFieldToTab('Root.Angaben', DropdownField::create('State', _t('INSERAT.State', 'Status') , array(
// //						'draft' => _t('INSERAT.Draft', 'Entwurf'),
// //						'live' => _t('INSERAT.Live', 'Freigeschaltet'),
// //					)));


// 				$fields->addFieldToTab('Root.Angaben', HiddenField::create('State'));
// 				$fields->addFieldToTab('Root.Angaben', LiteralField::create('ReadOnlyState', '
// <div id="Form_ItemEditForm_EndDate_Holder" class="field date text">
// 	<label class="left" for="Form_ItemEditForm_EndDate">Status</label>
// 	<div class="middleColumn">
// 		<span>'.$this->NiceState().'</span>
// 	</div>
// </div>
// <button data-publish-advertisement class="btn-publish-advertisement">Inserat jetzt Freischalten</button>
// <p class="go-live-comment">'._t('INSERAT.GoLive', 'Achtung: nach der Freischaltung sind keine Änderungen mehr möglich.').'</p>'));








// 				}
// 			}

// 			$fields->addFieldToTab('Root.Inserateinhalt', LiteralField::create('ContentDescription', '<p>Hier können Sie Ihr Inserat erstellen. Füllen Sie dazu einfach die Felder aus, fügen Sie unter «Inhalt» Ihren Inserat-Text ein und schmücken Sie Ihr Inserate mit einem aussagekräftigen Bild.</p>'));
// 			$fields->addFieldToTab('Root.Inserateinhalt', FileAttachmentField::create('Picture', _t('ARBEITGEBER.Picture', 'Bild'))
// 						->setThumbnailHeight(100)
// 						->setThumbnailWidth(100)
// 						->setPermissions(array(
// 							'delete' => false,
// 							'detach' => true)));

// 			$fields->addFieldToTab('Root.Inserateinhalt', TextareaField::create('ContentIntro', _t('INSERAT.ContentIntro', 'Einleitung') ) );
// 			$fields->addFieldToTab('Root.Inserateinhalt', TextareaField::create('ContentTitle', _t('INSERAT.ContentTitle', 'Position') )->setRows(2) );		
// 			$fields->addFieldToTab('Root.Inserateinhalt', TextareaField::create('ContentMain', _t('INSERAT.ContentMain', 'Inhalt') )->setAttribute('data-tinymce', true) );	

// 			$fields->addFieldToTab('Root.Anhänge', FileAttachmentField::create('Attachements', _t('INSERAT.Attachements', 'Anhänge'))
// 				->setThumbnailHeight(100)
// 				->setThumbnailWidth(100)
// 				->setMultiple(true)
// 				->setAcceptedFiles(array('.pdf','.doc','.docx'))
// 				->setPermissions(array(
// 					'delete' => false,
// 					'detach' => true)));

// 			$fields->addFieldToTab('Root.Vorschau', LiteralField::create('Prev2',  '<div class="ad-preview">'.$AdString.'</div>')  );	
//         }
// 		return $fields;
// 	}	

	public function ApplicationForm(){
		$page = new Application_Controller();
		$form = $page->ApplicationForm( Security::getCurrentUser()->ID, $this->ID );
		$form->setFormAction('/application/ApplicationForm');
		return $form;
	}


	public function onBeforeWrite(){
		parent::onBeforeWrite();

		if( $this->EmployerID > 0 ){
			$member = $this->Employer();
		}else{
			$member = Security::getCurrentUser();
		}

		// auto set end date for non-flatrate ads
		if( $this->StartDate && strtotime($member->FlatrateEndDate) < time() && sizeof( $member->Credits() ) ){
			$date = new \DateTime($this->StartDate);
			$date->modify("+".$member->GetAdDuration());
			$this->EndDate = $date->format("Y-m-d");
		}

		// set ad to live mode
		if( $this->State == 'live' && !$this->isPaid ){
			if( strtotime($member->FlatrateEndDate) >= time()  ){
				$this->PackageID = 3;
				if( !$this->EndDate ){
					$this->EndDate =$member->FlatrateEndDate;	
				}
				
				$this->isPaid = true;
			}else{
				$this->PackageID = $member->Credits()->Sort('PackageID DESC')->First()->PackageID;
				$member->Credits()->Sort('PackageID DESC')->First()->delete();
				$this->isPaid = true;


			}
		}	
	}







	public function canView( $member = NULL ){
		return true;
	}

	public function canEdit( $member = NULL ){
		return true;
	}


	public function canDelete( $member = NULL ){
		return true;
	}

	public function canCreate( $member = NULL , $context = array()){
		return true;
	}

	public function canPublish( $member = NULL ){
		return true;
	}

	public function canUnpublish( $member = NULL ){
		return true;
	}


}