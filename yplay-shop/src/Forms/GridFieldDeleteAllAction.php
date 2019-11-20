<?php

use SilverStripe\Forms\GridField\GridField_HTMLProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Forms\GridField\GridField;

class GridFieldDeleteAllAction implements GridField_HTMLProvider, GridField_ActionProvider {



	/**
	 * Fragment to write the button to
	 */
	protected $targetFragment;

	/**
	 * @param string $targetFragment The HTML fragment to write the button into
	 * @param array $exportColumns The columns to include in the export
	 */
	public function __construct($targetFragment = "after") {
		$this->targetFragment = $targetFragment;
	}

	/**
	 * Place the export button in a <p> tag below the field
	 */
	public function getHTMLFragments($gridField) {
		$button = new GridField_FormAction(
			$gridField,
			'deleteAll',
			_t('TableListField.DeleteAll', 'Alle Einträge löschen'),
			'deleteAll',
			null
		);
		$button->setAttribute('data-icon', 'cross-circle');
		$button->addExtraClass('btn action btn-outline-danger');
		$button->setForm($gridField->getForm());
		return array(
			$this->targetFragment => '<p class="grid-csv-button">' . $button->Field() . '</p>',
		);
	}

	/**
	 * export is an action button
	 */
	public function getActions($gridField) {
		return array('deleteAll');
	}

	public function handleAction(GridField $gridField, $actionName, $arguments, $data) {
		foreach($gridField->getList() as $item){
			if ($item->canDelete()){
				$item->delete();
			}
		}

	}



	
}
