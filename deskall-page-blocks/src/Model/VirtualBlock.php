<?php

use DNADesign\ElementalVirtual\Model\ElementVirtual;
use DNADesign\ElementalVirtual\Control\ElementVirtualLinkedController;

class VirtualBlock extends ElementVirtual{
	private static $icon = 'font-icon-link';

	private static $controller_class = BlockController::class;

    private static $table_name = 'VirtualBlock';

    private static $singular_name = 'Vitual block';

    private static $plural_name = 'Virtual blocks';

    private static $description = 'Verknüpfen Sie einen bestehenden Block.';

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Block verknüpfen');
    }
}