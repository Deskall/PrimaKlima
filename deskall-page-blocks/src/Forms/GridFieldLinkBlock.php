<?php
/**
 * A component which lets the user select from a list of blocks to link.
 *
 *
 */

use SilverStripe\Forms\GridField\GridField_HTMLProvider;
use SilverStripe\Forms\GridField\GridField_URLHandler;
use Symbiote\GridFieldExtensions\GridFieldExtensions;
use SilverStripe\Forms\GroupedDropdownField;
use SilverStripe\View\ArrayData;
use SilverStripe\Control\Controller;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;

class GridFieldLinkBlock implements GridField_HTMLProvider, GridField_URLHandler {

	private static $allowed_actions = array(
		'handleLink'
	);

	// Should we add an empty string to the add class dropdown?
	private static $showEmptyString = true;

	private $fragment;

	private $title;

	/**
	 * @var string
	 */
	protected $itemRequestClass = 'GridFieldLinkBlockHandler';

	/**
	 * @param string $fragment the fragment to render the button in
	 */
	public function __construct($fragment = 'before') {
		$this->setFragment($fragment);
		$this->setTitle(_t('GridFieldExtensions.Link', 'Verknüpfen'));
	}

	/**
	 * Gets the fragment name this button is rendered into.
	 *
	 * @return string
	 */
	public function getFragment() {
		return $this->fragment;
	}

	/**
	 * Sets the fragment name this button is rendered into.
	 *
	 * @param string $fragment
	 * @return GridFieldAddNewMultiClass $this
	 */
	public function setFragment($fragment) {
		$this->fragment = $fragment;
		return $this;
	}

	/**
	 * Gets the button title text.
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the button title text.
	 *
	 * @param string $title
	 * @return GridFieldAddNewMultiClass $this
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	/**
	 *
	 */
	public function handleLink($grid, $request) {
		$id   = $request->param('ID');
		$pageid = $request->param('PAGEID');
		$recordClass = $grid->getForm()->record->ClassName;
		if($id){
			$block = DataObject::get_by_id('DNADesign\Elemental\Models\BaseElement',$id);
			if (!$block){
				throw new Exception('Diese Block war nicht gefunden');
			}
			
			if (!$pageid){
				throw new Exception('Diese Seite war nicht gefunden');
			}
			$page = DataObject::get_by_id(SiteTree::class,$pageid);
			if (!$page){
				throw new Exception('Diese Seite war nicht gefunden');
			}
				
			$virtual = ElementVirtual::create();
            $virtual->LinkedElementID = $block->ID;
			$virtual->ParentID = $page->ElementalAreaID;
			$virtual->write();

			return $grid->getForm()->getController()->redirectBack('admin/pages/edit/show/'.$pageid);
		}
	}


	/**
	 * {@inheritDoc}
	 */
	public function getHTMLFragments($grid) {

		GridFieldExtensions::include_requirements();
		

		$blockfield = GroupedDropdownField::create('Block', '', $this->getBlockTree());
		$blockfield->addExtraClass('no-change-track');

		$data = new ArrayData(array(
			'Title'      => $this->getTitle(),
			'Link'       => Controller::join_links($grid->Link(), 'link-block', '{id}', '{pageid}'),
			'BlockField' => $blockfield
		));

		return array(
			$this->getFragment() => $data->renderWith('Forms/'.__CLASS__)
		);
	}

	protected function getBlockTree(){
		$blockstree = array(0 => _t(__CLASS__.'.Label','bestehende Block verknüpfen'));
		$Pages = Page::get()->sort('ParentID ASC, Sort ASC');
		foreach ($Pages as $page) {
			if ($page->ElementalAreaID > 0){
				$blocks = array();
				foreach ($page->ElementalArea()->Elements() as $block) {
					$blocks[$block->ID] = $block->singleton($block->ClassName)->getType(). " > ".$block->NiceTitle();
				}
				//build the page unique sitetree strucuture
				$pageTree = $page->NestedTitle(4," > ");
			
				$blockstree[$pageTree] = $blocks;
			}
		}
		return $blockstree;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getURLHandlers($grid) {
		return array(
			'link-block/$ID/$PAGEID' => 'handleLink'
		);
	}

	public function setItemRequestClass($class) {
	  $this->itemRequestClass = $class;
	  return $this;
	}

}
