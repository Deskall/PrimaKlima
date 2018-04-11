<?php

use SilverStripe\ORM\DataExtension;


class DeskallFormFieldExtension extends DataExtension{
	public function ShowLabels(){
		print_r($this->owner->form->Controller->record['ShowLabels']);
		return $this->owner->form->Controller->data()->record['ShowLabels'];
	}
}