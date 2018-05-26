<?php

use DNADesign\Elemental\ElementalEditor;

/** Remove DNADesign Exsiting Field input from GRid (replaced by our own Virtual Block)**/
ElementalEditor::remove_extension('DNADesign\ElementalVirtual\Extensions\ElementalEditorExtension');