<?php

namespace {

    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\TextField;
    use SilverStripe\Forms\EmailField;
    use SilverStripe\Forms\FormAction;
    use SilverStripe\Forms\Form;
    use SilverStripe\Forms\RequiredFields;
    use SilverStripe\Control\Email\Email;
    use SilverStripe\SiteConfig\SiteConfig;
    use SilverStripe\Dev\Debug;

    class PageController extends ContentController
    {
        
        private static $allowed_actions = ['UserForm'];

        protected function init()
        {
            parent::init();
            
        }

            //Form, fields and submision
        public function UserForm() 
        { 
            $namefield = new TextField('Name');

            $namefield 
                    ->setMaxLength(20)
                    ->setAttribute('placeholder', 'Name')
                    ->setAttribute('style', 'width:200px');

            $emailfield = new EmailField('Email');

            $emailfield 
                    ->setMaxLength(30)
                    ->setAttribute('placeholder', 'Email')
                    ->setAttribute('style', 'width:200px');

            $companyfield = new TextField('Company');
            $companyfield 
                    ->setMaxLength(30)
                    ->setAttribute('placeholder', 'Company')
                    ->setAttribute('style', 'width:400px');
          
            $fields = new FieldList($namefield, $emailfield, $companyfield); 

            $actions = new FieldList( 
                new FormAction('submitForm', 'Submit') 
            ); 

            $required = new RequiredFields('Name','Email');

            $form = new Form($this, 'UserForm', $fields, $actions, $required); 
            
            return $form;
        }

            //submitting the form
         public function submitForm($data, $form) {
            
            // Send an email notification 
            $sendTo = 'steve@toast.co.nz';
            $email = new Email();
            $email->setTo($sendTo);
            $email->setFrom($data['Email']);
            $email->setSubject('JaysPage - User Submission');
            $message = "
                <p><strong>Name:</strong> {$data['Name']}</p>
                <p><strong>Email:</strong> {$data['Email']}</p>
                <p><strong>Company:</strong> {$data['Company']}</p>
            ";
            
            $email->setBody($message);
            $email->send();

            // Create a record in the DB
            $submission = UserData::create();
            $form->saveInto($submission);
            $submission->write();

            return [
            'UserForm' => 'Thank you for your submission.',
            'Form' => ''
            ];
        }
    }
}
