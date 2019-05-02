<?php

namespace SilverStripe\Lessons;

use SilverStripe\Admin\ModelAdmin;

// ModelAdmin interface gives us a place to hang all Property records.
class PropertyAdmin extends ModelAdmin {

    // The title that will appear in the left-hand menu of the CMS.
    private static $menu_title = 'Properties';

    // The URL part that will follow admin/ to access this section
    private static $url_segment = 'properties';

    // An array of class names that will be managed.
    // Each one is placed on its own tab across the top of the screen.
    private static $managed_models = [
        Property::class,
    ];

    private static $menu_icon = 'icons/property.png';
}
