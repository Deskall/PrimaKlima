<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\Tab;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\File;
use Bummzack\SortableFile\Forms\SortableUploadField;
use g4b0\SearchableDataObjects\Searchable;

class DownloadBlock extends BaseElement implements Searchable
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

    private static $many_many_extraFields = [
        'Files' => ['SortOrder' => 'Int']
    ];

    private static $owns = [
        'Files',
    ];

    private static $cascade_duplicates = [];

    private static $defaults = [
        'FilesColumns' => 'uk-child-width-1-1',
        'FilesTextAlign' => 'uk-text-justify uk-text-left@s'
    ];

    // private static $files_columns = [
    //     'uk-child-width-1-1' =>  [
    //         'value' => 'uk-child-width-1-1',
    //         'title' => '1 Spalte',
    //         'icon' => '/_resources/deskall-page-blocks/images/icon-text.svg'
    //     ],
    //     'uk-child-width-1-2@s' =>  [
    //         'value' => 'uk-child-width-1-2@s',
    //         'title' => '2 Spalten',
    //         'icon' => '/_resources/deskall-page-blocks/images/icon-text-2-columns.svg'
    //     ],
    //     'uk-child-width-1-2@s uk-child-width-1-3@m' =>  [
    //         'value' => 'uk-child-width-1-2@s uk-child-width-1-3@m',
    //         'title' => '3 Spalten',
    //         'icon' => '/_resources/deskall-page-blocks/images/icon-text-3-columns.svg'
    //     ],
    //     'uk-child-width-1-1@s uk-child-width-1-4@m' =>  [
    //         'value' => 'uk-child-width-1-1@s uk-child-width-1-4@m',
    //         'title' => '4 Spalten',
    //         'icon' => '/_resources/deskall-page-blocks/images/icon-text-4-columns.svg'
    //     ],
    //     'uk-child-width-1-2@s uk-child-width-1-4@m uk-child-width-1-5@l' =>  [
    //         'value' => 'uk-child-width-1-2@s uk-child-width-1-4@m uk-child-width-1-5@l',
    //         'title' => '5 Spalten',
    //         'icon' => '/_resources/deskall-page-blocks/images/icon-text-5-columns.svg'
    //     ]
    // ];

    private static $files_columns = [
        'uk-child-width-1-1' =>  '1 Spalte',
        'uk-child-width-1-2@s' => '2 Spalten',
        'uk-child-width-1-2@s uk-child-width-1-3@m' => '3 Spalten',
        'uk-child-width-1-1@s uk-child-width-1-4@m' => '4 Spalten',
        'uk-child-width-1-2@s uk-child-width-1-4@m uk-child-width-1-5@l' => '5 Spalten'
    ];

    // private static $files_text_alignments = [
    //     'uk-text-justify uk-text-left@s' =>  [
    //         'value' => 'uk-text-justify uk-text-left@s',
    //         'title' => 'Links Ausrichtung',
    //         'icon' => '/_resources/deskall-page-blocks/images/icon-text-left-align.svg'
    //     ],
    //     'uk-text-justify uk-text-right@s' =>  [
    //         'value' => 'uk-text-justify uk-text-right@s',
    //         'title' => 'Rechts Ausrichtung',
    //         'icon' => '/_resources/deskall-page-blocks/images/icon-text-right-align.svg'
    //     ],
    //     'uk-text-justify uk-text-center@s' => [
    //         'value' => 'uk-text-justify uk-text-center@s',
    //         'title' => 'Mittel Ausrichtung',
    //         'icon' => '/_resources/deskall-page-blocks/images/icon-text-center-align.svg'
    //     ],
    //     'uk-text-justify' => [
    //         'value' => 'uk-text-justify',
    //         'title' => 'Justify Ausrichtung',
    //         'icon' => '/_resources/deskall-page-blocks/images/icon-text-justify-align.svg'
    //     ]
    // ];

    private static $files_text_alignments = [
        'uk-text-justify uk-text-left@s' => 'Links Ausrichtung',
        'uk-text-justify uk-text-right@s' => 'Rechts Ausrichtung',
        'uk-text-justify uk-text-center@s' => 'Mittel Ausrichtung',
        'uk-text-justify' => 'Justify Ausrichtung'
    ];

    


    private static $table_name = 'DownloadBlock';

    private static $singular_name = 'Dateien Downloads';

    private static $plural_name = 'Dateien Downloads';

    private static $description = 'Textblock mit Datei-Download Möglichkeiten';



    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function($fields) {
        
            $fields->removeByName('Files');
            $fields->removeByName('DownloadsTitle');
            $fields->removeByName('FilesColumns');
            $fields->removeByName('FilesTextAlign');
            $fields->removeByName('Layout');
            
            $fields->fieldByName('Root.Main.HTML')->setTitle(_t(__CLASS__ . '.ContentLabel', 'Content'))->setRows(5);

            $fields->addFieldToTab('Root.Main',CompositeField::create(
                TextField::create('DownloadsTitle',_t(__CLASS__.'.DownloadsTitle','Downloads Area Titel')),
                SortableUploadField::create('Files',_t(__CLASS__.'.Files','Dateien'))->setIsMultiUpload(true)->setFolderName($this->getFolderName())
            )->setTitle(_t(__CLASS__.'.Files','Dateien'))->setName('FilesFields'));
            $fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
                OptionsetField::create('FilesColumns',_t(__CLASS__.'.FilesInColumns','Dateien in mehreren Spalten'),$this->stat('files_columns')),
                OptionsetField::create('FilesTextAlign',_t(__CLASS__.'.FilesTextAlign','Dateien Textausrichtung'),$this->stat('files_text_alignments'))
            )->setTitle(_t(__CLASS__.'.FilesLayout','Dateien Layout'))->setName('FilesLayout'));
        });
        $fields = parent::getCMSFields();
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
/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('files_columns') as $key => $value) {
          $entities[__CLASS__.".files_columns_{$key}"] = $value;
        }       
        return $entities;
    }

/************* END TRANLSATIONS *******************/

/************* SEARCHABLE FUNCTIONS ******************/


    /**
     * Filter array
     * eg. array('Disabled' => 0);
     * @return array
     */
    public static function getSearchFilter() {
        return array();
    }

    /**
     * FilterAny array (optional)
     * eg. array('Disabled' => 0, 'Override' => 1);
     * @return array
     */
    public static function getSearchFilterAny() {
        return array();
    }


    /**
     * Fields that compose the Title
     * eg. array('Title', 'Subtitle');
     * @return array
     */
    public function getTitleFields() {
        return array('Title','DownloadsTitle');
    }

    /**
     * Fields that compose the Content
     * eg. array('Teaser', 'Content');
     * @return array
     */
    public function getContentFields() {
        return array('HTML','FileNames');
    }

    public function getFileNames(){
        $html = '';
        if ($this->Files()->count() > 0){
            $html .= '<ul>';
            foreach ($this->Files() as $file) {
                $html .= '<li>'.$file->Title.'</li>';
            }
            $html .='</ul>';
        }
        return $html;
    }
/************ END SEARCHABLE ***************************/
}
