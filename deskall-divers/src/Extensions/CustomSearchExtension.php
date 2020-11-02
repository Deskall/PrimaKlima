<?php

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\CMS\Controllers\ModelAsController;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\CMS\Search\SearchForm;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Convert;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\Connect\MySQLDatabase;
use SilverStripe\SQLite\SQLite3Database;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\PaginatedList;

/**
 * Extension to provide a search interface when applied to ContentController
 *
 * @package cms
 * @subpackage search
 */
class CustomSearchExtension extends Extension
{

    /**
     * Site search form
     */
    public function SearchForm()
    {
        $form = new SearchForm($this->owner->getControllerForSearchForm(), 'SearchForm', $this->owner->getSearchFields(), $this->owner->getSearchActions());
        $form->setTemplate("Forms/search_form")->addExtraClass("uk-width-1-1 search-form");
        return $form;
    }



    /**
     * generates the fields for the SearchForm
     * @uses updateSearchFields
     * @return FieldList
     */
    public function updateSearchFields($fields)
    {
        foreach ($fields as $field) {
            $field->setAttribute('class','uk-input uk-width-auto uk-padding-small')->setValue("")->setAttribute("placeholder",_t('Search.PLACEHOLDER','Suche auf dieser Website...'));
        }
    }

    public function updateSearchActions($actions){
        foreach ($actions as $action){
            $action->addExtraClass('uk-button uk-button-primary uk-width-auto uk-padding-small uk-padding-remove');
            $action->addExtraClass('dk-button-icon')->setUseButtonTag(true)->setTitle('')
            ->setAttribute('data-uk-icon','chevron-right');
        }
    }
    
    public function getSearchResults($request, $data = [], $form = null)
    {
    // check that Fulltext is enabled
        if (!$this->owner->isFulltextSupported()) {
            // empty result if not
            return PaginatedList::create(ArrayList::create());
        }

        $conn = DB::get_conn();
        $list = new ArrayList();

        // get search query
        $q = (isset($data['Search'])) ? $data['Search'] : $request->getVar('Search');

        $input = Convert::raw2sql($q);

        // if ($conn instanceof SQLite3Database) {
        //     // query using SQLite FTS
        //     $query = "SELECT * FROM \"SearchableDataObjects\" WHERE \"SearchableDataObjects\" MATCH '$input'";
        // } else {
        //     // query using MySQL Fulltext
        //     $query = "SELECT * FROM \"SearchableDataObjects\" WHERE MATCH (\"Title\", \"Content\") AGAINST ('$input' IN NATURAL LANGUAGE MODE)";
        // }

        //if multiple terms we look first for all
        $matchAll = str_replace(' ', '%', $input);

        if ($conn instanceof SQLite3Database) {
            // query using SQLite FTS
            $query = "SELECT * FROM \"SearchableDataObjects\" WHERE \"SearchableDataObjects\" LIKE '$matchAll'";
        } else {
            // query using MySQL Fulltext
            $query = "SELECT * FROM \"SearchableDataObjects\" WHERE \"Title\" LIKE '$matchAll' OR \"Content\" LIKE '$matchAll'";
        }

       

        // if ($conn instanceof SQLite3Database) {
        //     // query using SQLite FTS
        //     $query = "SELECT * FROM \"SearchableDataObjects\" WHERE \"SearchableDataObjects\" LIKE '%$input%'";
        // } else {
        //     // query using MySQL Fulltext
        //     $query = "SELECT * FROM \"SearchableDataObjects\" WHERE \"Title\" LIKE '%$input%' OR \"Content\" LIKE '%$input%'";
        // }

        $results = DB::query($query);
        ob_start();
                    print_r($results);
                    $result = ob_get_clean();
                    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
        //If no matches
        if (!$results){
            $inputs = explode(' ',$input);
            $query = "SELECT * FROM \"SearchableDataObjects\"  WHERE";
            if ($conn instanceof SQLite3Database) {
                $i = 1;
                foreach ($inputs as $key => $value) {
                    $query .= "\"SearchableDataObjects\" LIKE '%$value%'";
                    if ($i < count($inputs)){
                        $query .= " AND ";
                    }
                    $i++;
                }
            } else {
                $i = 1;
                foreach ($inputs as $key => $value) {
                    $query .= "(\"Title\" LIKE '%$value%' OR \"Content\" LIKE '%$value%')";
                    if ($i < count($inputs)){
                        $query .= " AND ";
                    }
                    $i++;
                }
            }
            ob_start();
                        print_r($query);
                        $result = ob_get_clean();
                        file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
        }

        $results = DB::query($query);

        foreach ($results as $row) {
            $do = DataObject::get_by_id($row['ClassName'], $row['ID']);

            /*
             * Check that we have been returned a valid DataObject, using the
             * ClassName and ID stored in the SortableDataObject DB table, to
             * prevent PHP notice:
             *
             *      [Strict Notice] Creating default object from empty value
             *
             * caused when DataObject::get_by_id() returns false
             */
            if (is_object($do) && $do->exists() && $this->owner->shouldDisplay($do)) {
                $do->Title = htmlspecialchars_decode($row['Title']);
                $do->Content = htmlspecialchars_decode($row['Content']);

                $list->push($do);
            }
        }

        $pageLength = Config::inst()->get('g4b0\SearchableDataObjects\CustomSearch', 'items_per_page');
        $ret = new PaginatedList($list, $request);
        $ret->setPageLength($pageLength);

        return $ret;
    }

    public function results($data, $form, $request)
    {
        $data = array(
                'Results' => $this->getSearchResults($request, $data),
                'Query' => $form->getSearchQuery(),
                'Title' => _t('CustomSearch.SEARCHRESULTS', 'Risultati della ricerca')
        );

        return $this->owner->customise($data)->renderWith(array('Page_results', 'Page'));
    }

    public function shouldDisplay($do){
        $excludeClasses = Config::inst()->get('g4b0\SearchableDataObjects\CustomSearch', 'exclude_from_search');
        $page = ($do->baseClass() == "SilverStripe\CMS\Model\SiteTree") ? $do : $do->getRealPage();
        if (!$page || $page->ID <= 0 ){
            return false;
        }
        if (is_array($excludeClasses) && in_array($do->ClassName,$excludeClasses)){
            return false;
        }
        if ($do->hasExtension('Activable') && !$do->isVisible){
            return false;
        }
        //To add if subsite
        // if ($page->hasExtension('SiteTreeSubsites') && $page->SubsiteID != Subsite::currentSubsiteID()){
        // }

        //check that not already in the list
        if (!$page->notInListYet( $do->Link() )){
            return false;
        }
        return true;
    }
}
