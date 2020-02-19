<?php


use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;

class TVOfferBlock extends TextBlock
{
    private static $icon = 'font-icon-monitor';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $help_text = "TV-Angebot Block";

    private static $table_name = 'TVOfferBlock';

    private static $singular_name = 'TV-Angebot Block';

    private static $plural_name = 'TV-Angebot Blöcke';

    private static $description = 'Zeigt TV-Angebot nach Ortschaft an';


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
       
        return $fields;
    }

   

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Zeigt TV-Angebot nach Ortschaft an');
    }


    public function activePLZ(){
        $request = Injector::inst()->get(HTTPRequest::class);
        $session = $request->getSession();
        return $session->get('active_plz');
    }

    // public function getTVOffer(){
        
    // }
}
