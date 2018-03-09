<?php
/**
 * A custom grid field request handler that allows interacting with form fields when adding records.
 */
class GridFieldDuplicateBlockHandler extends GridFieldDetailForm_ItemRequest {

	public function Link($action = null) {
		// if($this->record->ID) {
		// 	return parent::Link($action);
		// } else {
			return Controller::redirectBack();
		//}
	}

}
