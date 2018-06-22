<?php
/**
 * A custom grid field request handler that allows interacting with form fields when adding records.
 */

use SilverStripe\Forms\GridField\GridFieldDetailForm_ItemRequest;
use SilverStripe\Control\Controller;

class GridFieldLinkBlockHandler extends GridFieldDetailForm_ItemRequest {

	public function Link($action = null) {
		// if($this->record->ID) {
		// 	return parent::Link($action);
		// } else {
			return Controller::redirectBack();
		//}
	}

}
