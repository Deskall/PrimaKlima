<?php
/**
 * A component which lets the user select from a list of blocks to create a duplicate.
 *
 *
 */
class GridFieldDuplicateBlock implements GridField_HTMLProvider, GridField_URLHandler {

	private static $allowed_actions = array(
		'handleDuplicate'
	);

	// Should we add an empty string to the add class dropdown?
	private static $showEmptyString = true;

	private $fragment;

	private $title;

	/**
	 * @var string
	 */
	protected $itemRequestClass = 'GridFieldDuplicateBlockHandler';

	/**
	 * @param string $fragment the fragment to render the button in
	 */
	public function __construct($fragment = 'before') {
		$this->setFragment($fragment);
		$this->setTitle(_t('GridFieldExtensions.Duplicate', 'Duplizieren'));
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
	public function handleDuplicate($grid, $request) {
		$id   = $request->param('ID');
		$pageid = $request->param('PAGEID');
		if($id){
			$block = DataObject::get_by_id('Block',$id);
			if (!$block){
				throw new Exception('Diese Block war nicht gefunden');
			}
			if (!$pageid){
				throw new Exception('Diese Seite war nicht gefunden');
			}

			$newBlock = $block->duplicate();

			$newBlock->ParentID = $pageid;
			$newBlock->write();

			//Copy also linked objects
			switch($newBlock->ClassName){
				case "LinkListBlock":
					if ($block->LinkList()){
						foreach($block->LinkList() as $linkitem){
							$newLink = $linkitem->duplicate();
							$newLink->ListeID = $newBlock->ID;
							$newLink->write();
						}
					}
				break;
				//@to do: other block with linked objects (news,..)
			}
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
			'Link'       => Controller::join_links($grid->Link(), 'duplicate-block', '{id}', '{pageid}'),
			'BlockField' => $blockfield
		));

		return array(
			$this->getFragment() => $data->renderWith(__CLASS__)
		);
	}

	protected function getBlockTree(){
		$blockstree = array(0 => 'Bitte Block auswählen');
		$Pages = Page::get()->sort('ParentID ASC, Sort ASC');
		foreach ($Pages as $page) {
			if ($page->Blocks()){
				$blocks = array();
				foreach ($page->Blocks() as $block) {
					$blocks[$block->ID] = $block->singleton($block->ClassName)->i18n_singular_name(). " > ".$block->printURLSegment();
				}
				//build the page unique sitetree strucuture
				$pageTree = $page->Title;
				$pointerToParent = $page->Parent();
				while ($pointerToParent->Title){
					$pageTree = $pointerToParent->Title. " > ".$pageTree;
					$pointerToParent = $pointerToParent->Parent();
				}
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
			'duplicate-block/$ID/$PAGEID' => 'handleDuplicate'
		);
	}

	public function setItemRequestClass($class) {
	  $this->itemRequestClass = $class;
	  return $this;
	}

}
