<?php
/**
 * A content-block that contains N images
 * @author deskall
 */
class NewsBlock extends Block
{
	private static $db = array(
		'Status' => 'VarChar(255)',
		'Sort' => 'VarChar(255)'
	);

	static $many_many = array(
		'Categories' => 'NewsCategory'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('Anchor');
		$fields->addFieldToTab('Root.Main', CheckboxSetField::create('Status', 'News status', array('Published' => 'Nur veröffentlichte News anzeigen', 'Archived' => 'Nur archivierte News anzeigen','beide' => 'veröffentlichte und archivierte anzeigen')));
        $fields->addFieldToTab('Root.Main', DropdownField::create('Sort', 'News Anordnung', array('PublishDate' => 'Datum der Veröffentlichung', 'Title' => 'Titel','SortOrder' => 'Anordnung wie die Adminliste')));
		return $fields;
	}

	public function NewsPublished($status){
          $postalcodes = array();
          if( Subsite::currentSubsiteID() > 0 ){
            $postalcodes = Subsite::currentSubsite()->PostalCodes()->column('ID');
          }

          $withCode = ManyManyList::create('News','News_PostalCodes','NewsID','PostalCodeID');
          if (count($postalcodes) > 0){
            $withCode = $withCode->exclude('PostalCodeID',$postalcodes);
          }

          $withCodeIds = $withCode->column('ID');


		switch ($this->Sort) {
        	case 'PublishDate':
        		$sort = 'PublishDate';
        		$order = 'DESC';
        		break;
        	case 'Title':
        		$sort ='Title';
        		$order = 'ASC';
        		break;
        	case 'SortOrder':
        		$sort = 'SortOrder';
        		$order = 'ASC';
        		break;
        }
        switch ($status) {
            case 'beide':
                $news = News::get()->where(array('Status != ?' => "ToBePublished"))->exclude('ID',$withCodeIds)->sort($sort,$order);
                break;
            case 'Published':
            case 'Archived':
                $news = News::get()->where(array('Status = ?' => $status))->exclude('ID',$withCodeIds)->sort($sort,$order);
                break;
            default:
                $news = News::get()->where(array('Status != ?' => "ToBePublished"))->exclude('ID',$withCodeIds)->sort($sort,$order);
                break;
        }
        return $news;
    }

}







