<?php

use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\Control\HTTPRequest;

class PortfolioController extends PageController
{

    private static $allowed_actions = ['fetchReference'];

    protected function init()
    {
        parent::init();
        // You can include any CSS or JS required by your project here.
        // See: https://docs.silverstripe.org/en/developer_guides/templates/requirements/
    }

    public function fetchReference(HTTPRequest $request){
        $id = $request->getVar('ReferenceID');
        $ref = PortfolioClient::get()->byId($id);
        if ($ref){
            return $ref->renderWith('Includes/PortfolioClient');
        }
        ob_start();
                    print_r('ici');
                    $result = ob_get_clean();
                    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
        return null;
    }

    
}
