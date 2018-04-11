<?php

use SilverStripe\ORM\DataExtension;


class DeskallFormFieldExtension extends DataExtension{
	public function ShowLabels(){
		print_r($this->owner->form->Controller->data());
		return $this->owner->form->Controller->data()->ShowLabels;
	}
}