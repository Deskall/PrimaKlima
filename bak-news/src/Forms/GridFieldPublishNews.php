<?php

namespace Bak\News\Forms;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Control\Controller;

class GridFieldPublishNews implements GridField_ColumnProvider, GridField_ActionProvider {
	/**
	 * {@inheritDoc}
	 */
	public function augmentColumns($gridField, &$columns) {
		if (!in_array('Actions', $columns)) {
			$columns[] = 'Actions';
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
		if ($columnName == 'Actions') {
			return array('title' => '');
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function getColumnsHandled($gridField){
		return array('Actions');
	}

	/**
	 * {@inheritDoc}
	 */
	public function getColumnContent($gridField, $record, $columnName){
		if (!$record->canEdit()) {
			return;
		}
		if ($record->Status != "Published"){
			$field = GridField_FormAction::create(
				$gridField, 'Veröffentlichen' . $record->ID, false, "Publish", array('RecordID' => $record->ID)
				)
				->addExtraClass('gridfield-button-publish')
				->setAttribute('title', _t('SiteTree.BUTTONPUBLISH', 'Veröffentlichen'))
				->setAttribute('data-icon', 'accept_disabled')
				->setDescription(_t('News.BUTTONPUBLISHDESC', 'Veröffentlichen'));
				return $field->Field();
		}
		else{
			$field = GridField_FormAction::create(
					$gridField, 'Archivieren' . $record->ID, false, "archive", array('RecordID' => $record->ID)
				)
				->addExtraClass('gridfield-button-archive')
				->setAttribute('title', _t('SiteTree.BUTTONARCHIVE', 'Archivieren'))
				->setAttribute('data-icon', 'accept')
				->setDescription(_t('News.BUTTONARCHIVEDESC', 'Archivieren'));
				return $field->Field();
		}

	}

	/**
	 * {@inheritDoc}
	 */
	public function getActions($gridField){
		return array('publish', 'archive');
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
			case "publish":
				$item->doPublish();
				break;
			case "archive": 
				$item->doArchive();
				break;
		}
	}
}