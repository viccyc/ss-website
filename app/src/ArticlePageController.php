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
              TextField::create('Name', ''),
              EmailField::create('Email', ''),
              TextareaField::create('Comment', '')
          ),
          FieldList::create(
              FormAction::create('handleComment', 'Post Comment')
                  // force it to render a <button> instead of an <input>
                  ->setUseButtonTag(true)
                  ->addExtraClass('btn btn-default-color btn-lg')
          ),
          RequiredFields::create('Name', 'Email', 'Comment')
        )

        ->addExtraClass('form-style');

        // add the extra classes and placeholders dynamically.
        foreach ($form->Fields() as $field) {
            $field->addExtraClass('form-control')
                ->setAttribute('placeholder', $field->getName().'*');
        }
        return $form;
    }
}
