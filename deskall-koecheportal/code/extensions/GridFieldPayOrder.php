<?php

use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Control\Controller;

class GridFieldPayOrder implements GridField_ColumnProvider, GridField_ActionProvider {
	/**
	 * {@inheritDoc}
	 */
	public function augmentColumns($gridField, &$columns) {
		if (!in_array('isPaid2', $columns)) {
			$columns[] = 'isPaid2';
			$columns = array(
				'generateOrderNumber',
				'Employer.Company',

				'Title',
				'Created.Nice',
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
		if ($columnName == 'isPaid2') {
			return array('title' => 'Bezahlt');
		}
	}
	/**
	 * {@inheritDoc}
	 */
	public function getColumnsHandled($gridField){
		return array('isPaid2');
	}
	/**
	 * {@inheritDoc}
	 */
	public function getColumnContent($gridField, $record, $columnName){
		if( $record->isPaid ){

			return '<button type="submit" class="action gridfield-button-active nolabel ss-ui-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" id="action_Aktivieren31" title="Rechnung ist bezahlt" data-icon="accept" ><span class="ui-button-icon-primary ui-icon btn-icon-accept"></span><span class="ui-button-text"></span></button>';
		}else{

			$field = GridField_FormAction::create(
				$gridField, 'Bezahlung bestätigen' . $record->ID, false, "confirmPayment", array('RecordID' => $record->ID)
				)
				->addExtraClass('gridfield-button-active')
				->setAttribute('title', _t('SiteTree.BUTTONACTIVE', 'Bezahlung bestätigen'))
				->setAttribute('data-icon', 'accept_disabled')
				->setDescription(_t('News.BUTTONACTIVEDESC', 'Bezahlung bestätigen'));
				return $field->Field();

		}
	}
	/**
	 * {@inheritDoc}
	 */
	public function getActions($gridField){
		return array('confirmPayment');
	}

	/**
	 * {@inheritDoc}
	 */
	public function handleAction(GridField $gridField, $actionName, $arguments, $data){

		$item = $gridField->getList()->byID($arguments['RecordID']);
		if (!$item) {
			return;
		}

		switch($actionName){
			case "confirmpayment": 


				$item->confirmPayment();


				Controller::curr()->getResponse()->setStatusCode(
					200,
					'OK.'
				);
				break;
		}
	}
}