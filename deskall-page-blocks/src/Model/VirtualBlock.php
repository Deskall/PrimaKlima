<?php

use DNADesign\ElementalVirtual\Model\ElementVirtual;

class VirtualBlock extends ElementVirtual{
	private static $icon = 'font-icon-link';

    private static $description = 'Verknüpfen Sie einen bestehenden Block.';

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'bestehende Block');
    }
}