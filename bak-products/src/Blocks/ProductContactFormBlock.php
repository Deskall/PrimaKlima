<?php

namespace Bak\Products\Blocks;

use TextBlock;
use Bak\Products\Models\ProductUseArea;
use Bak\Products\Models\ProductCategory;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\CMS\Model\SiteTree;
use Bak\Products\ProductOverviewPage;

class ProductContactFormBlock extends TextBlock
{
    private static $icon = 'font-icon-form';

    private static $help_text = "BAK Kontaktformular Block";

    private static $table_name = 'BAK_ProductContactFormBlock';

    private static $singular_name = 'Kontaktformular Block';

    private static $plural_name = 'Kontaktformular Blöcke';

    private static $description = 'BAK Kontaktformular Block';

    private static $db = [
        'ReceiverEmail' => 'Varchar(255)',
        'EmailSentFrom' => 'Varchar(255)',
        'SubjectEmail' => 'Varchar(255)',
        'SubjectEmailConfirmation' => 'Varchar(255)',
        'TextEmail' => 'Text',
        'TextEmailConfirmation' => 'Text'
    ];

    private static $has_one = ['RelatedPage' => SiteTree::class];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', new TextField('ReceiverEmail', 'E-Mail Empfänger (kommagetrennt)'));
        $fields->addFieldToTab('Root.Main', new TextField('EmailSentFrom', 'E-Mail Absender'));
        $fields->addFieldToTab('Root.Main', new TextField('SubjectEmail', 'E-Mail Betreff'));
        $fields->addFieldToTab('Root.Main', new TextField('SubjectEmailConfirmation', 'E-Mail Betreff Bestätigung'));
        $fields->addFieldToTab('Root.Main', new TextareaField('TextEmail', 'E-Mail Text'));
        $fields->addFieldToTab('Root.Main', new TextareaField('TextEmailConfirmation', 'E-Mail Text Bestätigung'));
        $fields->addFieldToTab('Root.Main', new TreeDropdownField('RelatedPageID', 'Resultat Seite', SiteTree::class));
        return $fields;
    }


    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'BAK Kontaktformular Block');
    }

    public function ProductPageLink(){
        return ProductOverviewPage::get()->first()->Link();
    }


}
