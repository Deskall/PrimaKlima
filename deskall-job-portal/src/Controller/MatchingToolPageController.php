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
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\View\Requirements;

class MatchingToolPageController extends PageController{

	private static $allowed_actions = ['MatchingToolForm','showMatch'];


	public function init(){
		parent::init();
		Requirements::javascript('deskall-job-portal/javascript/matchingtool.js');
	}
	
	public function MatchingToolForm(){

		$actions = new FieldList(FormAction::create('doMatch', _t('MatchingTool.SEARCH', 'Suchen'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="icon icon-checkmark uk-margin-small-right"></i>'. _t('MatchingTool.SEARCH', 'Suchen')));
		$JobGiver = JobGiver::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$fields = FieldList::create(
			$customer = HiddenField::create('OwnerID'),
			TextField::create('Compatibility',_t('MatchingTool.Compatibility','Kompatibilität (%)'))->setAttribute('class','uk-range')->setAttribute('type','range')->setAttribute('min',0)->setAttribute('max',100)->setAttribute('step',5),
			OptionsetField::create('4-Position',_t('MatchingTool.Position','Position'),JobParameter::get()->byId(4)->Values()->map('ID','Title'))
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
									$fields->push(DropdownField::create($subchild->ID.'-'.URLSegmentFilter::create()->filter($subchild->Title),$subchild->Title,$subchild->Values()->map('Title','Title'))->setAttribute('class','uk-select'));
									break;
								case "dropdown":
									$fields->push(DropdownField::create($subchild->ID.'-'.URLSegmentFilter::create()->filter($subchild->Title),$subchild->Title,$subchild->Values()->map('Title','Title'))->setAttribute('class','uk-select'));
									break;
								case "multiple":
									$fields->push(CheckboxSetField::create($subchild->ID.'-'.URLSegmentFilter::create()->filter($subchild->Title),$subchild->Title,$subchild->Values()->map('Title','Title')));
									break;
								case "multiple-free":
									$fields->push(ListboxField::create($subchild->ID.'-'.URLSegmentFilter::create()->filter($subchild->Title),$subchild->Title,$subchild->Values()->map('Title','Title')));
									break;
								case "range":
									$fields->push(TextField::create($subchild->ID.'-'.URLSegmentFilter::create()->filter($subchild->Title),$subchild->Title)->setAttribute('type','range')->setAttribute('class','uk-range')->setAttribute('min',$subchild->Min)->setAttribute('max',$subchild->Max)->setAttribute('step',1));
									break;
							}
						}
					}
					else{
						switch ($child->FieldType){
							case "text":
								$fields->push(DropdownField::create($child->ID.'-'.URLSegmentFilter::create()->filter($child->Title),$child->Title,$child->Values()->map('Title','Title'))->setAttribute('class','uk-select'));
								break;
							case "dropdown":
								$fields->push(DropdownField::create($child->ID.'-'.URLSegmentFilter::create()->filter($child->Title),$child->Title,$child->Values()->map('Title','Title'))->setAttribute('class','uk-select'));
								break;
							case "multiple":
								$fields->push(CheckboxSetField::create($child->ID.'-'.URLSegmentFilter::create()->filter($child->Title),$child->Title,$child->Values()->map('Title','Title')));
								break;
							case "multiple-free":
								$fields->push(ListboxField::create($child->ID.'-'.URLSegmentFilter::create()->filter($child->Title),$child->Title,$child->Values()->map('Title','Title')));
								break;
							case "range":
								$fields->push(TextField::create($child->ID.'-'.URLSegmentFilter::create()->filter($child->Title),$child->Title)->setAttribute('type','range')->setAttribute('class','uk-range')->setAttribute('min',$child->Min)->setAttribute('max',$child->Max)->setAttribute('step',1));
								break;
						}
					}
				}
			}
			else{
				switch ($group->FieldType){
					case "text":
						$fields->push(DropdownField::create($group->ID.'-'.URLSegmentFilter::create()->filter($group->Title),$group->Title,$group->Values()->map('Title','Title'))->setAttribute('class','uk-select'));
						break;
					case "dropdown":
						$fields->push(DropdownField::create($group->ID.'-'.URLSegmentFilter::create()->filter($group->Title),$group->Title,$group->Values()->map('Title','Title'))->setAttribute('class','uk-select'));
						break;
					case "multiple":
						$fields->push(CheckboxSetField::create($group->ID.'-'.URLSegmentFilter::create()->filter($group->Title),$group->Title,$group->Values()->map('Title','Title')));
						break;
					case "multiple-free":
						$fields->push(ListboxField::create($group->ID.'-'.URLSegmentFilter::create()->filter($group->Title),$group->Title,$group->Values()->map('Title','Title')));
						break;
					case "range":
						$fields->push(TextField::create($group->ID.'-'.URLSegmentFilter::create()->filter($group->Title),$group->Title)->setAttribute('type','range')->setAttribute('class','uk-range')->setAttribute('min',$group->Min)->setAttribute('max',$group->Max)->setAttribute('step',1));
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
		$this->getRequest()->getSession()->clear('query_id');

		try {
			//save query
			$query = new MatchingQuery();
			$form->saveInto($query);
			$query->write();
			$exclude = ['CustomerID','Compatibility','SecurityID','action_doMatch'];
			foreach ($data as $key => $value) {
				
				if (!in_array($key, $exclude)){
					$id = substr($key,0,strpos($key,'-'));
					$param = JobParameter::get()->byId($id);
					if ($param) {
						$queryP = new MatchingQueryParameter();
						$queryP->ParameterID = $param->ID;
						$queryP->Title = $param->Title;
						if (is_array($value)){
							$queryP->Value = implode(',',$value);
						}
						else{
							$queryP->Value = $value;
						}
						$queryP->write();
						$query->Parameters()->add($queryP);
					}
					
				}
			}
			//Generate Matches
			$query->getMatches();
			$this->getRequest()->getSession()->set('query_id',$query->ID);
			
		} catch (ValidationException $e) {
			$validationMessages = '';
			foreach($e->getResult()->getMessages() as $error){
				$validationMessages .= $error['message']."\n";
			}
			$form->sessionMessage($validationMessages, 'bad');
		}
		
		
		return $this->redirectBack();
	}

	public function activeQuery(){
		$id = $this->getRequest()->getSession()->get('query_id');
		
		if ($id){
			$query = MatchingQuery::get()->byId($id);
			return $query;
		}

		return null;
	}

	public function showMatch(HTTPRequest $request){
		$id = $request->postVar('resultId');
		if ($id){
			$result = MatchingResult::get()->byId($id);
			if ($result){
				$result->isVisible = true;
				$result->write();
				return $result->renderWith('Includes/MatchCard');
			}
		}
		return null;
	}
}