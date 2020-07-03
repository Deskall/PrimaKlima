<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\SiteConfig\SiteConfig;

class PayTVBlock extends TextBlock
{
    private static $icon = 'font-icon-circle-star';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $help_text = "PayTV Pakete Block";

    private static $table_name = 'PayTVBlock';

    private static $singular_name = 'PayTV Pakete Block';

    private static $plural_name = 'PayTV Pakete Blöcke';

    private static $description = 'Zeigt Premiumsender Pakete';

    private static $db = [
        'Height' => 'Varchar'
    ];


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main',DropdownField::create('Height','Premiumsender List Höhe',['small' => 'Kleine', '' => 'Standard', 'big' => 'Gross']));

        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Zeigt Premiumsender Pakete an');
    }

    public function getPayTVPackages(){
        $paytv = ProductOption::get()->filter('ProductCode','pay-tv-pakete')->first();
        if ($paytv){
            return $paytv->Options();
        }
        return null;
    }


    

    /************* SEARCHABLE FUNCTIONS ******************/

        /**
         * Fields that compose the Content
         * eg. array('Teaser', 'Content');
         * @return array
         */
        public function getContentFields() {
            return array('HTML','PackageContent');
        }

        public function getPackageContent(){
            $html = '';
            $packages = $this->getPayTVPackages();
            if ($packages){
                $html .= '<ul>';
                foreach ($packages as $item) {
                    $html .= '<li>';
                    $html .= $item->Title.' '.$item->Subtitle;
                    $html .= ' | ';
                    $html .= '</li>';
                }
                $html .='</ul>';
            }
            return $html;
        }
    /************ END SEARCHABLE ***************************/
}
