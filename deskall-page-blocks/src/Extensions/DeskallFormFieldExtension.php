<?php

use SilverStripe\ORM\DataExtension;


class DeskallFormFieldExtension extends DataExtension{
	public function ShowLabels(){
		print_r($this->form->Controller->data());
		return $this->form->Controller->data()->ShowLabels;
	}
}