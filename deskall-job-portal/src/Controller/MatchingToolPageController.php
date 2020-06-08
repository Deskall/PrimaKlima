<?php

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Security\Security;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\ListboxField;

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

		foreach (ProfilParameter::get()->filter('ParentID',0) as $group) {
			$fields->push(HeaderField::create($group->ID,$group->Title,4));
			foreach ($group->children() as $child) {
				if ($child->isGroup){
					$fields->push(HeaderField::create($child->ID,$child->Title,6));
					foreach ($child->children() as $subchild) {
						switch ($subchild->FieldType){
							case "text":
								$fields->push(DropdownField::create($subchild->ID,$subchild->Title));
								break;
							case "dropdown":
								$fields->push(DropdownField::create($subchild->ID,$subchild->Title,$subchild->Values()->map('ID','Title')));
								break;
							case "multiple":
								$fields->push(CheckboxSetField::create($subchild->ID,$subchild->Title,$subchild->Values()->map('ID','Title')));
								break;
							case "multiple-free":
								$fields->push(ListboxField::create($subchild->ID,$subchild->Title,$subchild->Values()->map('ID','Title')));
								break;
							case "range":
								$fields->push(TextField::create($subchild->ID,$subchild->Title)->setAttribute('type','range'));
								break;
						}
					}
				}
				else{
					switch ($child->FieldType){
						case "text":
							$fields->push(DropdownField::create($child->ID,$child->Title));
							break;
						case "dropdown":
							$fields->push(DropdownField::create($child->ID,$child->Title,$child->Values()->map('ID','Title')));
							break;
						case "multiple":
							$fields->push(CheckboxSetField::create($child->ID,$child->Title,$child->Values()->map('ID','Title')));
							break;
						case "multiple-free":
							$fields->push(ListboxField::create($child->ID,$child->Title,$child->Values()->map('ID','Title')));
							break;
						case "range":
							$fields->push(TextField::create($child->ID,$child->Title)->setAttribute('type','range'));
							break;
					}
				}
			}
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