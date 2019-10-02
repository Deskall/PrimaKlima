<?php

use SilverStripe\ORM\DataObject;

class Product extends DataObject {
	private static $db = [
	'ProductCode' => 'Varchar',
	'Title' => 'Varchar',
	'Price' => 'Currency',
	'Unit' => 'Varchar',
	'Subtitle' => 'Text',
	'Description' => 'HTMLText'
	];

	private static $has_one = [
		'Category' => ProductCategory::class
	];

	private static $extensions = [
		'Sortable',
		'Activable'
	];
}