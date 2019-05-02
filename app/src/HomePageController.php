<?php

namespace SilverStripe\Lessons;

use PageController;

class HomePageController extends PageController
{
    //accepts count whose default value is 3
    public function LatestArticles($count = 3) {
        return ArticlePage::get()
                    ->sort('Created', 'DESC')
                    ->limit($count);
    }

    public function FeaturedProperties() {
        return Property::get()
            ->filter(array(
                'FeaturedOnHomepage' => true
            ))
            ->limit(6);
    }
}
