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
use SilverStripe\View\Parsers\URLSegmentFilter;

class MatchingToolPageController extends PageController{

	private static $allowed_actions = ['MatchingToolForm'];

	public function init(){
		parent::init();
	}

	
	public function MatchingToolForm(){

		$actions = new FieldList(FormAction::create('doMatch', _t('MatchingTool.SEARCH', 'Suchen'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="icon icon-checkmark uk-margin-small-right"></i>'. _t('MatchingTool.SEARCH', 'Suchen')));
		$JobGiver = JobGiver::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$fields = FieldList::create(
			$customer = HiddenField::create('CustomerID'),
			TextField::create('Compatibility',_t('MatchingTool.Compatibility','Kompatibilität (%)'))->setAttribute('class','uk-range')->setAttribute('type','range')->setAttribute('min',0)->setAttribute('max',100)->setAttribute('step',5)
		);

		foreach (ProfilParameter::get()->filter('ParentID',0) as $group) {
			$fields->push(HeaderField::create($group->ID,$group->Title,4));
			if ($group->isGroup) {
				foreach ($group->children() as $child) {
					if ($child->isGroup){
						$fields->push(HeaderField::create($child->ID,$child->Title,6));
						foreach ($child->children() as $subchild) {
							switch ($subchild->FieldType){
								case "text":
									$fields->push(DropdownField::create(URLSegmentFilter::create()->filter($subchild->Title),$subchild->Title,$subchild->Values()->map('ID','Title'))->setAttribute('class','uk-select'));
									break;
								case "dropdown":
									$fields->push(DropdownField::create(URLSegmentFilter::create()->filter($subchild->Title),$subchild->Title,$subchild->Values()->map('ID','Title'))->setAttribute('class','uk-select'));
									break;
								case "multiple":
									$fields->push(CheckboxSetField::create(URLSegmentFilter::create()->filter($subchild->Title),$subchild->Title,$subchild->Values()->map('ID','Title')));
									break;
								case "multiple-free":
									$fields->push(ListboxField::create(URLSegmentFilter::create()->filter($subchild->Title),$subchild->Title,$subchild->Values()->map('ID','Title')));
									break;
								case "range":
									$fields->push(TextField::create(URLSegmentFilter::create()->filter($subchild->Title),$subchild->Title)->setAttribute('type','range')->setAttribute('class','uk-range'));
									break;
							}
						}
					}
					else{
						switch ($child->FieldType){
							case "text":
								$fields->push(DropdownField::create(URLSegmentFilter::create()->filter($child->Title),$child->Title,$child->Values()->map('ID','Title'))->setAttribute('class','uk-select'));
								break;
							case "dropdown":
								$fields->push(DropdownField::create(URLSegmentFilter::create()->filter($child->Title),$child->Title,$child->Values()->map('ID','Title'))->setAttribute('class','uk-select'));
								break;
							case "multiple":
								$fields->push(CheckboxSetField::create(URLSegmentFilter::create()->filter($child->Title),$child->Title,$child->Values()->map('ID','Title')));
								break;
							case "multiple-free":
								$fields->push(ListboxField::create(URLSegmentFilter::create()->filter($child->Title),$child->Title,$child->Values()->map('ID','Title')));
								break;
							case "range":
								$fields->push(TextField::create(URLSegmentFilter::create()->filter($child->Title),$child->Title)->setAttribute('type','range')->setAttribute('class','uk-range'));
								break;
						}
					}
				}
			}
			else{
				switch ($group->FieldType){
					case "text":
						$fields->push(DropdownField::create(URLSegmentFilter::create()->filter($group->Title),$group->Title,$group->Values()->map('ID','Title'))->setAttribute('class','uk-select'));
						break;
					case "dropdown":
						$fields->push(DropdownField::create(URLSegmentFilter::create()->filter($group->Title),$group->Title,$group->Values()->map('ID','Title'))->setAttribute('class','uk-select'));
						break;
					case "multiple":
						$fields->push(CheckboxSetField::create(URLSegmentFilter::create()->filter($group->Title),$group->Title,$group->Values()->map('ID','Title')));
						break;
					case "multiple-free":
						$fields->push(ListboxField::create(URLSegmentFilter::create()->filter($group->Title),$group->Title,$group->Values()->map('ID','Title')));
						break;
					case "range":
						$fields->push(TextField::create(URLSegmentFilter::create()->filter($group->Title),$group->Title)->setAttribute('type','range')->setAttribute('class','uk-range'));
						break;
				}
			}
		}

		if ($JobGiver){
			$customer->setValue($JobGiver->ID);
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
		ob_start();
					print_r($data);
					$result = ob_get_clean();
					file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);

		try {
			//Algorythm
		} catch (ValidationException $e) {
			$validationMessages = '';
			foreach($e->getResult()->getMessages() as $error){
				$validationMessages .= $error['message']."\n";
			}
			$form->sessionMessage($validationMessages, 'bad');
			return $this->redirectBack();
		}
		
		
		return ['Matches' => true];
	}
}