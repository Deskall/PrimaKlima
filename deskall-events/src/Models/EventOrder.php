<?php



class EventOrder extends ShopOrder{

	private static $has_one = ['Event' => EventDate::class];

}




