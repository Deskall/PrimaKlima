<?php

use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class MenuLink extends LayoutLink{

	private static $has_many = [
		'Children' => MenuLink::class
	];

	private static $has_one = [
		'Parent' => MenuLink::class,
		'Block' => MenuBlock::class
	];

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('ParentID');
		$fields->removeByName('BlockID');
		if ($this->ID > 0){
			$fields->fieldByName('Root.Children.Children')->getConfig()->addComponent(new GridFieldOrderableRows('Sort'));
		}

		return $fields;
	}

	public function getLevel(){
		$i = 1;
		$parent = $this;
		while ($parent->ParentID > 0){
			$parent = $parent->Parent();
			$i++;
		}
		return $i;
	}

}
