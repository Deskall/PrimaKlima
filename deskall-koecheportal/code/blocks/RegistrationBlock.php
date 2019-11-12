<?php
use DNADesign\Elemental\Models\BaseElement;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;


class RegistrationBlock extends BaseElement implements Searchable{
	private static $db = array(
		'MemberType' => 'Int',
		'Content'	 => 'HTMLText'
	);

	public function getCMSFields()	{
		$fields = parent::getCMSFields();

    	$fields->addFieldToTab('Root.Main',  DropdownField::create('MemberType', 'Registration für', array(
    		4 => 'Köche',
    		5 => 'Arbeitgeber',

    	))->setEmptyString('Köche & Arbeitgeber') );

       	$fields->addFieldToTab('Root.Main',  HTMLEditorField::create('Content', 'Beschreibung'));
		
		$this->extend('updateCMSFields', $fields);
		return $fields;
	}


	public function GetForm(){
		$page = new AccountPage_Controller();

		$form = $page->RegistrationForm( $this->MemberType );
		$form->setFormAction('/mein-koecheportal/RegistrationForm');

		return $form;
	}


}
