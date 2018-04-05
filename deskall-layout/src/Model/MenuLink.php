<?php


class MenuLink extends LayoutLink{

	private static $has_many = [
		'Children' => 'MenuLink'
	];

}
