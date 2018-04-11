<?php

use SilverStripe\ORM\DataExtension;


class DeskallFormFieldExtension extends DataExtension{
	public function ShowLabels(){
		return $this->owner->form->Controller->record['ShowLabels'];
	}
}