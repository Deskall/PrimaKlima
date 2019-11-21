<?php

use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField;

class GridFieldOpenInvoice implements GridField_ColumnProvider, GridField_ActionProvider {
	/**
	 * {@inheritDoc}
	 */
	public function augmentColumns($gridField, &$columns) {
		if (!in_array('buttonInvoice', $columns)) {
			$columns[] = 'buttonInvoice';
			$columns = array(
				'generateOrderNumber',
				'Employer.Company',

				'Title',
				'Created.Nice',
				'buttonInvoice',
				'isPaid2',
				'Actions',
			);
		}
	}
	/**
	 * {@inheritDoc}
	 */
	public function getColumnAttributes($gridField, $record, $columnName){
		return array('class' => 'col-buttons');
	}
	/**
	 * {@inheritDoc}
	 */
	public function getColumnMetadata($gridField, $columnName){
		if ($columnName == 'buttonInvoice') {
			return array('title' => 'Bezahlt');
		}
	}
	/**
	 * {@inheritDoc}
	 */
	public function getColumnsHandled($gridField){
		return array('buttonInvoice');
	}
	/**
	 * {@inheritDoc}
	 */
	public function getColumnContent($gridField, $record, $columnName){
		return '<a class="action action-detail edit-link open-invoice" data-open-invoice href="/order/invoice/51" target="_blank" title="Rechnung"></a>';



	}
	/**
	 * {@inheritDoc}
	 */
	public function getActions($gridField){
		return array();
	}

	/**
	 * {@inheritDoc}
	 */
	public function handleAction(GridField $gridField, $actionName, $arguments, $data){

		$item = $gridField->getList()->byID($arguments['RecordID']);
		if (!$item) {
			return;
		}

	}
}