<?php

namespace SilverStripe\Lessons;

use PageController;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;

class ArticlePageController extends PageController
{
    // Since this is a public method on the controller,
    // we can add it to the template by calling $CommentForm
    public function CommentForm() {
        $form = Form::create(
          // controller
          $this,
          // name of method that creates the form
          __FUNCTION__,
          //  leaving the labels for the fields blank as they're added with placeholder attributes
          FieldList::create(
              TextField::create('Name', '')
                  ->setAttribute('placeholder','Name*'),
              EmailField::create('Email', '')
                  ->setAttribute('placeholder','Email*'),
              TextareaField::create('Comment', '')
                  ->setAttribute('placeholder','Comment*')
          ),
          FieldList::create(
              FormAction::create('handleComment', 'Post Comment')
          ),
          RequiredFields::create('Name', 'Email', 'Comment')
        );

        return $form;
    }
}
