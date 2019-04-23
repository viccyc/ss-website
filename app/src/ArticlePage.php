<?php

namespace SilverStripe\Lessons;

use Page;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\Forms\CheckboxSetField;
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

	private static $has_one = [
	    'Photo' => Image::class,
        'Brochure' => File::class
    ];

	private static $owns = [
	    'Photo',
        'Brochure',
    ];

	private static $many_many = [
	    'Categories' => ArticleCategory::class,
    ];

	public function getCMSFields() {
	    $fields = parent::getCMSFields();
	    $fields->addFieldToTab('Root.Main', DateField::create('Date', 'Date of article'), 'Content');
	    $fields->addFieldToTab('Root.Main', TextareaField::create('Teaser')
            ->setDescription('This is the summary that appears on the article list page.'), 'Content');
	    $fields->addFieldToTab('Root.Main', TextField::create('Author', 'Author of article'), 'Content');
	    $fields->addFieldToTab('Root.Attachments', $photo = UploadField::create('Photo'));
	    $fields->addFieldToTab('Root.Attachments', $brochure = UploadField::create('Brochure', 'Travel brochure, optional (PDF only)'));
        $fields->addFieldToTab('Root.Categories', CheckboxSetField::create(
           'Categories',
           'Selected categories',
           $this->Parent()->Categories()->map('ID','Title') //create an array that maps each category's ID to its Title
        ));

	    $photo->setFolderName('travel-photos');
        $brochure
            ->setFolderName('travel-brochures')
            ->getValidator()->setAllowedExtensions(['pdf']);

        return $fields;
    }

    public function CategoriesList() {
	    if($this->Categories()->exists()) {
            // gets an array of all the values for the given column
	        return implode(', ', $this->Categories()->column('Title'));
        }

	    return null;
    }
}
