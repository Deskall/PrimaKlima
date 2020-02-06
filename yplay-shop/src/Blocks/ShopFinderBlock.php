<?php
/**
 * Shop Finder block with map
 * @author Deskall
 */

use g4b0\SearchableDataObjects\Searchable;

class ShopFinderBlock extends TextBlock implements Searchable
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

    /************* SEARCHABLE FUNCTIONS ******************/

        /**
         * Fields that compose the Content
         * eg. array('Teaser', 'Content');
         * @return array
         */
        public function getContentFields() {
            return array('HTML','ShopsContent');
        }

        public function getShopsContent(){
            $html = '';
            $shops = Shop::get();
            if ($shops->count() > 0){
                $html .= '<ul>';
                foreach ($shops as $item) {
                    $html .= '<li>';
                    $html .= $item->Title.' '.$item->AdresseTitle.' '.$item->Adresse.', '.$item->PLZ.' - '.$item->City.' | ';
                    $html .= '</li>';
                }
                $html .='</ul>';
            }
            return $html;
        }
    /************ END SEARCHABLE ***************************/
    
}
