<?php

use DNADesign\ElementalVirtual\Model\ElementVirtual;

class VirtualBlock extends ElementVirtual{
	private static $icon = 'font-icon-page-multiple';

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'bestehende Block verknüpfen');
    }
}