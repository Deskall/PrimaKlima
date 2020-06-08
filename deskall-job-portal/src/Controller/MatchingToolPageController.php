<?php

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Security\Security;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;

class MatchingToolPageController extends PageController{

	private static $allowed_actions = ['MatchingToolForm'];

	public function init(){
		parent::init();
	}

	
	public function MatchingToolForm(){

		$actions = new FieldList(FormAction::create('doMatch', _t('MatchingTool.SEARCH', 'Suchen'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="icon icon-checkmark uk-margin-small-right"></i>'. _t('MatchingTool.SEARCH', 'Suchen')));
		$JobGiver = JobGiver::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$fields = FieldList::create(
			HiddenField::create('Compatibility')->setValue(0.5),
			HiddenField::create('CustomerID')->setValue($JobGiver->ID)
		);

		foreach (ProfilParameter::get() as $param) {
			$fields->push(DropdownField::create($param->ID,$param->Title,$param->Children()->map('ID','Title')));
		}

		$form = new Form(
			$this,
			'MatchingToolForm',
			$fields,
			$actions
		);
		
		$form->setTemplate('Forms/MatchingToolForm');
		$form->addExtraClass('uk-form-horizontal form-std');

		return $form;
	}

	public function doMatch($data, Form $form){
	
		try {
			
		} catch (ValidationException $e) {
			$validationMessages = '';
			foreach($e->getResult()->getMessages() as $error){
				$validationMessages .= $error['message']."\n";
			}
			$form->sessionMessage($validationMessages, 'bad');
			return $this->redirectBack();
		}
		
		
		return $this->redirectBack();
	}
}