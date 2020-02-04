<?php
/**
 * Shop Finder block with map
 * @author Deskall
 */
class ShopFinderBlock extends TextBlock
{

    private static $icon = 'font-icon-block-content';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $help_text = "Shop Finder Block";

    private static $table_name = 'ShopFinderBlock';

    private static $singular_name = 'Shop Finder Block';

    private static $plural_name = 'Shop Finder Blöcke';

    private static $description = 'Shop Liste mit Map und Suchformular';


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
    
    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Shop Liste mit Map und Suchformular');
    }

    
}
