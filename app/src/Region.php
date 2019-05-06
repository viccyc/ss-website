<?php

namespace SilverStripe\Lessons;

use SilverStripe\Control\Controller;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Versioned\Versioned;

class Region extends DataObject {

    private static $db = [
        'Title' => 'Varchar',
        'Description' => 'HTMLText',
    ];

    private static $has_one = [
        'Photo' => Image::class,
        'RegionsPage' => RegionsPage::class,
    ];

    private static $owns = [
        'Photo',
    ];

    private static $extensions = [
        Versioned::class,
    ];

    private static $summary_fields = [
        'GridThumbnail' => '',
        'Title' => 'Title of region',
        'Description' => 'Short description',
    ];

    // gets the full array of publishing actions ("Save", "Publish", "Archive", etc.)
    private static $versioned_gridfield_extensions = true;

    public function getCMSFields()
    {
        $fields = FieldList::create(
          TextField::create('Title'),
          HTMLEditorField::create('Description'),
          $uploader = UploadField::create('Photo')
        );

        $uploader->setFolderName('region-photos');
        $uploader->getValidator()->setAllowedExtensions(['png','gif','jpeg','jpg']);

        return $fields;
    }

    public function getGridThumbnail() {
        if($this->Photo()->exists()) {
            return $this->Photo()->ScaleWidth(100);
        }

        return "(no image)";
    }

    public function Link() {
        return $this->RegionsPage()->Link('show/'.$this->ID);
    }

    public function LinkingMode() {
        // gets the currently active controller
        return Controller::curr()->getRequest()->param('ID') == $this->ID ? 'current' : 'link';
    }
}
