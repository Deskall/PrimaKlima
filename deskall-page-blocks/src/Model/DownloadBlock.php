<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\Tab;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\File;

class DownloadBlock extends BaseElement
{
    private static $icon = 'font-icon-install';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText',
        'DownloadsTitle' => 'Varchar(255)',
        'FilesTextAlign' => 'Varchar(255)',
        'FilesColumns' => 'Varchar(255)'
    ];

    private static $many_many = [
        'Files' => File::class
    ];

    private static $many_many_extra_fields = [
        'Files' => ['SortOrder' => 'Int']
    ];

    private static $owns = [
        'Files',
    ];

    private static $files_columns = [
        ' ' => 'Keine Spalten',
        'uk-column-1-2@s' => 'Display the content in two columns',
        'uk-column-1-2@s uk-column-1-3@m' => 'Display the content in three columns',
        'uk-column-1-2@s uk-column-1-4@m' => 'Display the content in four columns',
        'uk-column-1-2@s uk-column-1-4@m uk-column-1-5@l' => 'Display the content in five columns',
        'uk-column-1-2@s uk-column-1-4@m uk-column-1-6@l' => 'Display the content in six columns'
    ];
    


    private static $table_name = 'DownloadBlock';

    private static $singular_name = 'Dateien Downloads';

    private static $plural_name = 'Dateien Downloads';

    private static $description = 'Textblock mit Datei-Download Möglichkeiten';



    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->removeByName('Files');
            $fields->removeByName('DownloadsTitle');
            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Content'));
            
        });
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root',new Tab('Files',_t(__CLASS__.'FilesTab', 'Dateien')),'Settings');
        $fields->addFieldToTab('Root.Files',TextField::create('DownloadsTitle','Downloads Area Titel'));
        $fields->addFieldToTab('Root.Files',UploadField::create('Files','Dateien')->setIsMultiUpload(true)->setFolderName($this->getFolderName(),'HTML'));
        $fields->addFieldToTab('Root.Files',DropdownField::create('FilesColumns','Dateien in mehreren Spalten',static::$files_columns));
        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Download Area');
    }

}
