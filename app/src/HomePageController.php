<?php

namespace SilverStripe\Lessons;

use PageController;

class HomePageController extends PageController
{
    //accepts count whose default value is 3
    public function LatestArticles($count = 3) {
        return ArticlPage::get()
                    ->sort('Created', 'DESC')
                    ->limit($count);
    }
}
