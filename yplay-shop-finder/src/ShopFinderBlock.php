<?php
/**
 * Shop Finder block with map
 * @author Deskall
 */
class ShopFinderBlock extends Block
{
	private static $db = array(
		'Content' => 'HTMLText'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$tinyMce = HtmlEditorField::create('Content', _t('TextBlock.CONTENT', 'Content'));
		$fields->addFieldToTab('Root.Main', $tinyMce);

		$this->extend('updateCMSFields', $fields);
		return $fields;
	}

	public function Shops(){
		return Shop::get();
	}

	public function JsonShops(){
		$shops = Shop::get();
		$array = array();
		foreach ($shops as $shop) {
			$array[$shop->ID] = $shop->toMap();
			$array[$shop->ID]['Content'] = $shop->getInfoWindow();
		}

		return json_encode($array);
	}

	
}

