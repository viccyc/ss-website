<?php

namespace SilverStripe\Lessons;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CurrencyField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\ArrayLib;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\TabSet;
use SilverStripe\Versioned\Versioned;

class Property extends DataObject {

    private static $db = [
        'Title' => 'Varchar',
        'PricePerNight' => 'Currency',
        'Bedrooms' => 'Int',
        'Bathrooms' => 'Int',
        'FeaturedOnHomepage' => 'Boolean'
    ];

    private static $has_one = [
        'Region' => Region::class,
        'PrimaryPhoto' => Image::class,
    ];

    // control what fields display in list view
    private static $summary_fields = [
        'Title' => 'Title',
        'Region.Title' => 'Region',
        // nicely formatted price with a currency symbol, commas, and decimal values
        'PricePerNight.Nice' => 'Price',
        'FeaturedOnHomepage.Nice' => 'Featured?'
    ];

    // make sure it gets published
    private static $owns = [
        'PrimaryPhoto',
    ];

    // ensure they have a draft state
    private static $extensions = [
        Versioned::class,
    ];

    private static $versioned_gridfield_extensions = true;

    // customized search form in the CMS
    public function searchableFields()
    {
        // need to be more explicit about how we want our search form configured
        // available filters are in framework/src/ORM/Filters
        return [
            'Title' => [
                'filter' => 'PartialMatchFilter',
                'title' => 'Title',
                'field' => TextField::class,
            ],
            'RegionID' => [
                'filter' => 'ExactMatchFilter',
                'title' => 'Region',
                'field' => DropdownField::create('RegionID')
                    ->setSource(
                        Region::get()->map('ID', 'Title')
                    )
                    ->setEmptyString('-- Any region --')
            ],
            'FeaturedOnHomepage' => [
                'filter' => 'ExactMatchFilter',
                'title' => 'Only featured'
            ]
        ];
    }


    public function getCMSFields()
    {
        $fields = FieldList::create(TabSet::create('Root'));
        $fields->addFieldsToTab('Root.Main', [
            TextField::create('Title'),
            CurrencyField::create('PricePerNight', 'Price (per night)'),
            DropdownField::create('Bedroom')
                ->setSource(ArrayLib::valuekey(range(1,10))),
            DropdownField::create('Bathroom')
                ->setSource(ArrayLib::valuekey(range(1,10))),
            // DropdownField is multipurpose, doesn't just work with data relationships
            // so doesn't know how to resolve the name of a relationship to a db column
            // like UploadField further down, so need RegionID
            DropdownField::create('RegionID', 'Region')
                ->setSource(Region::get()->map('ID', 'Title')),
            CheckboxField::create('FeaturedOnHomePage', 'Feature on homepage')
        ]);

        $fields->addFieldToTab('Root.Photos', $upload = UploadField::create(
            'PrimaryPhoto',
            'Primary Photo'
        ));

        $upload->getValidator()->setAllowedExtensions(array(
            'png','jpeg','jpg','gif'
        ));

        $upload->setFolderName('property-photos');

        return $fields;
    }
}
