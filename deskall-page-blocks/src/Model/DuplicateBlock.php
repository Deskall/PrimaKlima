<?php
use DNADesign\Elemental\Models\BaseElement;

class DuplicateBlock extends BaseElement{
	private static $inline_editable = false;
	
	private static $icon = 'font-icon-page-multiple';

    private static $description = 'Kopieren Sie einen bestehenden Block.';

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Block duplizieren');
    }
}