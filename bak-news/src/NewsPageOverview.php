<?php

namespace Bak\News;

use Page;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataObject;
use Bak\News\Models\NewsCategory;
use Bak\News\Models\News;
use Bak\News\Controllers\NewsPageController;

class NewsPageOverview extends Page {

    private static $table_name="BAK_NewsPageOverview";

    private static $allowed_children = [NewsPage::class];

    private static $icon = "bak-news/img/news.png";
}

  

