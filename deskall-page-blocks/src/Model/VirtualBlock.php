<?php

use DNADesign\ElementalVirtual\Model\ElementVirtual;
use DNADesign\ElementalVirtual\Control\ElementVirtualLinkedController;

class VirtualBlock extends ElementVirtual{
	private static $icon = 'font-icon-link';

	private static $table_name = 'VirtualBlock';

    private static $singular_name = 'Virtual block';

    private static $controller_template = 'DefaultHolder';

    private static $controller_class = BlockController::class;

    private static $plural_name = 'Virtual blocks';

    private static $description = 'Verknüpfen Sie einen bestehenden Block.';

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Block verknüpfen');
    }

    public function RenderPreview(){
    	return $this->LinkedElement()->getEditorPreview();
    }

     /**
     * @return \SilverStripe\ORM\FieldType\DBHTMLText
     */
    public function getEditorPreview()
    {
    	print_r('ici');
        $templates = [];
        $templates[] = __CLASS__ . '_EditorPreview';

        return $this->renderWith($templates);
    }
}