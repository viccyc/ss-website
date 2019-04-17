<?php

namespace SilverStripe\Lessons;

use Page;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;

class ArticlePage extends Page
{
	private static $can_be_root = false;

	private static $db = [
	    'Date' => 'Date.Nice',
        'Teaser' => 'Text',
        'Author' => 'Varchar',
    ];

	public function getCMSFields() {
	    $fields = parent::getCMSFields();
	    $fields->addFieldsToTab('Root.Main', DateField::create('Date', 'Date of article'), 'Content');
	    $fields->addFieldsToTab('Root.Main', TextareaField::create('Teaser')
            ->setDescription('This is the summary that appears on the article list page.'), 'Content');
	    $fields->addFieldsToTab('Root.Main', TextField::create('Author', 'Author of article'), 'Content');

	    return $fields;
    }
}
