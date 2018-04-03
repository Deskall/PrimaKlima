<?php

use SilverStripe\Admin\ModelAdmin;

class LayoutAdmin extends ModelAdmin 
{

    private static $managed_models = [
        'FooterBlock',
        'MenuBlock'
    ];

    private static $url_segment = 'layout';

    private static $menu_title = 'Global Seite Layout';
}