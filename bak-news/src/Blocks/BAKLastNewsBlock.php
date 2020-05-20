<?php

namespace Bak\News\Blocks;

use TextBlock;
use Bak\News\NewsPage;


class BAKLastNewsBlock extends TextBlock
{
    private static $icon = 'font-icon-news';

    private static $help_text = "Letzte Neuigkeiten Block";

    private static $table_name = 'BAK_NewsBlock';

    private static $singular_name = 'News Block';

    private static $plural_name = 'News Blöcke';

    private static $description = 'Letzte Neuigkeiten Block';

    private static $db = ['test' => 'Varchar'];


    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'BAK - Letzte Neuigkeiten Block');
    }


    public function News(){
        return NewsPage::get()->limit(3);
    }

}
